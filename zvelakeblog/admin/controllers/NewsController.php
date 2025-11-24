<?php
define('ROOT_PATH', __DIR__);
require_once ROOT_PATH . '/../models/NewsModel.php';
require_once ROOT_PATH . '/../models/ImageModel.php';
require_once ROOT_PATH . '/../utils/FileUpload.php';
require_once ROOT_PATH . '/../config/config.php';
class NewsController {
    private $model;
    private $imageModel;
    
    public function __construct() {
        $this->model = new NewsModel();
        $this->imageModel = new ImageModel();
    }
    
    public function index() {
        $news = $this->model->getAllNews();
        require_once ROOT_PATH . '/../views/news/list.php';
    }
    
    public function create() {
        if ($_POST) {
            try {
                $newsImageId = null;
                
                // Загрузка изображения новости
                if (!empty($_FILES['news_image']['name'])) {
                    $uploader = new FileUploader(ROOT_PATH . '/../uploads/images/', IMAGETYPES);
                    $imageInfo = $uploader->upload($_FILES['news_image']);
                    $newsImageId = $this->imageModel->createImage($imageInfo['filepath'], $imageInfo['mime_type']);
                }
                $data = [
                    'newsImg' => $newsImageId,
                    'newsTitle' => $_POST['newsTitle'],
                    'newsDate' => $_POST['newsDate'],
                    'newsHeadline' => $_POST['newsHeadline'],
                    'fullContent' => $_POST['fullContent'],
                    'newsCategory' => $_POST['newsCategory']
                ];
                
                if ($this->model->createNews($data)) {
                    header('Location: ?action=news&success=1');
                    exit;
                }
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }
        
        require_once ROOT_PATH . '/../views/news/create.php';
    }
    
    public function edit($id) {
        $news = $this->model->getNewsById($id);
        
        if ($_POST) {
            try {
                $newsImageId = $news['newsImg'];
                
                // Загрузка нового изображения
                if (!empty($_FILES['news_image']['name'])) {
                    $uploader = new FileUploader(ROOT_PATH . '/../uploads/images/', ['image/jpeg', 'image/png', 'image/gif', 'image/avif']);
                    $imageInfo = $uploader->upload($_FILES['news_image']);
                    $newsImageId = $this->imageModel->createImage($imageInfo['filepath'], $imageInfo['mime_type']);
                }
                
                $data = [
                    'newsImg' => $newsImageId,
                    'newsTitle' => $_POST['newsTitle'],
                    'newsDate' => $_POST['newsDate'],
                    'newsHeadline' => $_POST['newsHeadline'],
                    'fullContent' => $_POST['fullContent'],
                    'newsCategory' => $_POST['newsCategory']
                ];
                
                if ($this->model->updateNews($id, $data)) {
                    header('Location: ?action=news&success=1');
                    exit;
                }
            } catch (Exception $e) {
                $error = $e->getMessage();
                echo $error;
            }
        }
        
        require_once ROOT_PATH . '/../views/news/edit.php';
    }
    
    public function delete($id) {
        $news = $this->model->getNewsById($id);
        
        // Удаляем связанные изображения
        if ($news['newsImg']) {
            $this->imageModel->deleteImage($news['newsImg']);
        }
        
        if ($this->model->deleteNews($id)) {
            header('Location: ?action=news&success=1');
            exit;
        }
    }
    
    // Метод для предпросмотра новости
    public function preview($id) {
        $news = $this->model->getNewsById($id);
        try{
            require_once ROOT_PATH . '/../views/news/preview.php';
        } catch(Exception $e){
            die($e->getMessage());
        }
        
    }
}
?>