<?php
define('ROOT_PATH', __DIR__);
require_once ROOT_PATH . '/../models/VideoModel.php';
require_once ROOT_PATH . '/../models/ImageModel.php';
require_once ROOT_PATH . '/../utils/FileUpload.php';

class VideoController {
    private $model;
    private $imageModel;
    
    public function __construct() {
        $this->model = new VideoModel();
        $this->imageModel = new ImageModel();
    }
    
    public function index() {
        $videos = $this->model->getAllVideos();
        require_once ROOT_PATH . '/../views/videos/list.php';
    }
    
    public function create() {
        if ($_POST) {
            try {
                // Загрузка обложки видео
                $coverImageId = null;
                if (!empty($_FILES['cover_image']['name'])) {
                    $uploader = new FileUploader(ROOT_PATH . '/../uploads/images/', ['image/jpeg', 'image/png', 'image/gif', 'image/webp']);
                    $coverInfo = $uploader->upload($_FILES['cover_image']);
                    $coverImageId = $this->imageModel->createImage($coverInfo['filepath'], $coverInfo['mime_type']);
                }
                
                // Загрузка видео файла
                $videoUploader = new FileUploader(ROOT_PATH . '/../uploads/videos/', ['video/mp4', 'video/avi', 'video/mkv']);
                $videoInfo = $videoUploader->upload($_FILES['video_file']);
                
                $data = [
                    'vidImg' => $coverImageId,
                    'vidTitle' => $_POST['vidTitle'],
                    'location' => $videoInfo['filepath'],
                    'mime_type' => $videoInfo['mime_type']
                ];
                
                if ($this->model->createVideo($data)) {
                    header('Location: ?action=videos&success=1');
                    exit;
                }
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }
        require_once ROOT_PATH . '/../views/videos/create.php';
    }
    
    public function edit($id) {
        $video = $this->model->getVideoById($id);
        
        if ($_POST) {
            try {
                $coverImageId = $video['vidImg'];
                
                if (!empty($_FILES['cover_image']['name'])) {
                    $uploader = new FileUploader(ROOT_PATH . '/../uploads/images/', ['image/jpeg', 'image/png', 'image/gif']);
                    $coverInfo = $uploader->upload($_FILES['cover_image']);
                    $coverImageId = $this->imageModel->createImage($coverInfo['filepath'], $coverInfo['mime_type']);
                }
                
                $data = [
                    'vidImg' => $coverImageId,
                    'vidTitle' => $_POST['vidTitle'],
                    'location' => $video['location'],
                    'mime_type' => $video['mime_type']
                ];
                
                if ($this->model->updateVideo($id, $data)) {
                    header('Location: ?action=videos&success=1');
                    exit;
                }
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }
        
        require_once ROOT_PATH . '/../views/videos/edit.php';
    }
    
    public function delete($id) {
        $video = $this->model->getVideoById($id);
        
        // Удаляем связанные изображения
        if ($video['vidImg']) {
            $this->imageModel->deleteImage($video['vidImg']);
        }
        
        // Удаляем видео файл
        if (file_exists($video['location'])) {
            unlink($video['location']);
        }
        
        if ($this->model->deleteVideo($id)) {
            header('Location: ?action=videos&success=1');
            exit;
        }
    }
}
?>