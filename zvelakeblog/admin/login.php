<?php
require_once 'config/database.php';
require_once 'config/auth.php';

$auth = new Auth();

// Redirect if already logged in
if ($auth->isLoggedIn()) {
    header('Location: index.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if ($auth->login($email, $password)) {
        header('Location: index.php');
        exit;
    } else {
        $error = "Emel oubyen modpas pa kòrèk";
    }
}
?>
<!DOCTYPE html>
<html lang="ht">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Antre nan Panel Admen - konektem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .login-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            overflow: hidden;
        }
        .login-header {
            background: #2c3e50;
            color: white;
            padding: 30px;
            text-align: center;
        }
        .login-body {
            padding: 40px;
        }
        .btn-primary {
            background: #3498db;
            border: none;
            padding: 12px;
        }
        .btn-primary:hover {
            background: #2980b9;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="login-card">
                    <div class="login-header">
                        <h2><i class="fas fa-lock"></i> Antre nan Panel Admen</h2>
                        <p class="mb-0">konektem Admin Panel</p>
                    </div>
                    <div class="login-body">
                        <?php if (isset($_GET['timeout'])): ?>
                            <div class="alert alert-warning">Sesyon ou fin ekspire. Tanpri antre ankò.</div>
                        <?php endif; ?>
                        
                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger"><?= $error ?></div>
                        <?php endif; ?>
                        
                        <form method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label">Emel</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control" id="email" name="email" required 
                                           placeholder="antre@imèl.ou">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="password" class="form-label">Modpas</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    <input type="password" class="form-control" id="password" name="password" required 
                                           placeholder="password">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 btn-lg">
                                <i class="fas fa-sign-in-alt"></i> Antre
                            </button>
                        </form>
                        
                        <div class="text-center mt-4">
                            <small class="text-muted">
                                <i class="fas fa-shield-alt"></i> Zòn admen an sèlman
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>