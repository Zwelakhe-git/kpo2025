<?php require_once 'views/layout/header.php'; ?>

<h2>Ajoute trak</h2>

<?php if (isset($error)): ?>
<div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="track_name" class="form-label">Non trak *</label>
                <input type="text" class="form-control" id="track_name" name="track_name" required>
            </div>
            
            <div class="mb-3">
                <label for="artist_name" class="form-label">Аtis *</label>
                <select class="form-control" id="artist_name" name="artist_name" required>
                    <option value="">Chwazi atis</option>
                    <?php foreach ($artists as $artist): ?>
                    <option value="<?= $artist['id'] ?>"><?= htmlspecialchars($artist['name']) ?></option>
                    <?php endforeach; ?>
                    <option value="new">+ Ajoute nouvo atis</option>
                </select>
            </div>
            
            <div class="mb-3" id="new_artist_field" style="display: none;">
                <label for="new_artist_name" class="form-label">Non nouvo atis *</label>
                <input type="text" class="form-control" id="new_artist_name" name="new_artist_name">
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="mb-3">
                <label for="track_image" class="form-label">Cover trak</label>
                <input type="file" class="form-control" data-preview="music-track-prev-img" id="track_image" name="track_image" accept="image/*">
                <img id="music-track-prev-img" style="display:none;margin-top: 10px; width: 150px; height: 150px"/>
            </div>
            
            <div class="mb-3">
                <label for="audio_file" class="form-label">Odyo li *</label>
                <input type="file" class="form-control" id="audio_file" name="audio_file" accept="audio/*" required>
                <div class="form-text">Foma aksepte: MP3, WAV</div>
            </div>
        </div>
    </div>
    
    <button type="submit" class="btn btn-primary">Ajoute trak</button>
    <a href="?action=music" class="btn btn-secondary">Anile</a>
</form>

<script>
document.getElementById('artist_name').addEventListener('change', function() {
    const newArtistField = document.getElementById('new_artist_field');
    if (this.value === 'new') {
        newArtistField.style.display = 'block';
    } else {
        newArtistField.style.display = 'none';
    }
});
</script>

<?php require_once 'views/layout/footer.php'; ?>