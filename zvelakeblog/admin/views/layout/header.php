<?php
require_once __DIR__ . '/../../config/auth.php';
$auth = new Auth();
$current_user = $auth->getCurrentUser();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel admen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .navbar-nav .nav-link {
            padding: 0.5rem 1rem;
            margin: 0 0.2rem;
            border-radius: 0.25rem;
            transition: all 0.3s ease;
        }
        
        .navbar-nav .nav-link:hover {
            background-color: rgba(255,255,255,0.1);
        }
        
        .navbar-nav .nav-link.active {
            background-color: rgba(255,255,255,0.2);
        }
        
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border: 1px solid rgba(0, 0, 0, 0.125);
        }
        
        .table th {
            border-top: none;
            font-weight: 600;
        }
        
        .btn {
            border-radius: 0.375rem;
        }
        
        .alert {
            border: none;
            border-radius: 0.5rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="?action=dashboard">
                <i class="fas fa-cogs me-2"></i>Panel admen
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= ($_GET['action'] ?? '') == 'dashboard' ? 'active' : '' ?>" href="?action=dashboard">
                            <i class="fas fa-tachometer-alt me-1"></i>Dachbod
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($_GET['action'] ?? '') == 'news' ? 'active' : '' ?>" href="?action=news">
                            <i class="fas fa-newspaper me-1"></i>Nouvel
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($_GET['action'] ?? '') == 'music' ? 'active' : '' ?>" href="?action=music">
                            <i class="fas fa-music me-1"></i>Mizik
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($_GET['action'] ?? '') == 'videos' ? 'active' : '' ?>" href="?action=videos">
                            <i class="fas fa-video me-1"></i>Videyo
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($_GET['action'] ?? '') == 'services' ? 'active' : '' ?>" href="?action=services">
                            <i class="fas fa-concierge-bell me-1"></i>Sevis
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($_GET['action'] ?? '') == 'events' ? 'active' : '' ?>" href="?action=events">
                            <i class="fas fa-calendar-alt me-1"></i>Eveneman
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($_GET['action'] ?? '') == 'livestream' ? 'active' : '' ?>" href="?action=livestream">
                            <i class="fas fa-broadcast-tower me-1"></i>Strimin
                        </a>
                    </li>
                    <!--<li class="nav-item">
                        <a class="nav-link <?= ($_GET['action'] ?? '') == 'orders' ? 'active' : '' ?>" href="?action=orders">
                            <i class="fa-regular fa-book"></i>orders
                        </a>
                    </li>-->
                    <li class="nav-item">
                        <a class="nav-link <?= ($_GET['action'] ?? '') == 'partners' ? 'active' : '' ?>" href="?action=partners">
                            <i class="fa-regular fa-handshake"></i>Patnè
                        </a>
                    </li>
                    
                </ul>
                
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user me-1"></i><?= htmlspecialchars($current_user) ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Paramet</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Soti</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-4">