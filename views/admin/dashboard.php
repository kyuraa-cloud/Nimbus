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

// =========================
// Statistik
$q_total = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tasks WHERE user_id = $userId");
$totalTask = mysqli_fetch_assoc($q_total)['total'];
// =========================
$q_total = mysqli_query($conn, "SELECT COUNT(*) AS total FROM users");
$totalUsers = mysqli_fetch_assoc($q_total)['total'];

$q_todo = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tasks WHERE user_id = $userId AND status='to do'");
$todo = mysqli_fetch_assoc($q_todo)['total'];

$q_progress = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tasks WHERE user_id = $userId AND status='in progress'");
$inProgress = mysqli_fetch_assoc($q_progress)['total'];
$q_tasks = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tasks WHERE user_id = $userId");
$totalTask = mysqli_fetch_assoc($q_tasks)['total'];

$q_done = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tasks WHERE user_id = $userId AND status='done'");
$done = mysqli_fetch_assoc($q_done)['total'];

$q_pending = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tasks WHERE user_id = $userId AND status!='done'");
$pending = mysqli_fetch_assoc($q_pending)['total'];

// =========================
// Recent Users
// =========================
$q_recent_users = mysqli_query($conn, "
    SELECT name, email, created_at 
    FROM users 
    ORDER BY id DESC 
    LIMIT 5
");

// helper untuk waktu relatif
function timeAgo($datetime) {
    $timestamp = strtotime($datetime);
    $diff = time() - $timestamp;

    if ($diff < 60) return $diff . " seconds ago";
    elseif ($diff < 3600) return floor($diff / 60) . " minutes ago";
    elseif ($diff < 86400) return floor($diff / 3600) . " hours ago";
    else return floor($diff / 86400) . " days ago";
}

ob_start();
?>

<h2 style="color:#2F2843; font-weight:700;">Admin Dashboard</h2>
<p style="color:#6c5a8d;">System Overview dan Monitoring</p>

<!-- STAT GRID SAJA -->
<!-- STAT GRID -->
<div class="dashboard-grid">
    <div class="card-stat">
        <div class="stat-title">Total Users</div>
        <div class="stat-number"><?= $totalTask ?></div>
        <div class="stat-number"><?= $totalUsers ?></div>
    </div>

    <div class="card-stat">
        <div class="stat-title">Total Tasks</div>
        <div class="stat-number"><?= $todo ?></div>
        <div class="stat-number"><?= $totalTask ?></div>
    </div>

    <div class="card-stat">
        <div class="stat-title">Completed Tasks</div>
        <div class="stat-number"><?= $inProgress ?></div>
        <div class="stat-number"><?= $done ?></div>
    </div>

    <div class="card-stat">
        <div class="stat-title">Pending Tasks</div>
        <div class="stat-number"><?= $done ?></div>
        <div class="stat-number"><?= $pending ?></div>
    </div>
</div>

<h3 style="color:#2F2843; font-weight:700;">Recenet Users</h2>




<h3 style="color:#2F2843; font-weight:700;">Recent Tasks</h2>

<!-- RECENT USERS -->
<h3 style="color:#2F2843; font-weight:700; margin-top:20px;">Recent Users</h3>
<div style="margin-top: 16px;">
    <table style="width:100%; border-collapse: collapse; background-color: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 6px rgba(0,0,0,0.06);">
        <thead style="background-color: #f5f5f5;">
            <tr>
                <th style="text-align:left; padding:12px; color:#2F2843;">Name</th>
                <th style="text-align:left; padding:12px; color:#2F2843;">Email</th>
                <th style="text-align:left; padding:12px; color:#2F2843;">Joined</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($u = mysqli_fetch_assoc($q_recent_users)) { ?>
                <tr>
                    <td style="padding:12px; border-top:1px solid #eee;"><?= htmlspecialchars($u['name']) ?></td>
                    <td style="padding:12px; border-top:1px solid #eee;"><?= htmlspecialchars($u['email']) ?></td>
                    <td style="padding:12px; border-top:1px solid #eee; color:#6c5a8d;"><?= timeAgo($u['created_at']) ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- RECENT TASKS -->
<h3 style="color:#2F2843; font-weight:700; margin-top:20px;">Recent Tasks</h3>
<!-- Tambahkan query & tampilan tasks di sini -->

<?php
$content = ob_get_clean();