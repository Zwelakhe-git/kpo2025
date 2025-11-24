<?php
define('ROOT_PATH', __DIR__);
require_once ROOT_PATH . '/../models/EventModel.php';
require_once ROOT_PATH . '/../models/ImageModel.php';
require_once ROOT_PATH . '/../utils/FileUpload.php';
require_once ROOT_PATH . '/../config/config.php';

class EventController {
    private $model;
    private $imageModel;
    
    public function __construct() {
        $this->model = new EventModel();
        $this->imageModel = new ImageModel();
    }
    
    public function index() {
        $events = $this->model->getAllEvents();
        require_once ROOT_PATH . '/../views/events/list.php';
    }
    
    public function create() {
        if ($_POST) {
            try {
                $eventImageId = null;
                if (!empty($_FILES['event_image']['name'])) {
                    $uploader = new FileUploader(ROOT_PATH . '/../uploads/images/', ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/avif']);
                    $imageInfo = $uploader->upload($_FILES['event_image']);
                    $eventImageId = $this->imageModel->createImage($imageInfo['filepath'], $imageInfo['mime_type']);
                }
                
                $data = [
                    'title' => $_POST['title'],
                    'eventDate' => $_POST['eventDate'],
                    'location' => $_POST['location'],
                    'price' => $_POST['price'],
                    'eventImage' => $eventImageId
                ];
                
                if ($this->model->createEvent($data)) {
                    header('Location: ?action=events&success=1');
                    exit;
                }
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }
        require_once ROOT_PATH . '/../views/events/create.php';
    }
    
    public function edit($id) {
        $event = $this->model->getEventById($id);
        
        if ($_POST) {
            try {
                $eventImageId = $event['eventImage'];
                
                if (!empty($_FILES['event_image']['name'])) {
                    $uploader = new FileUploader(ROOT_PATH . '/../uploads/images/', ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/avif']);
                    $imageInfo = $uploader->upload($_FILES['event_image']);
                    $eventImageId = $this->imageModel->createImage($imageInfo['filepath'], $imageInfo['mime_type']);
                }
                
                $data = [
                    'title' => $_POST['title'],
                    'eventDate' => $_POST['eventDate'],
                    'location' => $_POST['location'],
                    'price' => $_POST['price'],
                    'eventImage' => $eventImageId
                ];
                
                if ($this->model->updateEvent($id, $data)) {
                    header('Location: ?action=events&success=1');
                    exit;
                }
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }
        
        require_once ROOT_PATH . '/../views/events/edit.php';
    }
    
    public function delete($id) {
        $event = $this->model->getEventById($id);
        
        if ($event['eventImage']) {
            $this->imageModel->deleteImage($event['eventImage']);
        }
        
        if ($this->model->deleteEvent($id)) {
            header('Location: ?action=events&success=1');
            exit;
        }
    }
}
?>