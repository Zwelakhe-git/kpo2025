<?php
error_reporting(0);
ini_set('display_errors', 1);

define('MODELS_PATH', __DIR__ . '/../admin/models/');
define('ADMIN_PATH', __DIR__ . '/../admin');

spl_autoload_register(function ($class){
    if(file_exists(ADMIN_PATH . '/models/' . $class . '.php')){
        require_once ADMIN_PATH . '/models/' . $class . '.php';
    } elseif(file_exists(ADMIN_PATH . '/controllers/' . $class . '.php' )){
        require_once ADMIN_PATH . '/controllers/' . $class . '.php';
    }
});

// Функция для очистки UTF-8
function cleanUtf8($data) {
    if (is_array($data)) {
        return array_map('cleanUtf8', $data);
    } elseif (is_string($data)) {
        return iconv('UTF-8', 'UTF-8//IGNORE', $data);
    }
    return $data;
}

$resource_name = $_GET["r"] ?? "all";
$query = $_GET['q'] ?? null;
$search = $_GET['search'] ?? null;
$resourcesToFetch = [];
$finalReponse = [];

try {
    $resourcesToFetch = [
        ["name" => "musicContent", "result" => (new MusicModel())->getAllMusic()],
        ["name" => "services", "result" => (new ServiceModel())->getAllServices()],
        ["name" => "news", "result" => (new NewsModel())->getAllNews()],
        ["name" => "events", "result" => (new EventModel())->getAllEvents()],
        ["name" => "videos", "result" => (new VideoModel())->getAllVideos()],
        ["name" => "stream", "result" => (new LiveStreamModel())->getAllStreams()],
        ["name" => "partners", "result" => (new PartnersModel())->getAllPartners()]
    ];
} catch(PDOException $e) {
    $finalReponse = ['error' => 'Database error'];
}

if($query){
    $controller = new AdminController();
    switch($query){
        case 'userlogout':
            $finalReponse = $controller->userLogout();
            break;
        case 'userlogin':
            $finalReponse = $controller->userLogin();
            break;
        case 'userRegister':
            $finalReponse = $controller->userRegistration();
            break;
        case 'mediaActivity':
            $finalReponse = $controller->mediaActivity();
            break;
        case 'uid':
            $finalReponse = $controller->getCurrentUser();
            break;
        case 'googleAuthUrl':
            $finalReponse = $controller->getGoogleAuthUrl();
            break;
        case 'useracitvities':
            $finalReponse = $controller->userActivities();
            break;
        case 'createOrder':
            $controller = new OrderController();
            $finalReponse = $controller->createOrder();
            break;
        default:
            break;
    }
}

if (empty($finalReponse)) {
    switch($resource_name) {
        case "all":
            foreach($resourcesToFetch as $resource) {
                $finalReponse[$resource["name"]] = $resource["result"];
            }
            break;
        case 'userlogin':
            $controller = new AdminController();
            $finalReponse = $controller->userLogin();
            break;
        case 'userRegister':
            $controller = new AdminController();
            $finalReponse = $controller->userRegistration();
            break;
        default:
            foreach($resourcesToFetch as $resource) {
                if($resource["name"] == $resource_name) {
                    $finalReponse = $resource["result"];
                    
                    // Apply search filter if search parameter is provided
                    if ($search && !empty($search)) {
                        $finalReponse = applySearchFilter($finalReponse, $search, $resource_name);
                    }
                    break;
                }
            }
            break;
    }
}

// Function to apply search filtering
function applySearchFilter($data, $searchTerm, $resourceType) {
    if (!is_array($data)) {
        return $data;
    }
    
    $searchTerm = strtolower($searchTerm);
    
    return array_filter($data, function($item) use ($searchTerm, $resourceType) {
        switch($resourceType) {
            case 'news':
                return (isset($item['newsTitle']) && stripos($item['newsTitle'], $searchTerm) !== false) ||
                       (isset($item['newsHeadline']) && stripos($item['newsHeadline'], $searchTerm) !== false) ||
                       (isset($item['fullContent']) && stripos($item['fullContent'], $searchTerm) !== false);
                
            case 'musicContent':
                return (isset($item['track_name']) && stripos($item['track_name'], $searchTerm) !== false) ||
                       (isset($item['artist_name']) && stripos($item['artist_name'], $searchTerm) !== false);
                
            case 'events':
                return (isset($item['title']) && stripos($item['title'], $searchTerm) !== false) ||
                       (isset($item['location']) && stripos($item['location'], $searchTerm) !== false) ||
                       (isset($item['host']) && stripos($item['host'], $searchTerm) !== false);
                
            case 'services':
                return (isset($item['name']) && stripos($item['name'], $searchTerm) !== false);
                
            default:
                return true;
        }
    });
}

header("Content-Type: application/json; charset=utf-8");
$cleanedData = cleanUtf8($finalReponse);
echo json_encode($cleanedData, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_IGNORE);
?>