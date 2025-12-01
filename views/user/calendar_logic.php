<?php
$currentMonth = isset($_GET['m']) ? intval($_GET['m']) : intval(date("m"));
$currentYear  = isset($_GET['y']) ? intval($_GET['y']) : intval(date("Y"));

if ($currentMonth < 1) {
    $currentMonth = 12;
    $currentYear--;
}
if ($currentMonth > 12) {
    $currentMonth = 1;
    $currentYear++;
}

$q = mysqli_query($conn, "
    SELECT id, name, start_date, due_date, priority 
    FROM tasks 
    WHERE user_id = $userId
");

$events = [];

while ($row = mysqli_fetch_assoc($q)) {
    $startRaw = ($row['start_date'] == "0000-00-00" || empty($row['start_date']))
                ? $row['due_date']
                : $row['start_date'];
    $start = date("Y-m-d", strtotime(str_replace("/", "-", $startRaw)));
    $end   = date("Y-m-d", strtotime(str_replace("/", "-", $row['due_date'])));
    $events[] = [
        "name"     => $row['name'],
        "start"    => $start,
        "end"      => $end,
        "priority" => $row['priority']
    ];
}
?>
