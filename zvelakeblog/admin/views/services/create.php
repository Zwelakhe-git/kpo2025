<?php require_once 'views/layout/header.php'; ?>

<h2>Ajoute Sevis</h2>

<?php if (isset($error)): ?>
<div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="name" class="form-label">Non Sevis</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>
    
    <div class="mb-3">
        <label for="description" class="form-label"></label>Deskripsyon
        <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
    </div>
    
    <div class="mb-3">
        <label for="service_image" class="form-label">Imaj Sevis</label>
        <input type="file" class="form-control" id="service_image" name="service_image" accept="image/*" data-preview="service-prev-img">
        <img id="service-prev-img" style="display:none;width: 150px; height: 150px; margin-top: 10px"/>
    </div>
    
    <button type="submit" class="btn btn-primary">Kreye sevis</button>
    <a href="?action=services" class="btn btn-secondary">Anile</a>
</form>

<?php require_once 'views/layout/footer.php'; ?>