<?php require_once 'views/layout/header.php'; ?>

<h2>Ajou videyo</h2>

<?php if (isset($error)): ?>
<div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-8">
            <div class="mb-3">
                <label for="vidTitle" class="form-label">Non videyo *</label>
                <input type="text" class="form-control" id="vidTitle" name="vidTitle" required 
                       placeholder="Введите название видео">
            </div>
            
            <div class="mb-3">
                <label for="video_file" class="form-label">fichye videyo *</label>
                <input type="file" class="form-control" id="video_file" name="video_file" 
                       accept="video/mp4,video/avi,video/mkv,video/mov,video/webm" required>
                <div class="form-text">
                    Foma aksepte: MP4, AVI, MKV, MOV, WebM. Максимальный размер: 100MB
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="mb-3">
                <label for="cover_image" class="form-label">Обложка видео</label>
                <input type="file" class="form-control" id="cover_image" name="cover_image" 
                       accept="image/*" data-preview="coverPreview">
                <div class="form-text">size rekomande: 16:9 (egzanp, 1280x720)</div>
                
                <div class="mt-3 text-center">
                    <img id="coverPreview" src="#" alt="Превью обложки" 
                         class="img-thumbnail d-none" style="max-width: 100%; height: 200px; object-fit: cover;">
                    <div id="noCoverPreview" class="text-muted border rounded p-4">
                        <i class="fas fa-image fa-2x mb-2"></i>
                        <br>Premye cover
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Enfomasyon videyo</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Stati</label>
                                <div class="form-control-plaintext">
                                    <span class="badge bg-secondary">Nouvo</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Dat ajou</label>
                                <div class="form-control-plaintext">
                                    <?= date('d.m.Y H:i') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <button type="submit" class="btn btn-primary btn-lg">
            <i class="fas fa-upload me-2"></i>Telechaje videyo
        </button>
        <a href="?action=videos" class="btn btn-secondary btn-lg">
            <i class="fas fa-times me-2"></i>Anile
        </a>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Превью обложки
    const coverInput = document.getElementById('cover_image');
    const coverPreview = document.getElementById('coverPreview');
    const noCoverPreview = document.getElementById('noCoverPreview');
    
    coverInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                coverPreview.src = e.target.result;
                coverPreview.classList.remove('d-none');
                noCoverPreview.classList.add('d-none');
            }
            reader.readAsDataURL(file);
        } else {
            coverPreview.classList.add('d-none');
            noCoverPreview.classList.remove('d-none');
        }
    });

    // Валидация размера файла
    const videoInput = document.getElementById('video_file');
    videoInput.addEventListener('change', function() {
        const file = this.files[0];
        const maxSize = 100 * 1024 * 1024; // 100MB
        
        if (file && file.size > maxSize) {
            alert('Файл слишком большой! Максимальный размер: 100MB');
            this.value = '';
        }
    });

    // Подсказка при наведении на поля
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

// Показ прогресса загрузки (можно расширить для AJAX загрузки)
function showUploadProgress() {
    const submitBtn = document.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Загрузка...';
    submitBtn.disabled = true;
    
    // В реальном проекте здесь будет AJAX с отслеживанием прогресса
    setTimeout(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }, 3000);
}

document.querySelector('form').addEventListener('submit', showUploadProgress);
</script>

<style>
#noCoverPreview {
    height: 200px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background-color: #f8f9fa;
    color: #6c757d;
}

.form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.card {
    border: 1px solid #e3f2fd;
    background-color: #f8fdff;
}

.card-header {
    background-color: #e3f2fd;
    border-bottom: 1px solid #bbdefb;
}

.btn-lg {
    padding: 0.75rem 1.5rem;
    font-size: 1.1rem;
}
</style>

<?php require_once 'views/layout/footer.php'; ?>