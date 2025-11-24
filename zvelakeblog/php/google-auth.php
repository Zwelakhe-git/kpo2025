<?php
session_start();

// Fix the file paths - adjust according to your actual file structure
$rootPath = dirname(dirname(__FILE__));

// Try different possible locations for database.php
$databasePaths = [
    $rootPath . '/config/database.php',
    $rootPath . '/admin/config/database.php', 
    $rootPath . '/../config/database.php',
    dirname(__FILE__) . '/../config/database.php',
    dirname(__FILE__) . '/../../config/database.php'
];

$databaseLoaded = false;
foreach ($databasePaths as $dbPath) {
    if (file_exists($dbPath)) {
        require_once $dbPath;
        $databaseLoaded = true;
        break;
    }
}

if (!$databaseLoaded) {
    die("Database configuration file not found. Checked paths: " . implode(", ", $databasePaths));
}

// Try to load google-auth.php
$googleAuthPaths = [
    $rootPath . '/config/google-auth.php',
    $rootPath . '/admin/config/google-auth.php',
    dirname(__FILE__) . '/../config/google-auth.php',
    dirname(__FILE__) . '/../../config/google-auth.php'
];

$googleAuthLoaded = false;
foreach ($googleAuthPaths as $gaPath) {
    if (file_exists($gaPath)) {
        require_once $gaPath;
        $googleAuthLoaded = true;
        break;
    }
}

if (!$googleAuthLoaded) {
    // If google-auth.php doesn't exist, use default values (you'll need to update these)
    define('GOOGLE_CLIENT_ID', 'your-google-client-id.apps.googleusercontent.com');
    define('GOOGLE_CLIENT_SECRET', 'your-google-client-secret');
    define('GOOGLE_REDIRECT_URI', 'http://yourdomain.com/php/google-auth.php');
}

// Try to load Database and AdminModel classes
$databaseClassPath = $rootPath . '/admin/models/Database.php';
$adminModelPath = $rootPath . '/admin/models/AdminModel.php';

if (!file_exists($databaseClassPath)) {
    // Try alternative paths
    $databaseClassPath = dirname(__FILE__) . '/../admin/models/Database.php';
    $adminModelPath = dirname(__FILE__) . '/../admin/models/AdminModel.php';
}

if (file_exists($databaseClassPath)) {
    require_once $databaseClassPath;
} else {
    die("Database class file not found: " . $databaseClassPath);
}

if (file_exists($adminModelPath)) {
    require_once $adminModelPath;
} else {
    die("AdminModel class file not found: " . $adminModelPath);
}

class GoogleAuth {
    private $pdo;
    private $adminModel;
    
