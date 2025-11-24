<?php
// Authentication configuration
session_start();

class Auth {
    private $db;
    
    public function __construct() {
        // Database connection
        $this->db = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET,
            DB_USER,
            DB_PASS
        );
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    
    // Check if user is logged in
    public function isLoggedIn() {
        return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
    }
    
    // Login user
    public function login($email, $password) {
        // password
        $valid_email = 'admin@konektem.net'; 
        $valid_password = 'adminkonektem';
        
        if ($email === $valid_email && $password === $valid_password) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_email'] = $email;
            $_SESSION['login_time'] = time();
            return true;
        }
        
        return false;
    }
    
    // Logout user
    public function logout() {
        session_destroy();
    }
    
    // Get current user
    public function getCurrentUser() {
        return $_SESSION['admin_email'] ?? null;
    }
    public function guestStillAlive(){
        return ( isset($_SESSION['name']) && !empty($_SESSION['name']) );
    }
    
    // Require login - redirect if not logged in
    public function requireLogin($redirectTo = 'login.php') {
        if (!$this->isLoggedIn()) {
            header('Location: ' . $redirectTo);
            exit;
        }
    }
    
    // Check session timeout (optional security feature)
    //Admin
    public function checkSessionTimeout($timeoutMinutes = 60) {
        if (isset($_SESSION['login_time'])) {
            $elapsedTime = time() - $_SESSION['login_time'];
            if ($elapsedTime > ($timeoutMinutes * 60)) {
                $this->logout();
                header('Location: login.php?timeout=1');
                exit;
            }
            // Update login time on activity
            $_SESSION['login_time'] = time();
        }
    }
    //Guests
    public function checkGuestSessionTimeout($timeoutMinutes = 60) {
        if (isset($_SESSION['login_time'])) {
            $elapsedTime = time() - $_SESSION['login_time'];
            if ($elapsedTime > ($timeoutMinutes * 60)) {
                $this->logout();
                return;
            }
            $_SESSION['login_time'] = time();
        }
    }
}
?>