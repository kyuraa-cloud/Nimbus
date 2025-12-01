<?php
session_start();
require "../../config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$taskId = $_GET['id'];
$userId = $_SESSION['user_id'];

$start = $_POST['start_date'];
$due   = $_POST['due_date'];
$name     = $_POST['name'];
$priority = $_POST['priority'];
$status   = $_POST['status'];

$sql = "UPDATE tasks SET 
        start_date='$start',
        due_date='$due',
        name='$name',
        priority='$priority',
        status='$status'
        WHERE id=$taskId AND user_id=$userId";

if (mysqli_query($conn, $sql)) {
    $_SESSION['success'] = "Task updated successfully!";
} else {
    $_SESSION['success'] = "Failed to update task.";
}

header("Location: ../user/tasks.php");
exit;

