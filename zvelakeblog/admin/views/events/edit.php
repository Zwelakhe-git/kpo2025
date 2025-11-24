<?php require_once 'views/layout/header.php'; ?>

<h2>Redije Eveneman</h2>

<?php if (isset($error)): ?>
<div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-8">
            <div class="mb-3">
                <label for="title" class="form-label">Non eveneman *</label>
                <input type="text" class="form-control" id="title" name="title" 
                       value="<?= htmlspecialchars($event['title'] ?? '') ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Tit eveneman</label>
                <textarea class="form-control" id="description" name="description" rows="4"><?= htmlspecialchars($event['description'] ?? '') ?></textarea>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="eventDate" class="form-label">Dat eveneman *</label>
                        <input type="date" class="form-control" id="eventDate" name="eventDate" 
                               value="<?= $event['eventDate'] ?? '' ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="price" class="form-label">Pri (руб.)</label>
                        <input type="number" class="form-control" id="price" name="price" 
                               min="0" value="<?= $event['price'] ?? 0 ?>">
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="location" class="form-label">Lye Eveneman *</label>
                <input type="text" class="form-control" id="location" name="location" 
                       value="<?= htmlspecialchars($event['location'] ?? '') ?>" required>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="mb-3">
                <label for="event_image" class="form-label">Imaj Eveneman</label>
                <input type="file" class="form-control" id="event_image" name="event_image" 
                       accept="image/*" data-preview="eventPreview">
                
                <?php if ($event['image_location']): ?>
                <div class="mt-2">
                    <p>Imaj aktyel:</p>
                    <img src="<?= $event['image_location'] ?>" width="200" class="img-thumbnail">
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" id="remove_image" name="remove_image">
                        <label class="form-check-label" for="remove_image">
                            Siprime imaj aktyel la
                        </label>
                    </div>
                </div>
                <?php else: ?>
                <div class="mt-2 text-center">
                    <div class="text-muted border rounded p-4">
                        <i class="fas fa-calendar-alt fa-2x mb-2"></i>
                        <br>Imaj non ensere
                    </div>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Enfomasyon de eveneman</h6>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <strong>ID:</strong> <?= $event['id'] ?? 'Новый' ?>
                    </div>
                    <div class="mb-2">
                        <strong>Статус:</strong>
                        <?php
                        $eventDate = strtotime($event['eventDate'] ?? '');
                        $now = time();
                        if ($eventDate > $now) {
                            echo '<span class="badge bg-success">Предстоящее</span>';
                        } else {
                            echo '<span class="badge bg-secondary">Прошедшее</span>';
                        }
                        ?>
                    </div>
                    <div class="mb-2">
                        <strong>Создано:</strong><br>
                        <?= date('d.m.Y H:i', strtotime($event['created_at'] ?? 'now')) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-2"></i>Sovgade chanjman 
        </button>
        <a href="?action=events" class="btn btn-secondary">
            <i class="fas fa-times me-2"></i>Anile
        </a>
        <a href="?action=events&method=delete&id=<?= $event['id'] ?>" 
           class="btn btn-danger float-end"
           onclick="return confirm('Удалить это событие?')">
            <i class="fas fa-trash me-2"></i>Efase
        </a>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Превью нового изображения
    const eventInput = document.getElementById('event_image');
    eventInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            // В реальном проекте здесь будет превью
            console.log('Новое изображение выбрано:', file.name);
        }
    });
    
    // Установка минимальной даты (сегодня)
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('eventDate').min = today;
});
</script>

<?php require_once ROOT_PATH . '/views/layout/footer.php'; ?>