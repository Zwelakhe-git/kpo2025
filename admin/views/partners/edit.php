<?php require_once ROOT_PATH . '/views/layout/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Redije patne</h2>
            <a href="?action=partners" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Retounen
            </a>
        </div>

        <?php if (isset($error)): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-triangle me-2"></i><?= $error ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Redije: <?= htmlspecialchars($partner['name']) ?></h5>
                <span class="badge bg-primary">ID: <?= $partner['id'] ?></span>
            </div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="name" class="form-label fw-bold">
                                    Non patne *
                                </label>
                                <input type="text" class="form-control form-control-lg" 
                                       id="name" name="name" 
                                       value="<?= htmlspecialchars($partner['name'] ?? '') ?>" 
                                       required>
                                <div class="form-text">
                                    Non ofisyel konpayi patne
                                </div>
                            </div>

                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <i class="fas fa-database me-2"></i>Enfomasyon sistem
                                    </h6>
                                    <div class="row small">
                                        <div class="col-6">
                                            <strong>ID patne:</strong><br>
                                            <span class="text-muted">#<?= $partner['id'] ?></span>
                                        </div>
                                        <div class="col-6">
                                            <strong>ID imaj:</strong><br>
                                            <span class="text-muted">
                                                <?= $partner['image_id'] ?: 'Не установлен' ?>
                                            </span>
                                        </div>
                                        <div class="col-12 mt-2">
                                            <strong>Dat kreyasyon:</strong><br>
                                            <span class="text-muted">
                                                <?= date('d.m.Y H:i', strtotime($partner['created_at'] ?? 'now')) ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="partner_image" class="form-label fw-bold">
                                    Tip logo patne
                                </label>
                                <div class="border rounded p-3 bg-light">
                                    <input type="file" class="form-control mb-3" 
                                           id="partner_image" name="partner_image" 
                                           accept="image/*" data-preview="logoPreview">
                                    
                                    <?php if ($partner['image_id']): ?>
                                    <div class="alert alert-info py-2">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Imaj aktyel: ID <?= $partner['image_id'] ?>
                                    </div>
                                    <div class="text-center mb-3">
                                        <div class="bg-white rounded p-2 d-inline-block" style="width: 100px; height: 100px;">
                                            <img src="<?= $partner['image_location']?>" style="object-fit: cover; width: 100%; height: 100%" class="rounded"/>
                                        </div>
                                        <div class="mt-2">
                                            <small class="text-muted">Imaj sovgade nan baz done</small>
                                        </div>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                               id="remove_image" name="remove_image">
                                        <label class="form-check-label" for="remove_image">
                                            Siprime aktyel foto a
                                        </label>
                                    </div>
                                    <?php else: ?>
                                    <div class="text-center text-muted py-4">
                                        <i class="fas fa-building fa-3x mb-3"></i>
                                        <p class="mb-1">logo pa renouvle</p>
                                        <small>Telechaje nouvo logo</small>
                                    </div>
                                    <?php endif; ?>

                                    <div class="mt-3 text-center">
                                        <img id="logoPreview" src="#" alt="Превью нового логотипа" 
                                             class="img-fluid rounded d-none" 
                                             style="max-height: 100px; object-fit: contain;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Atansyon:</strong> Chanjman yo vizib apre sovgad.
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top d-flex justify-content-between">
                        <div>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>Sovga chanje
                            </button>
                            <a href="?action=partners" class="btn btn-secondary btn-lg">
                                <i class="fas fa-times me-2"></i>Anile
                            </a>
                        </div>
                        
                        <a href="?action=partners&method=delete&id=<?= $partner['id'] ?>" 
                           class="btn btn-outline-danger"
                           onclick="return confirm('Вы уверены, что хотите удалить партнера \"<?= addslashes($partner['name']) ?>\"? Это действие нельзя отменить.')">
                            <i class="fas fa-trash me-2"></i>Eface
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Превью нового логотипа
    const logoInput = document.getElementById('partner_image');
    const logoPreview = document.getElementById('logoPreview');
    
    logoInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                logoPreview.src = e.target.result;
                logoPreview.classList.remove('d-none');
            }
            reader.readAsDataURL(file);
        } else {
            logoPreview.classList.add('d-none');
        }
    });

    // Подтверждение при установке флага удаления изображения
    const removeImageCheckbox = document.getElementById('remove_image');
    if (removeImageCheckbox) {
        removeImageCheckbox.addEventListener('change', function() {
            if (this.checked) {
                if (!confirm('Ou seten ke ou vle siprime imaj kounya a')) {
                    this.checked = false;
                }
            }
        });
    }
});
</script>

<style>
.card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}
.form-control-lg {
    border-radius: 0.5rem;
}
</style>

<?php require_once ROOT_PATH . '/views/layout/footer.php'; ?>