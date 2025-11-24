<?php
define("ROOT_PATH", __DIR__);
require_once 'views/layout/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Kontwol sevis</h2>
    <a href="?action=services&method=create" class="btn btn-primary">
        <i class="fas fa-plus"></i> Ajoute sevis
    </a>
</div>

<?php if (isset($_GET['success'])): ?>
<div class="alert alert-success">Operasyon reyisi!</div>
<?php endif; ?>

<div class="row">
    <?php foreach ($services as $service): ?>
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <?php if ($service['image_location']): ?>
            <img src="<?= $service['image_location'] ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
            <?php endif; ?>
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($service['name']) ?></h5>
                <p class="card-text"><?= nl2br(htmlspecialchars(substr($service['description'], 0, 100))) ?>...</p>
            </div>
            <div class="card-footer">
                <a href="?action=services&method=edit&id=<?= $service['id'] ?>" class="btn btn-sm btn-warning">
                    <i class="fas fa-edit"></i>
                </a>
                <a href="?action=services&method=delete&id=<?= $service['id'] ?>" 
                   class="btn btn-sm btn-danger" 
                   onclick="return confirm('Удалить услугу?')">
                    <i class="fas fa-trash"></i>
                </a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php require_once 'views/layout/footer.php'; ?>