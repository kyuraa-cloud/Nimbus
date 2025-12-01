<?php
session_start();
require "../../config/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$title = "User Management";
$active = "user_admin";

// default keyword
$keyword = isset($_GET['search']) ? trim($_GET['search']) : "";

// QUERY: tampilkan user saja, admin disembunyikan
$sql = "
    SELECT id, name, email, created_at 
    FROM users 
    WHERE role = 'user'
";

// Jika search ada isinya
if ($keyword !== "") {
    $keywordEsc = mysqli_real_escape_string($conn, $keyword);
    $sql .= " AND (name LIKE '%$keywordEsc%' OR email LIKE '%$keywordEsc%')";
}

$sql .= " ORDER BY id DESC";

$q_users = mysqli_query($conn, $sql);

// function time ago
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

<h2 style="color:#2F2843; font-weight:700;">User Management</h2>
<p style="color:#6c5a8d;">Manage all users registered in the system.</p>

<!-- SEARCH FORM -->
<form method="GET" class="d-flex mb-3" style="max-width: 400px; gap:10px;">
    <input 
        type="text" 
        name="search" 
        class="form-control" 
        placeholder="Search user..." 
        value="<?= htmlspecialchars($keyword) ?>"
    >
    <button class="btn btn-primary" style="background:#8A6EB8; border:none;">Search</button>
</form>

<!-- TABEL USER -->
<table class="admin-table">
    <thead>
        <tr>
            <th style="color:white;">Name</th>
            <th style="color:white;">Email</th>
            <th style="color:white;">Joined</th>
            <th style="color:white;">Actions</th>
        </tr>
    </thead>

    <tbody>
        <?php while ($u = mysqli_fetch_assoc($q_users)) { ?>
        <tr>
            <td><?= htmlspecialchars($u['name']) ?></td>
            <td><?= htmlspecialchars($u['email']) ?></td>
            <td><?= timeAgo($u['created_at']) ?></td>
            <td>
                <a href="edit_user.php?id=<?= $u['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                <a 
                    href="delete_user.php?id=<?= $u['id'] ?>" 
                    class="btn btn-danger btn-sm"
                    onclick="return confirm('Delete this user?')"
                >Delete</a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<?php
$content = ob_get_clean();
include "../layouts/admin_layout.php";
?>
