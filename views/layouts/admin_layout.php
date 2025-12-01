<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>

    <link rel="stylesheet" href="/nimbus/assets/css/admin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/Nimbus/assets/js/alerts.js"></script>
</head>

<body>
<div class="sidebar">
    <div class="sidebar-logo">
        <img src="/nimbus/assets/img/nimbuss.jpg" class="logo-img">
    </div>
    <a href="/Nimbus/views/admin/dashboard.php" class="<?= $active == 'dashboard' ? 'active-menu' : '' ?>">Dashboard</a>
    <a href="/Nimbus/views/admin/user_admin.php" class="<?= $active == 'user_admin' ? 'active-menu' : '' ?>">Users</a>
    <a href="/Nimbus/views/admin/task_admin.php" class="<?= $active == 'task_admin' ? 'active-menu' : '' ?>">Tasks</a>
    <hr style="border-color:rgba(255,255,255,0.2);">
    <a href="/Nimbus/views/auth/logout.php">Logout</a>
</div>

<div class="main">
    <?= $content ?>
</div>

</body>
</html>
