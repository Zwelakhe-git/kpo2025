<?php
define('ROOT_PATH', __DIR__);
require_once ROOT_PATH . '/../models/LiveStreamModel.php';

class LiveStreamController {
    private $model;
    
    public function __construct() {
        $this->model = new LiveStreamModel();
    }
    
    public function index() {
        $streams = $this->model->getAllStreams();
        require_once ROOT_PATH . '/../views/livestream/list.php';
    }
    
    public function create() {
        if ($_POST) {
            $data = [
                'stream_date' => $_POST['stream_date'],
                'stream_title' => $_POST['stream_title'],
                'stream_key' => $this->model->generateStreamKey()
            ];
            
            if ($this->model->createStream($data)) {
                header('Location: ?action=livestream&success=1');
                exit;
            }
        }
        require_once ROOT_PATH . '/../views/livestream/create.php';
    }
    
    public function edit($id) {
        if ($_POST) {
            $data = [
                'stream_date' => $_POST['stream_date'],
                'stream_title' => $_POST['stream_title'],
                'stream_key' => $_POST['stream_key']
            ];
            
            if ($this->model->updateStream($id, $data)) {
                header('Location: ?action=livestream&success=1');
                exit;
            }
        }
        
        $stream = $this->model->getStreamById($id);
        require_once ROOT_PATH . '/../views/livestream/edit.php';
    }
    
    public function delete($id) {
        if ($this->model->deleteStream($id)) {
            header('Location: ?action=livestream&success=1');
            exit;
        }
    }
}
?>