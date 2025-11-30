<?php
session_start();
require "../../config/db.php";

$userId = $_SESSION['user_id'];

$start_date = $_POST['start_date'];
$due_date   = $_POST['due_date'];
$name     = $_POST['name'];
$priority = $_POST['priority'];
$status   = $_POST['status'];

$sql = "INSERT INTO tasks (user_id, start_date, due_date, name, priority, status)
        VALUES ($userId, '$start_date', '$due_date', '$name', '$priority', '$status')";


mysqli_query($conn, $sql);

$_SESSION['success'] = "Task added successfully!";
header("Location: tasks.php");
exit;
