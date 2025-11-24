<?php
define('ROOT_PATH', __DIR__ . '/..');
require_once ROOT_PATH . '/models/PartnersModel.php';
require_once ROOT_PATH . '/models/ImageModel.php';
require_once ROOT_PATH . '/utils/FileUpload.php';
require_once ROOT_PATH . '/config/config.php';

class PartnersController {
    private $model;
    private $imageModel;
    
    public function __construct() {
        $this->model = new PartnersModel();
        $this->imageModel = new ImageModel();
    }
    
    public function index() {
        $partners = $this->model->getAllPartners();
        require_once ROOT_PATH . '/views/partners/list.php';
    }
    
    public function create() {
        if ($_POST) {
            try {
                $imageId = null;
                
                // Загрузка логотипа
                if (!empty($_FILES['partner_image']['name'])) {
                    $uploader = new FileUploader(ROOT_PATH . '/uploads/partners/', IMAGETYPES);
                    $imageInfo = $uploader->upload($_FILES['partner_image']);
                    $imageId = $this->imageModel->createImage($imageInfo['filepath'], $imageInfo['mime_type']);
                }
                
                $data = [
                    'partner_name' => $_POST['partner_name'],
                    'image_id' => $imageId
                ];
                
                if ($this->model->createPartner($data)) {
                    header('Location: ?action=partners&success=1');
                    exit;
                } else {
                    $error = 'Ошибка при создании партнера';
                }
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }
        
        require_once ROOT_PATH . '/views/partners/create.php';
    }
    
    public function edit($id) {
        $partner = $this->model->getPartnerById($id);
        
        if (!$partner) {
            header('Location: ?action=partners&error=1');
            exit;
        }
        
        if ($_POST) {
            try {
                $imageId = $partner['image_id'];
                
                // Удаление текущего изображения
                if (isset($_POST['remove_image']) && $_POST['remove_image']) {
                    if ($imageId) {
                        $this->imageModel->deleteImage($imageId);
                    }
                    $imageId = null;
                }
                
                // Загрузка нового изображения
                if (!empty($_FILES['partner_image']['name'])) {
                    // Удаляем старое изображение если есть
                    if ($imageId) {
                        $this->imageModel->deleteImage($imageId);
                    }
                    
                    $uploader = new FileUploader(ROOT_PATH . '/uploads/partners/', IMAGETYPES);
                    $imageInfo = $uploader->upload($_FILES['partner_image']);
                    $imageId = $this->imageModel->createImage($imageInfo['filepath'], $imageInfo['mime_type']);
                }
                
                $data = [
                    'name' => $_POST['name'],
                    'image_id' => $imageId
                ];
                
                if ($this->model->editPartner($id, $data)) {
                    header('Location: ?action=partners&success=1');
                    exit;
                } else {
                    $error = 'Ошибка при обновлении партнера';
                }
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }
        
        require_once ROOT_PATH . '/views/partners/edit.php';
    }
    
    public function delete($id) {
        $partner = $this->model->getPartnerById($id);
        $image_id = $partner['image_id'];
        
        if ($this->model->deletePartner($id)) {
            $this->imageModel->deleteImage($image_id);
            header('Location: ?action=partners&success=1');
        } else {
            header('Location: ?action=partners&error=1');
        }
        exit;
    }
}
?>