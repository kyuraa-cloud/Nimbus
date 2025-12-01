<?php
session_start();
require "../../config/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$userId = $_GET['id'];

$q = mysqli_query($conn, "SELECT * FROM users WHERE id = $userId");
$user = mysqli_fetch_assoc($q);

if (!$user) {
    die("User not found.");
}

$title = "Edit User";
$active = "user_admin";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name  = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    mysqli_query($conn, "
        UPDATE users 
        SET name='$name', email='$email'
        WHERE id=$userId
    ");

    $_SESSION['success'] = "User updated successfully!";
    header("Location: user_admin.php");
    exit;
}

ob_start();
?>

<h2 style="color:#2F2843; font-weight:700;">Edit User</h2>

<form method="POST" style="max-width:450px; margin-top:25px;">

    <label class="fw-bold">Name</label>
    <input type="text" name="name" value="<?= $user['name'] ?>" class="form-control mb-3">

    <label class="fw-bold">Email</label>
    <input type="email" name="email" value="<?= $user['email'] ?>" class="form-control mb-3">

    <button class="btn btn-primary" 
            style="background:#8A6EB8; border:none;">
        Update User
    </button>
</form>

<?php
$content = ob_get_clean();
include "../layouts/admin_layout.php";
