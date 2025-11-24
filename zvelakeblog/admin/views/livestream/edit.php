<?php require_once 'views/layout/header.php'; ?>

<h2>Redije strim</h2>

<?php if (isset($error)): ?>
<div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>

<form method="POST">
    <div class="row">
        <div class="col-md-8">
            <div class="mb-3">
                <label for="stream_title" class="form-label">Non strim *</label>
                <input type="text" class="form-control" id="stream_title" name="stream_title" 
                       value="<?= htmlspecialchars($stream['stream_title'] ?? '') ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="stream_date" class="form-label">Dat e le strim*</label>
                <input type="datetime-local" class="form-control" id="stream_date" name="stream_date" 
                       value="<?= date('Y-m-d\TH:i', strtotime($stream['stream_date'] ?? 'now')) ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="stream_key" class="form-label">Kle strim *</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="stream_key" name="stream_key" 
                           value="<?= htmlspecialchars($stream['stream_key'] ?? '') ?>" required readonly>
                    <button type="button" class="btn btn-outline-secondary" onclick="generateNewKey()">
                        <i class="fas fa-sync-alt"></i> Nouvo kle
                    </button>
                </div>
                <div class="form-text">Kle sa itilize pou konekte ak strim lan</div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Enfomasyon de strim la</h6>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <strong>ID:</strong> <?= $stream['id'] ?? 'Новый' ?>
                    </div>
                    <div class="mb-2">
                        <strong>Статус:</strong>
                        <?php
                        $streamDate = strtotime($stream['stream_date'] ?? '');
                        $now = time();
                        if ($streamDate > $now) {
                            echo '<span class="badge bg-warning">Запланирована</span>';
                        } elseif ($streamDate <= $now && $streamDate + 3600 > $now) {
                            echo '<span class="badge bg-success">В эфире</span>';
                        } else {
                            echo '<span class="badge bg-secondary">Завершена</span>';
                        }
                        ?>
                    </div>
                    <div class="mb-2">
                        <strong>Kreyasyon:</strong><br>
                        <?= date('d.m.Y H:i', strtotime($stream['created_at'] ?? 'now')) ?>
                    </div>
                </div>
            </div>
            
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">Aksyon rapid</h6>
                </div>
                <div class="card-body">
                    <button type="button" class="btn btn-outline-primary btn-sm w-100 mb-2">
                        <i class="fas fa-copy"></i> Kopye Kle 
                    </button>
                    <button type="button" class="btn btn-outline-info btn-sm w-100 mb-2">
                        <i class="fas fa-eye"></i> Revize
                    </button>
                    <a href="?action=livestream" class="btn btn-outline-secondary btn-sm w-100">
                        <i class="fas fa-list"></i> Retounen 
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-2"></i>Sovgade chanjman
        </button>
        <a href="?action=livestream" class="btn btn-secondary">
            <i class="fas fa-times me-2"></i>Anile
        </a>
    </div>
</form>

<script>
function generateNewKey() {
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    let newKey = '';
    for (let i = 0; i < 16; i++) {
        newKey += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    document.getElementById('stream_key').value = newKey;
}

function copyStreamKey() {
    const keyInput = document.getElementById('stream_key');
    keyInput.select();
    document.execCommand('copy');
    
    // Показать уведомление
    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-check"></i> Скопировано!';
    setTimeout(() => {
        btn.innerHTML = originalText;
    }, 2000);
}

// Инициализация
document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('[onclick="copyStreamKey()"]').addEventListener('click', copyStreamKey);
});
</script>

<style>
.card {
    border: 1px solid #e3f2fd;
}
.card-header {
    background-color: #e3f2fd;
    font-weight: 600;
}
</style>

<?php require_once ROOT_PATH . '/views/layout/footer.php'; ?>