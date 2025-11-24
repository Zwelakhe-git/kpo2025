<?php require_once ROOT_PATH . '/views/layout/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Ajoute Patne</h2>
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
            <div class="card-header bg-light">
                <h5 class="mb-0">Enfomasyon patne</h5>
            </div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="partner_name" class="form-label fw-bold">
                                    Non patne *
                                </label>
                                <input type="text" class="form-control form-control-lg" 
                                       id="partner_name" name="partner_name" 
                                       placeholder="Antre non Konpayi patne a" required
                                       value="<?= htmlspecialchars($_POST['partner_name'] ?? '') ?>">
                                <div class="form-text">
                                    Non ofisyel konpayi patne
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Stati</label>
                                <div class="form-control-plaintext">
                                    <span class="badge bg-success">
                                        <i class="fas fa-check me-1"></i>Aktif
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="partner_image" class="form-label fw-bold">
                                    logo patne
                                </label>
                                <div class="border rounded p-4 text-center bg-light">
                                    <input type="file" class="form-control" 
                                           id="partner_image" name="partner_image" 
                                           accept="image/*" data-preview="logoPreview">
                                    
                                    <div class="mt-3">
                                        <img id="logoPreview" src="#" alt="Превью логотипа" 
                                             class="img-fluid rounded d-none" 
                                             style="max-height: 120px; object-fit: contain;">
                                        <div id="noLogoPreview" class="text-muted">
                                            <i class="fas fa-building fa-3x mb-3"></i>
                                            <p class="mb-1">Logo non choisi</p>
                                            <small>Dimansyon rekomande: 300x150px</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-text">
                                    Telechaje logo konpayi a sou foma JPG, PNG или SVG
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <i class="fas fa-info-circle me-2"></i>Enfomasyon
                                    </h6>
                                    <ul class="small mb-0">
                                        <li>Espas ranplisaj* </li>
                                        <li>Tip logo a ap moute sou sit lan selon gwose patne a</li>
                                        <li>Apre ajoute patne, ka ajoute lot enfomasyon </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i>Kreye patne
                        </button>
                        <a href="?action=partners" class="btn btn-secondary btn-lg">
                            <i class="fas fa-times me-2"></i>Anile
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Превью логотипа
    const logoInput = document.getElementById('partner_image');
    const logoPreview = document.getElementById('logoPreview');
    const noLogoPreview = document.getElementById('noLogoPreview');
    
    logoInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                logoPreview.src = e.target.result;
                logoPreview.classList.remove('d-none');
                noLogoPreview.classList.add('d-none');
            }
            reader.readAsDataURL(file);
        } else {
            logoPreview.classList.add('d-none');
            noLogoPreview.classList.remove('d-none');
        }
    });

    // Валидация формы
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const partnerName = document.getElementById('partner_name').value.trim();
        if (!partnerName) {
            e.preventDefault();
            alert('svp, antre non patne a');
            return false;
        }
    });
});
</script>

<style>
#noLogoPreview {
    padding: 2rem;
}
.card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}
.form-control-lg {
    border-radius: 0.5rem;
}
</style>

<?php require_once ROOT_PATH . '/views/layout/footer.php'; ?>