<?php
session_start();
require "../../config/db.php";

$userId = $_SESSION['user_id'];

$date     = $_POST['date'];
$name     = $_POST['name'];
$priority = $_POST['priority'];
$status   = $_POST['status'];

$sql = "INSERT INTO tasks (user_id, date, name, priority, status)
        VALUES ($userId, '$date', '$name', '$priority', '$status')";

mysqli_query($conn, $sql);

$_SESSION['success'] = "Task added successfully!";
header("Location: tasks.php");
exit;
