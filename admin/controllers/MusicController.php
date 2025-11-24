<?php
define('ROOT_PATH', __DIR__);
define('ADMIN_PAGE_ROOT_PATH', '/admin');
require_once ROOT_PATH . '/../models/MusicModel.php';
require_once ROOT_PATH . '/../models/ImageModel.php';
require_once ROOT_PATH . '/../utils/FileUpload.php';
require_once ROOT_PATH . '/../config/config.php';
class MusicController {
    private $model;
    private $imageModel;
    
    public function __construct() {
        $this->model = new MusicModel();
        $this->imageModel = new ImageModel();
    }
    
    public function index() {
        $music = $this->model->getAllMusic();
        $artists = $this->model->getAllArtists();
        require_once ROOT_PATH . '/../views/music/list.php';
    }
    
    public function create() {
        $artists = $this->model->getAllArtists();
        
        if ($_POST) {
            try {
                $trackImageId = null;
                
                // Загрузка обложки трека
                if (!empty($_FILES['track_image']['name'])) {

                    $uploader = new FileUploader(ROOT_PATH . '/../uploads/images/', IMAGETYPES);
                    $imageInfo = $uploader->upload($_FILES['track_image']);
                    $trackImageId = $this->imageModel->createImage($imageInfo['filepath'], $imageInfo['mime_type']);
                }
                
                // Загрузка аудио файла
                $audioUploader = new FileUploader(ROOT_PATH . '/../uploads/music/', ['audio/mpeg', 'audio/wav', 'audio/mp3', 'video/mp4']);
                $audioInfo = $audioUploader->upload($_FILES['audio_file']);
                
                // Если выбран новый артист, создаем его
                $artistId = $_POST['artist_name'];
                if ($_POST['artist_name'] == 'new' && !empty($_POST['new_artist_name'])) {
                    $artistId = $this->model->createArtist($_POST['new_artist_name']);
                }
                
                $data = [
                    'track_name' => $_POST['track_name'],
                    'artist_id' => $artistId,
                    'track_img_id' => $trackImageId,
                    'location' => $audioInfo['filepath'],
                    'mime_type' => $audioInfo['mime_type'],
                    'likes' => 0,
                    'downloads' => 0,
                    'plays' => 0
                ];
                
                if ($this->model->createMusic($data)) {
                    header('Location: ?action=music&success=1');
                    exit;
                }
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }
        
        require_once ROOT_PATH . '/../views/music/create.php';
    }
    
    public function edit($id) {
        $track = $this->model->getMusicById($id);
        $artists = $this->model->getAllArtists();
        
        if ($_POST) {
            try {
                $trackImageId = $track['track_img_id'];
                
                // Загрузка новой обложки
                if (!empty($_FILES['track_image']['name'])) {
                    $uploader = new FileUploader(ROOT_PATH . '/../uploads/images/', ['image/jpeg', 'image/png', 'image/gif']);
                    $imageInfo = $uploader->upload($_FILES['track_image']);
                    $trackImageId = $this->imageModel->createImage($imageInfo['filepath'], $imageInfo['mime_type']);
                }
                
                // Если выбран новый артист, создаем его
                $artistId = $_POST['artist_id'];
                if ($_POST['artist_id'] == 'new' && !empty($_POST['new_artist_name'])) {
                    $artistId = $this->model->createArtist($_POST['new_artist_name']);
                }
                
                $data = [
                    'track_name' => $_POST['track_name'],
                    'artist_id' => $artistId,
                    'track_img_id' => $trackImageId,
                    'location' => $track['location'],
                    'mime_type' => $track['mime_type'],
                    'likes' => $_POST['likes'] ?? $track['likes'],
                    'downloads' => $_POST['downloads'] ?? $track['downloads'],
                    'plays' => $_POST['plays'] ?? $track['plays']
                ];
                
                if ($this->model->updateMusic($id, $data)) {
                    header('Location: ?action=music&success=1');
                    exit;
                }
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }
        
        require_once ROOT_PATH . '/../views/music/edit.php';
    }
    
    public function delete($id) {
        $track = $this->model->getMusicById($id);
        
        // Удаляем связанные изображения
        if ($track['track_img_id']) {
            $this->imageModel->deleteImage($track['track_img_id']);
        }
        
        // Удаляем аудио файл
        if (file_exists(ROOT_PATH . $track['location'])) {
            unlink($track['location']);
        }
        
        if ($this->model->deleteMusic($id)) {
            header('Location: ?action=music&success=1');
            exit;
        }
    }
    
    // Метод для быстрого добавления артиста через AJAX
    public function addArtist() {
        if ($_POST && !empty($_POST['artist_name'])) {
            $artistId = $this->model->createArtist($_POST['artist_name']);
            echo json_encode(['success' => true, 'artist_id' => $artistId, 'artist_name' => $_POST['artist_name']]);
            exit;
        }
        echo json_encode(['success' => false]);
        exit;
    }
}
?>