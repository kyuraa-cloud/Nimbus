<?php
session_start();
require "../../config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$title = "Users";
$active = "users";

// Ambil data recent users dari database
$q_recent_users = mysqli_query($conn, "
    SELECT name, email, created_at 
    FROM users 
    ORDER BY id DESC 
    LIMIT 5
");

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

<h2 style="color:#2F2843; font-weight:700;">Recent Users</h2>
<p style="color:#6c5a8d;">Daftar pengguna terbaru</p>

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

<?php
$content = ob_get_clean();
include "../layouts/dashboard_layout.php";