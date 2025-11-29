<?php
// ambil data API (nama user)
$apiUrl = "dashboard.php?user=Kelompok%202"; 
$response = file_get_contents($apiUrl);
$data = json_decode($response, true);
$username = $data["username"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/nimbus/assets/css/style.css">
</head>
<body>

<div class="container">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="logo-box">
            <div class="logo">Nimbus</div>
        </div>

        <ul class="menu">
            <li>Dashboard</li>
            <li>My Task</li>
            <li>Statistics</li>
            <li>Projects</li>
            <li>Calendar</li>
            <li>Settings</li>
        </ul>

        <div class="logout-box">Logout</div>
    </div>

    <!-- MAIN AREA -->
    <div class="main">
        <div class="top-bar">
            <h1>Hi, <span><?php echo $username; ?></span></h1>
        </div>
    </div>

</div>

</body>
</html>
