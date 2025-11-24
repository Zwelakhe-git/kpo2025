<?php
define('ROOT_PATH', __DIR__);
require_once 'views/layout/header.php'; ?>

<h2>Kreyasyon strimin</h2>

<form method="POST">
    <div class="mb-3">
        <label for="stream_date" class="form-label">Dat ak le striming</label>
        <input type="datetime-local" class="form-control" id="stream_date" name="stream_date" required>
    </div>
    
    <div class="mb-3">
        <label for="stream_title" class="form-label">Non Strimin</label>
        <input type="text" class="form-control" id="stream_title" name="stream_title" required>
    </div>

    <div class="mb-3">
        <label for="stream_key" class="form-label">Kle strim lan</label>
        <input type="text" class="form-control" id="stream_key" name="stream_key" required>
    </div>
    
    <button type="submit" class="btn btn-primary">Kreye strim</button>
    <a href="?action=livestream" class="btn btn-secondary">Anile</a>
</form>

<?php require_once 'views/layout/footer.php'; ?>