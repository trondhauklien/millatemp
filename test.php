<?php
date_default_timezone_set("Europe/Oslo");
$nowdate = new DateTime();
$yesterdayDT = $nowdate->sub(new DateInterval('P2D'));
$yesterday = $yesterdayDT->format("Y-m-d H:i:s");
echo $yesterday
?>
