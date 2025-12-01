<?php
session_start();
require "../../config/db.php";

$title = "Calendar";
$active = "calendar";
$userId = $_SESSION['user_id'];

include "calendar_logic.php"; 

ob_start();
?>

<h2 style="color:#2F2843; font-weight:700;">Calendar</h2>
<p style="color:#6c5a8d;">View your tasks on the calendar</p>

<div class="calendar-container">
    <?php include "calendar_view.php"; ?>
</div>

<?php
$content = ob_get_clean();
include "../layouts/user_layout.php";
?>
