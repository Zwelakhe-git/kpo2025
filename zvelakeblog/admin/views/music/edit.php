<?php require_once 'views/layout/header.php'; ?>

<h2>Redije Trak</h2>

<?php if (isset($error)): ?>
<div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="track_name" class="form-label">Non trak *</label>
                <input type="text" class="form-control" id="track_name" name="track_name" 
                       value="<?= htmlspecialchars($track['track_name'] ?? '') ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="artist_id" class="form-label">Аtis *</label>
                <select class="form-control" id="artist_id" name="artist_id" required>
                    <option value="">Chwazi atis</option>
                    <?php foreach ($artists as $artist): ?>
                    <option value="<?= $artist['id'] ?>" 
                        <?= ($artist['id'] == $track['artist_id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($artist['name']) ?>
                    </option>
                    <?php endforeach; ?>
                    <option value="new">+ Ajoute nouvo atis</option>
                </select>
            </div>
            
            <div class="mb-3" id="new_artist_field" style="display: none;">
                <label for="new_artist_name" class="form-label">Non nouvo atis *</label>
                <input type="text" class="form-control" id="new_artist_name" name="new_artist_name">
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="likes" class="form-label">j'aimes</label>
                        <input type="number" class="form-control" id="likes" name="likes" 
                               value="<?= $track['likes'] ?? 0 ?>" min="0">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="downloads" class="form-label">Telechajman</label>
                        <input type="number" class="form-control" id="downloads" name="downloads" 
                               value="<?= $track['downloads'] ?? 0 ?>" min="0">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="plays" class="form-label">Ekout</label>
                        <input type="number" class="form-control" id="plays" name="plays" 
                               value="<?= $track['plays'] ?? 0 ?>" min="0">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="mb-3">
                <label for="track_image" class="form-label">Cover trak</label>
                <input type="file" class="form-control" id="track_image" name="track_image" 
                       accept="image/*" data-preview="coverPreview">
                
                <?php if ($track['image_location']): ?>
                <div class="mt-2">
                    <p>Aktyel Cover:</p>
                    <img src="<?= $track['image_location'] ?>" width="200" class="img-thumbnail">
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" id="remove_image" name="remove_image">
                        <label class="form-check-label" for="remove_image">
                            Efase aktyel Cover
                        </label>
                    </div>
                </div>
                <?php else: ?>
                <div class="mt-2 text-center">
                    <div class="text-muted border rounded p-4">
                        <i class="fas fa-music fa-2x mb-2"></i>
                        <br>Cover non ajou
                    </div>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="card mt-3">
                <div class="card-body">
                    <h6>Enfomasyon fichye</h6>
                    <?php if ($track['location']): ?>
                    <p><strong>fichye:</strong> <?= basename($track['location']) ?></p>
                    <p><strong>Tip:</strong> <?= $track['mime_type'] ?></p>
                    <p><strong>lokasyon:</strong> <?= $track['location'] ?></p>
                    <?php else: ?>
                    <p class="text-muted">Fichye non telechaje</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-2"></i>Renouvle trak
        </button>
        <a href="?action=music" class="btn btn-secondary">
            <i class="fas fa-times me-2"></i>Refize
        </a>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const artistSelect = document.getElementById('artist_id');
    const newArtistField = document.getElementById('new_artist_field');
    
    artistSelect.addEventListener('change', function() {
        if (this.value === 'new') {
            newArtistField.style.display = 'block';
        } else {
            newArtistField.style.display = 'none';
        }
    });

    // Превью новой обложки
    const coverInput = document.getElementById('track_image');
    coverInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            // В реальном проекте здесь будет превью
            console.log('Новая обложка выбрана:', file.name);
        }
    });
});
</script>

<?php require_once ROOT_PATH . '/views/layout/footer.php'; ?>