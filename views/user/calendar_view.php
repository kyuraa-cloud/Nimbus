<?php
$firstDay = mktime(0, 0, 0, $currentMonth, 1, $currentYear);
$daysInMonth = date("t", $firstDay);
$startDay = date("w", $firstDay); // 0 = Minggu
$startDay = ($startDay == 0) ? 6 : $startDay - 1; // ubah supaya minggu terakhir
?>

<?php
$prevMonth = $currentMonth - 1;
$prevYear  = $currentYear;
$nextMonth = $currentMonth + 1;
$nextYear  = $currentYear;

if ($prevMonth < 1) { $prevMonth = 12; $prevYear--; }
if ($nextMonth > 12) { $nextMonth = 1; $nextYear++; }
?>

<link rel="stylesheet" href="/nimbus/assets/css/calendar.css">

<div class="calendar-nav">
    <a href="?m=<?= $prevMonth ?>&y=<?= $prevYear ?>" class="nav-btn">←</a>
    <span class="current-month"><?= date("F Y", strtotime("$currentYear-$currentMonth-01")) ?></span>
    <a href="?m=<?= $nextMonth ?>&y=<?= $nextYear ?>" class="nav-btn">→</a>
</div>

<div class="calendar-box">

    <div class="week-header">
        <div>MON</div>
        <div>TUE</div>
        <div>WED</div>
        <div>THU</div>
        <div>FRI</div>
        <div>SAT</div>
        <div>SUN</div>
    </div>

    <div class="calendar-grid">

        <?php
        for ($i = 0; $i < $startDay; $i++) {
            echo "<div class='day empty'></div>";
        }
        for ($d = 1; $d <= $daysInMonth; $d++) {
            $date = date("Y-m-d", strtotime("$currentYear-$currentMonth-$d"));
            echo "<div class='day'>";
            echo "<span class='date-num'>$d</span>";
            foreach ($events as $e) {
                if ($date >= $e['start'] && $date <= $e['end']) {
                    echo "<div class='event-bar {$e['priority']}'>"
                            . htmlspecialchars($e['name']) .
                        "</div>";
                }
            }
            echo "</div>";
        }
        ?>
    </div>
</div>
