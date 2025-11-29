<?php
header('Content-Type: application/json');

// contoh: ambil nama user dari GET
$user = isset($_GET['user']) ? $_GET['user'] : "Kelompok 2";

// return JSON
echo json_encode([
    "username" => $user
]);
?>
