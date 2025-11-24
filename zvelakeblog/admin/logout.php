<?php
require_once 'config/database.php';
require_once 'config/auth.php';

$auth = new Auth();
$auth->logout();

header('Location: login.php');
exit;
?>