<?php
class FileUploader {
    private $uploadDir;
    private $allowedTypes;
    private $maxSize;
    
    public function __construct($uploadDir, $allowedTypes = [], $maxSize = 50000000) {
        $this->uploadDir = $uploadDir;
        $this->allowedTypes = $allowedTypes;
        $this->maxSize = $maxSize;
        
        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0755, true);
        }
    }
    
    public function upload($file) {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('Ошибка загрузки файла');
        }
        
        if ($file['size'] > $this->maxSize) {
            throw new Exception('Файл слишком большой: ' . $file['size']);
        }
        
        $fileType = mime_content_type($file['tmp_name']);
        if (!empty($this->allowedTypes) && !in_array($fileType, $this->allowedTypes)) {
            throw new Exception('Тип файла не разрешен: ' . $file['name'] . ' - ' . $fileType);
        }
        
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $extension;
        $filepath = $this->uploadDir . '' . $filename;
        
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            return [
                'filename' => $filename,
                'filepath' => substr($filepath, strpos($filepath,'/admin')),
                'mime_type' => $fileType,
                'size' => $file['size']
            ];
        }
        
        throw new Exception('Не удалось сохранить файл');
    }
}
?>