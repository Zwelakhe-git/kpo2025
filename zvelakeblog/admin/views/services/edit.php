<?php require_once 'views/layout/header.php'; ?>

<h2>Redije sevis</h2>

<?php if (isset($error)): ?>
<div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="name" class="form-label">Non sevis</label>
        <input type="text" class="form-control" id="name" name="name" 
               value="<?= htmlspecialchars($service['name'] ?? '') ?>" required>
    </div>
    
    <div class="mb-3">
        <label for="description" class="form-label">Deskripsyon</label>
        <textarea class="form-control" id="description" name="description" rows="5" required><?= htmlspecialchars($service['description'] ?? '') ?></textarea>
    </div>
    
    <div class="mb-3">
        <label for="service_image" class="form-label">Imaj sevis</label>
        <input type="file" class="form-control" id="service_image" name="service_image" accept="image/*" data-preview="service-prev-img">
        <img id="service-prev-img" style="display:none;width: 150px; height: 150px; margin-top: 10px"/>
        <?php if ($service['image_location']): ?>
        <div class="mt-2">
            <p>Aktyel sevis:</p>
            <img src="<?= $service['image_location'] ?>" width="200" class="img-thumbnail">
        </div>
        <?php endif; ?>
    </div>
    
    <button type="submit" class="btn btn-primary">Ajoute sevis</button>
    <a href="?action=services" class="btn btn-secondary">Refize</a>
</form>

<?php require_once 'views/layout/footer.php'; ?>