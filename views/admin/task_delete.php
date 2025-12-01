<?php
session_start();
require "../../config/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$taskId = $_GET['id'];

mysqli_query($conn, "DELETE FROM tasks WHERE id = $taskId");

$_SESSION['success'] = "Task deleted successfully.";
header("Location: task_admin.php");
exit;
