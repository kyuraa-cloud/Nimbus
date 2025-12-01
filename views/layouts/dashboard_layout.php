<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>

    <link rel="stylesheet" href="/nimbus/assets/css/dashboard.css">
    <link rel="stylesheet" href="/nimbus/assets/css/tasks.css">
    <link rel="stylesheet" href="/nimbus/assets/css/calender.css">
    <link rel="stylesheet" href="/nimbus/assets/css/calendar.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</head>
<script src="/Nimbus/assets/js/alerts.js"></script>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <div class="sidebar-logo">
        <img src="/nimbus/assets/img/nimbuss.jpg" class="logo-img">
    </div>

    <a href="dashboard.php" class="<?= $active == 'dashboard' ? 'active-menu' : '' ?>">Dashboard</a>

<?php if($_SESSION['role'] != 'admin'): ?>    
    <a href="tasks.php" class="<?= $active == 'task' ? 'active-menu' : '' ?>">My Task</a>
<?php endif; ?>

<?php if($_SESSION['role'] != 'user'): ?>    
    <a href="tasks.php" class="<?= $active == 'tasks' ? 'active-menu' : '' ?>">Tasks</a>
<?php endif; ?>

<?php if($_SESSION['role'] != 'admin'): ?>
    <a href="calendar.php" class="<?= $active == 'calendar' ? 'active-menu' : '' ?>">Calendar</a>
<?php endif; ?>

<?php if($_SESSION['role'] != 'user'): ?>
    <a href="users.php" class="<?= $active == 'users' ? 'active-menu' : '' ?>">Users</a>
<?php endif; ?>

    <a href="settings.php" class="<?= $active == 'settings' ? 'active-menu' : '' ?>">Settings</a>
    

    <hr style="border-color:rgba(255,255,255,0.2);">

    <a href="../auth/logout.php">Logout</a>
</div>

<div class="main">
    <?= $content ?>
</div>

</body>
</html>
