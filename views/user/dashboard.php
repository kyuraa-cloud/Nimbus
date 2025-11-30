<?php
session_start();
require "../../config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$title = "Dashboard";
$active = "dashboard";

$userId = $_SESSION['user_id'];
// Total semua task user
$q_total = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tasks WHERE user_id = $userId");
$totalTask = mysqli_fetch_assoc($q_total)['total'];

// Status: to do
$q_todo = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tasks WHERE user_id = $userId AND status='to do'");
$todo = mysqli_fetch_assoc($q_todo)['total'];

// Status: in progress
$q_progress = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tasks WHERE user_id = $userId AND status='in progress'");
$inProgress = mysqli_fetch_assoc($q_progress)['total'];

// Status: done
$q_done = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tasks WHERE user_id = $userId AND status='done'");
$done = mysqli_fetch_assoc($q_done)['total'];

$q_deadline = mysqli_query($conn, "
    SELECT * FROM tasks 
    WHERE user_id = $userId 
    ORDER BY date ASC 
    LIMIT 5
");

$latestTasks = [];
while ($row = mysqli_fetch_assoc($q_deadline)) {
    $latestTasks[] = $row;
}

ob_start();
?>

<h2 style="color:#2F2843; font-weight:700;">Dashboard</h2>
<p style="color:#6c5a8d;">Here's a summary of your current task progress</p>

<!-- STAT GRID -->
<div class="dashboard-grid">
    <div class="card-stat">
        <div class="stat-title">Total Tasks</div>
        <div class="stat-number"><?= $totalTask ?></div>
    </div>

    <div class="card-stat">
        <div class="stat-title">Tasks To Do</div>
        <div class="stat-number"><?= $todo ?></div>
    </div>

    <div class="card-stat">
        <div class="stat-title">Tasks In Progress</div>
        <div class="stat-number"><?= $inProgress ?></div>
    </div>

    <div class="card-stat">
        <div class="stat-title">Tasks Completed</div>
        <div class="stat-number"><?= $done ?></div>
    </div>
</div>

<!-- DEADLINE PRIORITY -->
<h3 class="section-title">Deadline Priority:</h3>



<!-- MINI CALENDAR -->
<div class="row mt-4">
    <div class="col-lg-6"></div>
    <div class="col-lg-6">
        <div class="mini-calendar">
            <div class="calendar-header">
                <span id="calendar-month"></span>
                <span id="calendar-year"></span>
            </div>

            <div class="calendar-grid" id="calendar-days"></div>
        </div>
    </div>
</div>

<!-- JS MINI CALENDAR -->
<script>
document.addEventListener("DOMContentLoaded", function () {

    const monthName = [
        "January","February","March","April","May","June",
        "July","August","September","October","November","December"
    ];

    const dayName = ["M", "T", "W", "T", "F", "S", "S"];

    const now = new Date();
    const year = now.getFullYear();
    const month = now.getMonth();

    document.getElementById('calendar-month').innerText = monthName[month];
    document.getElementById('calendar-year').innerText = year;

    const daysContainer = document.getElementById('calendar-days');

    // NAMA HARI
    dayName.forEach(d => {
        let cell = document.createElement("div");
        cell.classList.add("calendar-dayname");
        cell.innerText = d;
        daysContainer.appendChild(cell);
    });

    // HITUNG TANGGAL
    let firstDay = new Date(year, month, 1).getDay();
    if (firstDay === 0) firstDay = 7;

    let lastDate = new Date(year, month + 1, 0).getDate();

    for (let i = 1; i < firstDay; i++) {
        daysContainer.appendChild(document.createElement("div"));
    }

    for (let d = 1; d <= lastDate; d++) {
        let day = document.createElement("div");
        day.innerText = d;

        if (d === now.getDate()) {
            day.classList.add("calendar-today");
        }

        daysContainer.appendChild(day);
    }
});
</script>

<?php
$content = ob_get_clean();
include "../layouts/dashboard_layout.php";
