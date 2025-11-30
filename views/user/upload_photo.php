<?php
session_start();
require "../../config/db.php";

$userId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (!empty($_FILES['photo']['name'])) {

        $fileName = $_FILES['photo']['name'];
        $tmpName  = $_FILES['photo']['tmp_name'];

        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
        $allowed = ['jpg','jpeg','png','gif'];

        if (!in_array(strtolower($ext), $allowed)) {
            $_SESSION['error'] = "Only JPG, PNG, or GIF allowed.";
            header("Location: /Nimbus/views/user/settings.php");
            exit;
        }

        $newName = "user_" . $userId . "_" . time() . "." . $ext;

        move_uploaded_file($tmpName, "../../assets/uploads/" . $newName);

        mysqli_query($conn, "
            UPDATE users SET photo='$newName' WHERE id=$userId
        ");

        $_SESSION['success'] = "Profile photo updated successfully!";
    } else {
        $_SESSION['error'] = "Please choose an image first.";
    }

    header("Location: /Nimbus/views/user/settings.php");
    exit;
}
