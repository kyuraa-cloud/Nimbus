<?php
session_start();
require "../../config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$taskId = $_GET['id'];
$userId = $_SESSION['user_id'];

$sql = "DELETE FROM tasks WHERE id=$taskId AND user_id=$userId";

if (mysqli_query($conn, $sql)) {
    $_SESSION['success'] = "Task deleted successfully!";
} else {
    $_SESSION['success'] = "Failed to delete task.";
}

header("Location: tasks.php");
exit;
