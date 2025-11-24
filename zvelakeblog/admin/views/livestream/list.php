<?php
define('ROOT_PATH', __DIR__);
require_once 'views/layout/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Redije strim</h2>
    <a href="?action=livestream&method=create" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nouvo strim
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
                    <th>Dat strim lan</th>
                    <th>Non</th>
                    <th>Kle strim</th>
                    <th>Aksyon</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($streams as $stream): ?>
                <tr>
                    <td><?= $stream['id'] ?></td>
                    <td><?= $stream['stream_date'] ?></td>
                    <td><?= htmlspecialchars($stream['stream_title']) ?></td>
                    <td><code><?= $stream['stream_key'] ?></code></td>
                    <td>
                        <a href="?action=livestream&method=edit&id=<?= $stream['id'] ?>" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="?action=livestream&method=delete&id=<?= $stream['id'] ?>" 
                           class="btn btn-sm btn-danger" 
                           onclick="return confirm('Удалить трансляцию?')">
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