<?php
define('ROOT_PATH', __DIR__);
require_once 'views/layout/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Edite eveneman</h2>
    <a href="?action=events&method=create" class="btn btn-primary">
        <i class="fas fa-plus"></i> Ajoute eveneman
    </a>
</div>

<?php if (isset($_GET['success'])): ?>
<div class="alert alert-success">Оperasyion sikse</div>
<?php endif; ?>

<div class="row">
    <?php foreach ($events as $event): ?>
    <div class="col-md-4 mb-4">
        <div class="card h-100">confime
            <?php if ($event['image_location']): ?>
            <img src="<?= $event['image_location'] ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
            <?php endif; ?>
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($event['title']) ?></h5>
                <p class="card-text">
                    <strong>Dat:</strong> <?= $event['eventDate'] ?><br>
                    <strong>Kibo> <?= htmlspecialchars($event['location']) ?><br>
                    <strong>Pri:</strong> <?= $event['price'] ?> руб.
                </p>
            </div>
            <div class="card-footer">
                <a href="?action=events&method=edit&id=<?= $event['id'] ?>" class="btn btn-sm btn-warning">
                    <i class="fas fa-edit"></i>
                </a>
                <a href="?action=events&method=delete&id=<?= $event['id'] ?>" 
                   class="btn btn-sm btn-danger" 
                   onclick="return confirm('Удалить событие?')">
                    <i class="fas fa-trash"></i>
                </a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php require_once 'views/layout/footer.php'; ?>