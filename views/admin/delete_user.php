<?php
session_start();
require "../../config/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$userId = $_GET['id'];

// Cegah admin menghapus dirinya sendiri
if ($userId == $_SESSION['user_id']) {
    die("You cannot delete your own account.");
}

mysqli_query($conn, "DELETE FROM users WHERE id = $userId");

$_SESSION['success'] = "User deleted successfully!";
header("Location: user_admin.php");
exit;
