<?php require_once 'views/layout/header.php'; ?>

<h2>Ajoute eveneman</h2>

<?php if (isset($error)): ?>
<div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-8">
            <div class="mb-3">
                <label for="title" class="form-label">Nom evenman yo *</label>
                <input type="text" class="form-control" id="title" name="title" required 
                       placeholder="Введите название события">
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Tit eveneman</label>
                <textarea class="form-control" id="description" name="description" rows="4" 
                          placeholder="Подробное описание события..."></textarea>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="eventDate" class="form-label">Dat Evenman an *</label>
                        <input type="date" class="form-control" id="eventDate" name="eventDate" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="price" class="form-label">Pri (руб.)</label>
                        <input type="number" class="form-control" id="price" name="price" 
                               min="0" value="0">
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="location" class="form-label">Kibo lap fet *</label>
                <input type="text" class="form-control" id="location" name="location" required 
                       placeholder="Введите место проведения">
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="mb-3">
                <label for="event_image" class="form-label">Imaj eveneman an</label>
                <input type="file" class="form-control" id="event_image" name="event_image" 
                       accept="image/*" data-preview="eventPreview">
                
                <div class="mt-3 text-center">
                    <img id="eventPreview" src="#" alt="Превью изображения" 
                         class="img-thumbnail d-none" style="max-width: 100%; height: 200px; object-fit: cover;">
                    <div id="noEventPreview" class="text-muted border rounded p-4">
                        <i class="fas fa-calendar-alt fa-2x mb-2"></i>
                        <br>Premye evenman an
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Plis</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Stati</label>
                        <div class="form-control-plaintext">
                            <span class="badge bg-success">Аkttiv</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Dat li kreye</label>
                        <div class="form-control-plaintext">
                            <?= date('d.m.Y H:i') ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <button type="submit" class="btn btn-primary btn-lg">
            <i class="fas fa-plus-circle me-2"></i>Kreye Eveneman
        </button>
        <a href="?action=events" class="btn btn-secondary btn-lg">
            <i class="fas fa-times me-2"></i>Anile
        </a>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Установка минимальной даты (сегодня)
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('eventDate').min = today;
    
    // Превью изображения
    const eventInput = document.getElementById('event_image');
    const eventPreview = document.getElementById('eventPreview');
    const noEventPreview = document.getElementById('noEventPreview');
    
    eventInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                eventPreview.src = e.target.result;
                eventPreview.classList.remove('d-none');
                noEventPreview.classList.add('d-none');
            }
            reader.readAsDataURL(file);
        } else {
            eventPreview.classList.add('d-none');
            noEventPreview.classList.remove('d-none');
        }
    });
});
</script>

<style>
#noEventPreview {
    height: 200px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background-color: #f8f9fa;
}
</style>

<?php require_once ROOT_PATH . '/views/layout/footer.php'; ?>