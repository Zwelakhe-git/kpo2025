<?php require_once 'views/layout/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Управление новостями</h2>
    <a href="?action=news&method=create" class="btn btn-primary">
        <i class="fas fa-plus"></i> Ajoute nouvel
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
                    <th>Imaj</th>
                    <th>Tit</th>
                    <th>Dat</th>
                    <th>Aksyon</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($news as $item): ?>
                <tr>
                    <td><?= $item['id'] ?></td>
                    <td>
                        <?php if ($item['image_location']): ?>
                        <img src="<?= $item['image_location'] ?>" width="50" height="50" style="object-fit: cover;" class="rounded">
                        <?php else: ?>
                        <div class="bg-secondary text-white rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="fas fa-newspaper"></i>
                        </div>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($item['newsTitle']) ?></td>
                    <td><?= $item['newsDate'] ?></td>
                    <td>
                        <a href="?action=news&method=edit&id=<?= $item['id'] ?>" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="?action=news&method=delete&id=<?= $item['id'] ?>" 
                           class="btn btn-sm btn-danger" 
                           onclick="return confirm('Удалить эту новость?')">
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