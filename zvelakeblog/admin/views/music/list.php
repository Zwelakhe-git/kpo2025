<?php require_once 'views/layout/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Kontrol Trak</h2>
    <a href="?action=music&method=create" class="btn btn-primary">
        <i class="fas fa-plus"></i> Ajoute trak
    </a>
</div>

<?php if (isset($_GET['success'])): ?>
<div class="alert alert-success">Operasyon reyisi!</div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cover trak</th>
                    <th>Non trak</th>
                    <th>Аtis</th>
                    <th>Ekout</th>
                    <th>J'aimes</th>
                    <th>Aksyon</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($music as $track): ?>
                <tr>
                    <td><?= $track['id'] ?></td>
                    <td>
                        <?php if ($track['image_location']): ?>
                        <img src="<?= $track['image_location'] ?>" width="50" height="50" style="object-fit: cover;" class="rounded">
                        <?php else: ?>
                        <div class="bg-secondary text-white rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="fas fa-music"></i>
                        </div>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($track['track_name']) ?></td>
                    <td><?= htmlspecialchars($track['artist_name']) ?></td>
                    <td><?= $track['plays'] ?? 0 ?></td>
                    <td><?= $track['likes'] ?? 0 ?></td>
                    <td>
                        <a href="?action=music&method=edit&id=<?= $track['id'] ?>" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="?action=music&method=delete&id=<?= $track['id'] ?>" 
                           class="btn btn-sm btn-danger" 
                           onclick="return confirm('Удалить этот трек?')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once 'views/layout/footer.php'; ?>