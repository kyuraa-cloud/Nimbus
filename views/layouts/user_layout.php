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

    <link rel="stylesheet" href="/nimbus/assets/css/user.css">
    <link rel="stylesheet" href="/nimbus/assets/css/tasks.css">
    <link rel="stylesheet" href="/nimbus/assets/css/calender.css">
    <link rel="stylesheet" href="/nimbus/assets/css/calendar.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

<div class="sidebar">
    <div class="sidebar-logo">
        <img src="/nimbus/assets/img/nimbuss.jpg" class="logo-img">
    </div>

    <a href="/Nimbus/views/user/dashboard.php" class="<?= $active == 'dashboard' ? 'active-menu' : '' ?>">Dashboard</a>
    <a href="/Nimbus/views/user/tasks.php" class="<?= $active == 'task' ? 'active-menu' : '' ?>">My Task</a>
    <a href="/Nimbus/views/user/calendar.php" class="<?= $active == 'calendar' ? 'active-menu' : '' ?>">Calendar</a>
    <a href="/Nimbus/views/user/settings.php" class="<?= $active == 'settings' ? 'active-menu' : '' ?>">Settings</a>

    <hr style="border-color:rgba(255,255,255,0.2);">

    <a href="../auth/logout.php">Logout</a>
</div>

<div class="main">
    <?= $content ?>
</div>

</body>
</html>
