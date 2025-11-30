<?php
session_start();
require "../../config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$taskId = $_GET['id'];
$userId = $_SESSION['user_id'];

$date     = $_POST['date'];
$name     = $_POST['name'];
$priority = $_POST['priority'];
$status   = $_POST['status'];

$sql = "UPDATE tasks 
        SET date='$date',
            name='$name',
            priority='$priority',
            status='$status'
        WHERE id=$taskId AND user_id=$userId";

if (mysqli_query($conn, $sql)) {
    $_SESSION['success'] = "Task updated successfully!";
} else {
    $_SESSION['success'] = "Failed to update task.";
}

header("Location: tasks.php");
exit;
