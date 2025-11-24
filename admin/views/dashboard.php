<?php
define('ROOT_PATH', __DIR__);
require_once 'views/layout/header.php'; ?>

<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4><?= $stats['news_count'] ?? 0 ?></h4>
                        <p>Nouvel</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-newspaper fa-2x"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="?action=news" class="text-white">Kontwol</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4><?= $stats['music_count'] ?? 0 ?></h4>
                        <p>Trak</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-music fa-2x"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="?action=music" class="text-white">Kontwol</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4><?= $stats['streams_count'] ?? 0 ?></h4>
                        <p>Strimin</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-video fa-2x"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="?action=livestream" class="text-white">Управление</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>4</h4>
                        <p>Sevis</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-cogs fa-2x"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="?action=services" class="text-white">Услуги</a>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Aksyon rapid</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="?action=news&method=create" class="btn btn-outline-primary">
                        <i class="fas fa-plus"></i> Ajoute nouvel
                    </a>
                    <a href="?action=music&method=create" class="btn btn-outline-success">
                        <i class="fas fa-plus"></i> Ajoute trak
                    </a>
                    <a href="?action=livestream&method=create" class="btn btn-outline-warning">
                        <i class="fas fa-plus"></i> Kreye strim
                    </a>
                    <a href="?action=events&method=create" class="btn btn-outline-info">
                        <i class="fas fa-plus"></i> Ajoute eveneman
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Denye aktivasyon</h5>
            </div>
            <div class="card-body">
                <p class="text-muted">Isi a wap we aksyon ou fe yo...</p>
            </div>
        </div>
    </div>
</div>

<?php require_once 'views/layout/footer.php'; ?>