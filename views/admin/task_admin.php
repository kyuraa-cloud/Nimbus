<?php
session_start();
require "../../config/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$title = "Task Management";
$active = "task_admin";

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : "";

$q_tasks = mysqli_query($conn, "
    SELECT tasks.*, users.name AS user_name 
    FROM tasks
    JOIN users ON tasks.user_id = users.id
    WHERE tasks.name LIKE '%$search%' 
       OR users.name LIKE '%$search%'
    ORDER BY tasks.created_at DESC
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

<h2 style="color:#2F2843; font-weight:700;">Task Management</h2>
<p style="color:#6c5a8d;">Monitor all task activities from all users</p>

<!-- Search Bar -->
<form method="GET" class="d-flex mb-3" style="max-width: 350px;">
    <input type="text" name="search" class="form-control" placeholder="Search tasks or user..." 
           value="<?= $search ?>">
    <button class="btn btn-primary" style="background:#8A6EB8; border:none;">Search</button>
</form>

<!-- TASK TABLE -->
<table class="admin-table">
    <thead>
        <tr>
            <th>Task</th>
            <th>User</th>
            <th>Priority</th>
            <th>Status</th>
            <th>Start</th>
            <th>Due</th>
            <th>Created</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($t = mysqli_fetch_assoc($q_tasks)) { ?>
            <tr>
                <td><?= htmlspecialchars($t['name']) ?></td>
                <td><?= htmlspecialchars($t['user_name']) ?></td>

                <td><?= ucfirst($t['priority']) ?></td>
                <td><?= ucfirst($t['status']) ?></td>

                <td>
                    <?= ($t['start_date'] == null || $t['start_date'] == "0000-00-00") 
                        ? "-" 
                        : date("M d, Y", strtotime($t['start_date'])) ?>
                </td>

                <td>
                    <?= ($t['due_date'] == null || $t['due_date'] == "0000-00-00") 
                        ? "-" 
                        : date("M d, Y", strtotime($t['due_date'])) ?>
                </td>

                <td><?= timeAgo($t['created_at']) ?></td>

                <td>
                    <a href="task_delete.php?id=<?= $t['id'] ?>" 
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Delete this task?')">
                       Delete
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php
$content = ob_get_clean();
include "../layouts/admin_layout.php";
?>
