<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../logs/error.log');

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
$resourcesToFetch = [];
$finalReponse = [];

try {
    $resourcesToFetch = [
        ["name" => "musicContent", "result" => (new MusicModel())->getAllMusic()],
        ["name" => "services", "result" => (new ServiceModel())->getAllServices()],
        ["name" => "news", "result" => (new NewsModel())->getAllNews($source = isset($_GET['source']) ? $_GET['source'] : 'local')],
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
        case 'savetokenFB':
	    $finalResponse = $controller->saveFirebaseToken();
            break;
        case 'streamAccess':
            $finalReponse = $controller->grantStreamAccess();
            break;
        case 'viewerReg':
            $finalReponse = $controller->registerViewer();
            break;
        case 'createOrder':
            $controller = new OrderController();
            $finalReponse = $controller->createOrder();
            break;
        case 'updatePaymentStatus':
            $controller = new OrderController();
            $finalReponse = $controller->updatePaymentStatus();
            break;
        case 'orders':
            $controller = new OrderController();
            $finalReponse = $controller->getAllOrders();
            break;
        case 'createServiceOrder':
            $controller = new ServiceOrderController();
            $controller->createOrder();
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
                    break;
                }
            }
            break;
    }
}

header("Content-Type: application/json; charset=utf-8");
$cleanedData = cleanUtf8($finalReponse);
echo json_encode($cleanedData, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_IGNORE);
?>
