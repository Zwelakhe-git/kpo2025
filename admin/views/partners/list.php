<?php require_once ROOT_PATH . '/views/layout/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Kontwol patne</h2>
    <a href="?action=partners&method=create" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Ajoute patne
    </a>
</div>

<?php if (isset($_GET['success'])): ?>
<div class="alert alert-success alert-dismissible fade show">
    <i class="fas fa-check-circle me-2"></i>Operasyon reyisi!
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<?php if (isset($_GET['error'])): ?>
<div class="alert alert-danger alert-dismissible fade show">
    <i class="fas fa-exclamation-triangle me-2"></i>Ere pandan operasyon an
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<div class="card">
    <div class="card-header bg-light">
        <h5 class="mb-0">Lis patne</h5>
    </div>
    <div class="card-body">
        <?php if (empty($partners)): ?>
        <div class="text-center py-5">
            <i class="fas fa-handshake fa-3x text-muted mb-3"></i>
            <h4 class="text-muted">Pa jwennn patne</h4>
            <p class="text-muted">Ajoute premye patne</p>
            <a href="?action=partners&method=create" class="btn btn-primary mt-2">
                <i class="fas fa-plus me-2"></i>Ajoute patne
            </a>
        </div>
        <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th width="80">ID</th>
                        <th width="100">logo</th>
                        <th>Non</th>
                        <th width="120">Imaj ID</th>
                        <th width="150" class="text-center">Aksyon</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($partners as $partner): ?>
                    <tr>
                        <td class="fw-bold"><?= $partner['id'] ?></td>
                        <td>
                            <?php if ($partner['image_id']): ?>
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                 style="width: 60px; height: 60px;">
                                 
                                <img src="<?= $partner['image_location']?>" style="object-fit: cover; width: 100%; height: 100%" class="rounded"/>
                            </div>
                            <?php else: ?>
                            <div class="bg-secondary rounded d-flex align-items-center justify-content-center" 
                                 style="width: 60px; height: 60px;">
                                <i class="fas fa-image text-white"></i>
                            </div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <h6 class="mb-1"><?= htmlspecialchars($partner['name']) ?></h6>
                            <small class="text-muted">Добавлен: <?= date('d.m.Y', strtotime($partner['created_at'] ?? 'now')) ?></small>
                        </td>
                        <td>
                            <?php if ($partner['image_id']): ?>
                            <span class="badge bg-info">ID: <?= $partner['image_id'] ?></span>
                            <?php else: ?>
                            <span class="badge bg-warning">Pa ajoute</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm w-100">
                                <a href="?action=partners&method=edit&id=<?= $partner['id'] ?>" 
                                   class="btn btn-outline-primary" title="Редактировать">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="?action=partners&method=delete&id=<?= $partner['id'] ?>" 
                                   class="btn btn-outline-danger" 
                                   onclick="return confirm('Удалить партнера \"<?= addslashes($partner['name']) ?>\"?')"
                                   title="Удалить">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
    <div class="card-footer bg-light">
        <small class="text-muted">
            <i class="fas fa-info-circle me-1"></i>
            Nonb patne: <strong><?= count($partners) ?></strong>
        </small>
    </div>
</div>

<?php require_once ROOT_PATH . '/views/layout/footer.php'; ?>