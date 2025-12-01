<?php
session_start();
require "../../config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$title = "Dashboard";
$active = "dashboard";

$userId = $_SESSION['user_id'];

// Statistik
$q_total = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tasks WHERE user_id = $userId");
$totalTask = mysqli_fetch_assoc($q_total)['total'];

$q_todo = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tasks WHERE user_id = $userId AND status='to do'");
$todo = mysqli_fetch_assoc($q_todo)['total'];

$q_progress = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tasks WHERE user_id = $userId AND status='in progress'");
$inProgress = mysqli_fetch_assoc($q_progress)['total'];

$q_done = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tasks WHERE user_id = $userId AND status='done'");
$done = mysqli_fetch_assoc($q_done)['total'];

ob_start();
?>

<h2 style="color:#2F2843; font-weight:700;">Admin Dashboard</h2>
<p style="color:#6c5a8d;">System Overview dan Monitoring</p>

<!-- STAT GRID SAJA -->
<div class="dashboard-grid">
    <div class="card-stat">
        <div class="stat-title">Total Users</div>
        <div class="stat-number"><?= $totalTask ?></div>
    </div>

    <div class="card-stat">
        <div class="stat-title">Total Tasks</div>
        <div class="stat-number"><?= $todo ?></div>
    </div>

    <div class="card-stat">
        <div class="stat-title">Completed Tasks</div>
        <div class="stat-number"><?= $inProgress ?></div>
    </div>

    <div class="card-stat">
        <div class="stat-title">Pending Tasks</div>
        <div class="stat-number"><?= $done ?></div>
    </div>
</div>

<h3 style="color:#2F2843; font-weight:700;">Recenet Users</h2>




<h3 style="color:#2F2843; font-weight:700;">Recent Tasks</h2>



<?php
$content = ob_get_clean();
include "../layouts/dashboard_layout.php";
