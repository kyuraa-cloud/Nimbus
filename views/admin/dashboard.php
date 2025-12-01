<?php
session_start();
require "../../config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$title = "Dashboard";
$active = "dashboard";

// Total semua users
$q_total_users = mysqli_query($conn, "SELECT COUNT(*) AS total FROM users");
$totalUsers = mysqli_fetch_assoc($q_total_users)['total'];

// Total semua tasks (seluruh user)
$q_total_tasks = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tasks");
$totalTask = mysqli_fetch_assoc($q_total_tasks)['total'];

// Completed (DONE)
$q_done = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tasks WHERE status='done'");
$done = mysqli_fetch_assoc($q_done)['total'];

// Pending (TO DO dan IN PROGRESS)
$q_pending = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tasks WHERE status!='done'");
$pending = mysqli_fetch_assoc($q_pending)['total'];

$q_recent_users = mysqli_query($conn, "
    SELECT name, email, created_at 
    FROM users 
    ORDER BY id DESC 
    LIMIT 7
");
$q_recent_tasks = mysqli_query($conn, "
    SELECT tasks.name AS task_name, tasks.status, tasks.created_at, users.name AS username
    FROM tasks
    JOIN users ON tasks.user_id = users.id
    ORDER BY tasks.id DESC
    LIMIT 7
");

function timeAgo($datetime) {
    $timestamp = strtotime($datetime);
    $diff = abs(time() - $timestamp);

    if ($diff < 60) return $diff . " seconds ago";
    elseif ($diff < 3600) return floor($diff / 60) . " minutes ago";
    elseif ($diff < 86400) return floor($diff / 3600) . " hours ago";
    else return floor($diff / 86400) . " days ago";
}

ob_start();
?>

<h2 style="color:#2F2843; font-weight:700;">Admin Dashboard</h2>
<p style="color:#6c5a8d;">System Overview dan Monitoring</p>

<!-- STAT GRID -->
<div class="dashboard-grid">

    <div class="card-stat">
        <div class="stat-title">Total Users</div>
        <div class="stat-number"><?= $totalUsers ?></div>
    </div>

    <div class="card-stat">
        <div class="stat-title">Total Tasks</div>
        <div class="stat-number"><?= $totalTask ?></div>
    </div>

    <div class="card-stat">
        <div class="stat-title">Completed Tasks</div>
        <div class="stat-number"><?= $done ?></div>
    </div>

    <div class="card-stat">
        <div class="stat-title">Pending Tasks</div>
        <div class="stat-number"><?= $pending ?></div>
    </div>

</div>

<!-- RECENT USERS -->
<h3 style="color:#2F2843; font-weight:700; margin-top:25px;">Recent Users</h3>

<div style="margin-top: 16px;">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Joined</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($u = mysqli_fetch_assoc($q_recent_users)) { ?>
                <tr>
                    <td><?= htmlspecialchars($u['name']) ?></td>
                    <td><?= htmlspecialchars($u['email']) ?></td>
                    <td><?= timeAgo($u['created_at']) ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<h3 style="color:#2F2843; font-weight:700; margin-top:25px;">Recent Tasks</h3>

<div style="margin-top: 16px;">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Task</th>
                <th>User</th>
                <th>Status</th>
                <th>Created</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($t = mysqli_fetch_assoc($q_recent_tasks)) { ?>
                <tr>
                    <td><?= htmlspecialchars($t['task_name']) ?></td>
                    <td><?= htmlspecialchars($t['username']) ?></td>
                    <td><?= ucfirst($t['status']) ?></td>
                    <td><?= timeAgo($t['created_at']) ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php
$content = ob_get_clean();
include "../layouts/admin_layout.php";
