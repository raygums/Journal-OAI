<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="main-header">
        <div class="container">
            <a href="index.php" class="logo">Unila E-Journal System</a>
            <nav class="main-nav">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="fakultas.php">Fakultas</a></li>
                    </ul>
            </nav>
            <div class="user-actions">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="dashboard_admin.php" class="btn-login">Dashboard</a>
                    <a href="api/logout.php" class="btn-logout">Logout</a>
                <?php else: ?>
                    <a href="login.html" class="btn-login">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </header>