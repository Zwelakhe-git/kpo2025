<?php
error_reporting(0);
require_once 'config/database.php';
require_once 'config/auth.php';
//define('ROOT_PATH', __DIR__);

// Initialize authentication
$auth = new Auth();

// Check if user is logged in for all pages except login
$current_page = basename($_SERVER['PHP_SELF']);
if ($current_page != 'login.php') {
    $auth->requireLogin('login.php');
    $auth->checkSessionTimeout(); // Optional: Check session timeout
}

// Автозагрузка контроллеров
spl_autoload_register(function ($class) {
    if (file_exists('controllers/' . $class . '.php')) {
        require_once 'controllers/' . $class . '.php';
    } elseif (file_exists('models/' . $class . '.php')) {
        require_once 'models/' . $class . '.php';
    } elseif (file_exists('utils/' . $class . '.php')) {
        require_once 'utils/' . $class . '.php';
    }
});

// Маршрутизация
$action = $_GET['action'] ?? 'dashboard';
$method = $_GET['method'] ?? 'index';
$id = $_GET['id'] ?? null;

try{
    switch ($action) {
        case 'dashboard':
            $controller = new AdminController();
            $controller->dashboard();
            break;
            
        case 'news':
            $controller = new NewsController();
            if ($id && $method == 'edit') {
                $controller->edit($id);
            } elseif ($method == 'create') {
                $controller->create();
            } elseif ($id && $method == 'delete') {
                $controller->delete($id);
            } else {
                $controller->index();
            }
            break;
            
        case 'music':
            $controller = new MusicController();
            if ($id && $method == 'edit') {
                $controller->edit($id);
            } elseif ($method == 'create') {
                $controller->create();
            } elseif ($id && $method == 'delete') {
                $controller->delete($id);
            } else {
                $controller->index();
            }
            break;
            
        case 'videos':
            $controller = new VideoController();
            if ($id && $method == 'edit') {
                $controller->edit($id);
            } elseif ($method == 'create') {
                $controller->create();
            } elseif ($id && $method == 'delete') {
                $controller->delete($id);
            } else {
                $controller->index();
            }
            break;
            
        case 'services':
            $controller = new ServiceController();
            if ($id && $method == 'edit') {
                $controller->edit($id);
            } elseif ($method == 'create') {
                $controller->create();
            } elseif ($id && $method == 'delete') {
                $controller->delete($id);
            } else {
                $controller->index();
            }
            break;
            
        case 'events':
            $controller = new EventController();
            if ($id && $method == 'edit') {
                $controller->edit($id);
            } elseif ($method == 'create') {
                $controller->create();
            } elseif ($id && $method == 'delete') {
                $controller->delete($id);
            } else {
                $controller->index();
            }
            break;
            
        case 'livestream':
            $controller = new LiveStreamController();
            if ($id && $method == 'edit') {
                $controller->edit($id);
            } elseif ($method == 'create') {
                $controller->create();
            } elseif ($id && $method == 'delete') {
                $controller->delete($id);
            } else {
                $controller->index();
            }
            break;
        case 'partners':
            $controller = new PartnersController();
            if ($id && $method == 'edit') {
                $controller->edit($id);
            } elseif ($method == 'create') {
                $controller->create();
            } elseif ($id && $method == 'delete') {
                $controller->delete($id);
            } else {
                $controller->index();
            }
            break;
        case 'userlogin':
            header("Content-Type: application/json; charset=utf-8");
            $controller = new AdminController();
            $controller->userLogin();
            break;
        case 'userRegister':
            header('Content-Type: application/json; charset=utf-8');
            $controller = new AdminController();
            $controller->userRegistration();
            break;
        case 'createOrder':
            $controller = new OrderController();
            $controller->createOrder();
            break;

        case 'orders':
            $controller = new OrderController();
            if ($method == 'index') {
                $controller->index();
            }
            break;
        default:
            // Если действие не распознано, показываем дашборд
            $controller = new AdminController();
            $controller->dashboard();
            break;
    }
} catch (Exception $e){
    die($e->getMessage());
}
?>