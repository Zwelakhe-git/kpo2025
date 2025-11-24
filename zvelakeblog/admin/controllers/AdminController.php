<?php
session_start();
define('ROOT_PATH', __DIR__);
require_once ROOT_PATH . '/../config/database.php';
require_once ROOT_PATH . '/../config/auth.php';
require_once ROOT_PATH . '/../models/AdminModel.php';

class AdminController {
    private $newsModel;
    private $musicModel;
    private $videoModel;
    private $serviceModel;
    private $eventModel;
    private $streamModel;
    private $auth;
    
    public function __construct() {
        $this->newsModel = new NewsModel();
        $this->musicModel = new MusicModel();
        $this->videoModel = new VideoModel();
        $this->serviceModel = new ServiceModel();
        $this->eventModel = new EventModel();
        $this->streamModel = new LiveStreamModel();
        $this->auth = new Auth();
        $this->model = new AdminModel();
    }
    
    public function dashboard() {
        $stats = [
            'news_count' => count($this->newsModel->getAllNews()),
            'music_count' => count($this->musicModel->getAllMusic()),
            'videos_count' => count($this->videoModel->getAllVideos()),
            'services_count' => count($this->serviceModel->getAllServices()),
            'events_count' => count($this->eventModel->getAllEvents()),
            'streams_count' => count($this->streamModel->getAllStreams())
        ];
        
        // Pass user info to view
        $current_user = $this->auth->getCurrentUser();
        
        require_once ROOT_PATH . '/../views/dashboard.php';
    }
    public function userLogin(){
        if ($this->auth->guestStillAlive()){
            $this->auth->checkGuestSessionTimeout();

            return $this->auth->guestStillAlive() ?
                ['response' => 'success', 'message' => $_SESSION['name'] ] :
            	['response' => 'fail', 'message' => 'session timeout' ]
            ;
            //echo json_encode(['response' => 'success', 'message' => $_SESSION['name'] ]);
        } elseif($_POST){
            $response = $this->model->grantLogin($_POST);
            $valid = $this->validate($response);
            if($valid === true){
                return ['response' => 'success', 'message' => $_SESSION["name"]];
                //echo json_encode(['response' => 'success', 'message' => 'passed validation']);
            } else {
                return $valid;
            }
            
        } else {
            return ['response' => 'fail','message' => 'missing parameters'];
        }
    }

    private function validate($response){
        if($response['access'] == 'denied'){
            if($response['message'] == 'unregistered'){
                return ['response' => 'fail', 'message' => 'account not found'];
            } elseif($response['message'] == 'wrong_password'){
               return ['response' => 'fail', 'message' => 'Invalid password'];
            }
        } else {
            
            $_SESSION["name"] = $response['name'];
            $_SESSION['login_time'] = time();
            session_write_close();
            return true;
        }
        return ['response' => 'fail', 'message' => $response['message']];
    }

    public function userRegistration(){
        if($_POST){
            $data = [
                'name' => $_POST['login'],
                'password_hash' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                'email' => $_POST['email']
            ];
            $result = $this->model->registerUser($data);
            return $result;
        }
        return ['response' => 'fail', 'message' => 'missing parameters'];
    }
    public function userLogout(){
        $this->auth->logout();
        return ['response' => 'success'];
    }
    public function getCurrentUser(){
        return isset($_SESSION['name']) ? ['name' => $_SESSION['name']] : ['name' => 'guest'];
    }
    
    public function mediaActivity(){
        if(isset($_GET["activity"]) && isset($_GET["id"]) && isset($_GET['user'])){
            $activity = urldecode($_GET["activity"]);
            $item_id = urldecode($_GET["id"]);
            $user = urldecode($_GET['user']);
            $response = $this->model->recordMediaActivity($activity, $item_id, $user);
            return $response;
        }
        else{
            return ["response" => "failed", "message" => "missing parameters"];
        }
    }
    public function userActivities(){
        if(isset($_GET['u'])){
            $activities = $this->model->getUserActivity(urldecode($_GET['u']));
            return $activities;
        } else {
            return ["error" => 0, "message" => "user not set"];
        }
    }

       public function getGoogleAuthUrl() {
        // Check if Google auth config exists - try multiple paths
        $googleConfigPaths = [
            dirname(ROOT_PATH) . '/config/google-auth.php',
            dirname(dirname(ROOT_PATH)) . '/config/google-auth.php',
            ROOT_PATH . '/../config/google-auth.php',
            ROOT_PATH . '/../../config/google-auth.php'
        ];

        $googleConfigLoaded = false;
        foreach ($googleConfigPaths as $googleConfigPath) {
            if (file_exists($googleConfigPath)) {
                require_once $googleConfigPath;
                $googleConfigLoaded = true;
                break;
            }
        }

        if (!$googleConfigLoaded) {
            error_log("Google auth config file not found. Checked paths: " . implode(", ", $googleConfigPaths));
            return ['error' => 'Google authentication not configured - config file missing'];
        }

        // Rest of the method remains the same...
        // Validate that required constants are defined
        if (!defined('GOOGLE_CLIENT_ID') || empty(GOOGLE_CLIENT_ID) || GOOGLE_CLIENT_ID === 'your-google-client-id.apps.googleusercontent.com') {
            return ['error' => 'Google OAuth configuration missing or not set'];
        }

        if (!defined('GOOGLE_REDIRECT_URI') || empty(GOOGLE_REDIRECT_URI)) {
            return ['error' => 'Google redirect URI not configured'];
        }

        $params = [
            'client_id' => GOOGLE_CLIENT_ID,
            'redirect_uri' => GOOGLE_REDIRECT_URI,
            'response_type' => 'code',
            'scope' => 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile',
            'access_type' => 'online',
            'prompt' => 'consent'
        ];

        $authUrl = 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query($params);

        return ['auth_url' => $authUrl];
    }
}
?>