    public function __construct() {
        try {
            $this->pdo = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
                DB_USER, 
                DB_PASS,
                [
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4",
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]
            );
            $this->adminModel = new AdminModel();
        } catch (PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage());
            die("Database connection failed");
        }
    }
    
    public function getAuthUrl() {
        $params = [
            'client_id' => GOOGLE_CLIENT_ID,
            'redirect_uri' => GOOGLE_REDIRECT_URI,
            'response_type' => 'code',
            'scope' => 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile',
            'access_type' => 'online',
            'prompt' => 'consent'
        ];
        
        return 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query($params);
    }
    
    public function handleCallback($code) {
        // Exchange code for access token
        $tokenResponse = $this->exchangeCodeForToken($code);
        
        if (!$tokenResponse || isset($tokenResponse['error'])) {
            return ['success' => false, 'error' => 'Failed to get access token: ' . ($tokenResponse['error'] ?? 'Unknown error')];
        }
        
        $accessToken = $tokenResponse['access_token'];
        
        // Get user info from Google
        $userInfo = $this->getUserInfo($accessToken);
        
        if (!$userInfo || isset($userInfo['error'])) {
            return ['success' => false, 'error' => 'Failed to get user info: ' . ($userInfo['error'] ?? 'Unknown error')];
        }
        
        // Create or update user in database
        return $this->createOrUpdateUser($userInfo);
    }
    
    private function exchangeCodeForToken($code) {
        $params = [
            'client_id' => GOOGLE_CLIENT_ID,
            'client_secret' => GOOGLE_CLIENT_SECRET,
            'code' => $code,
            'grant_type' => 'authorization_code',
            'redirect_uri' => GOOGLE_REDIRECT_URI
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://oauth2.googleapis.com/token');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode !== 200) {
            error_log("Google token exchange failed with HTTP code: " . $httpCode);
            error_log("Response: " . $response);
            return ['error' => 'HTTP ' . $httpCode];
        }
        
        return json_decode($response, true);
    }
    
    private function getUserInfo($accessToken) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/oauth2/v2/userinfo');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $accessToken
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode !== 200) {
            error_log("Google userinfo failed with HTTP code: " . $httpCode);
            return ['error' => 'HTTP ' . $httpCode];
        }
        
        return json_decode($response, true);
    }
    
    private function createOrUpdateUser($userInfo) {
        $googleId = $userInfo['id'];
        $email = $userInfo['email'];
        $name = $userInfo['name'] ?? explode('@', $email)[0]; // Use email prefix if no name
        
        try {
            // Check if user exists with this Google ID or email
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE google_id = ? OR email = ?");
            $stmt->execute([$googleId, $email]);
            $existingUser = $stmt->fetch();
            
            if ($existingUser) {
                // Update existing user with Google ID if not set
                if (!$existingUser['google_id']) {
                    $stmt = $this->pdo->prepare("UPDATE users SET google_id = ? WHERE id = ?");
                    $stmt->execute([$googleId, $existingUser['id']]);
                }
                
                $_SESSION['name'] = $existingUser['name'];
                $_SESSION['login_time'] = time();
                
                return [
                    'success' => true,
                    'user' => $existingUser['name'],
                    'action' => 'login'
                ];
            } else {
                // Create new user
                // Generate a unique username if needed
                $baseUsername = preg_replace('/[^a-zA-Z0-9]/', '', $name);
                $username = $baseUsername;
                $counter = 1;
                
                // Ensure username is unique
                while (true) {
                    $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE name = ?");
                    $stmt->execute([$username]);
                    if ($stmt->fetchColumn() == 0) {
                        break;
                    }
                    $username = $baseUsername . $counter;
                    $counter++;
                }
                
                $stmt = $this->pdo->prepare("INSERT INTO users (name, email, google_id) VALUES (?, ?, ?)");
                $stmt->execute([$username, $email, $googleId]);
                $userId = $this->pdo->lastInsertId();
                
                // Create activities table for new user
                $tname = $username . '_activities';
                $sql = "CREATE TABLE IF NOT EXISTS " . $tname . "
                    ( id SERIAL PRIMARY KEY,
                    activity_name VARCHAR(50) NOT NULL,
                    item_name VARCHAR(50) NOT NULL DEFAULT 'Music',
                    item_id BIGINT(20) UNSIGNED NOT NULL,
                    activity_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP)
                    ENGINE INNODB CHARSET utf8mb4 COLLATE utf8mb4_general_ci";
                $this->pdo->query($sql);
                
                $_SESSION['name'] = $username;
                $_SESSION['login_time'] = time();
                
                return [
                    'success' => true,
                    'user' => $username,
                    'action' => 'register'
                ];
            }
        } catch (PDOException $e) {
            error_log("Database error in Google auth: " . $e->getMessage());
            return ['success' => false, 'error' => 'Database error: ' . $e->getMessage()];
        }
    }
}

// Handle the callback
if (isset($_GET['code'])) {
    $googleAuth = new GoogleAuth();
    $result = $googleAuth->handleCallback($_GET['code']);
    
    if ($result['success']) {
        // Redirect to success page
        header('Location: /account/login.html?google_success=1&user=' . urlencode($result['user']));
    } else {
        header('Location: /account/login.html?google_error=1&message=' . urlencode($result['error']));
    }
    exit;
}

// If no code parameter, redirect to login
header('Location: /account/login.html');
?>