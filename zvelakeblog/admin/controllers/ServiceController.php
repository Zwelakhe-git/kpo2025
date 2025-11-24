<?php
define('ROOT_PATH', __DIR__);
require_once ROOT_PATH . '/../models/ServiceModel.php';
require_once ROOT_PATH . '/../models/ImageModel.php';
require_once ROOT_PATH . '/../utils/FileUpload.php';

class ServiceController {
    private $model;
    private $imageModel;
    
    public function __construct() {
        $this->model = new ServiceModel();
        $this->imageModel = new ImageModel();
    }
    
    public function index() {
        $services = $this->model->getAllServices();
        require_once ROOT_PATH . '/../views/services/list.php';
    }
    
    public function create() {
        if ($_POST) {
            try {
                $serviceImageId = null;
                if (!empty($_FILES['service_image']['name'])) {
                    $uploader = new FileUploader(ROOT_PATH . '/../uploads/images/', ['image/jpeg', 'image/png', 'image/gif', 'image/webp']);
                    $imageInfo = $uploader->upload($_FILES['service_image']);
                    $serviceImageId = $this->imageModel->createImage($imageInfo['filepath'], $imageInfo['mime_type']);
                }
                
                $data = [
                    'name' => $_POST['name'],
                    'description' => $_POST['description'],
                    'serviceImg' => $serviceImageId
                ];
                
                if ($this->model->createService($data)) {
                    header('Location: ?action=services&success=1');
                    exit;
                }
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }
        require_once ROOT_PATH . '/../views/services/create.php';
    }
    
    public function edit($id) {
        $service = $this->model->getServiceById($id);
        
        if ($_POST) {
            try {
                $serviceImageId = $service['serviceImg'];
                
                if (!empty($_FILES['service_image']['name'])) {
                    $uploader = new FileUploader(ROOT_PATH . '/../uploads/images/', ['image/jpeg', 'image/png', 'image/gif']);
                    $imageInfo = $uploader->upload($_FILES['service_image']);
                    $serviceImageId = $this->imageModel->createImage($imageInfo['filepath'], $imageInfo['mime_type']);
                }
                
                $data = [
                    'name' => $_POST['name'],
                    'description' => $_POST['description'],
                    'serviceImg' => $serviceImageId
                ];
                
                if ($this->model->updateService($id, $data)) {
                    header('Location: ?action=services&success=1');
                    exit;
                }
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }
        
        require_once ROOT_PATH . '/../views/services/edit.php';
    }
    
    public function delete($id) {
        $service = $this->model->getServiceById($id);
        
        if ($service['serviceImg']) {
            $this->imageModel->deleteImage($service['serviceImg']);
        }
        
        if ($this->model->deleteService($id)) {
            header('Location: ?action=services&success=1');
            exit;
        }
    }
}
?>