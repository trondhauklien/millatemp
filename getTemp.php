<?php

require_once "config.php";
//
// //echo "Success!";
$sqlNow = sprintf("SELECT * FROM Data order by Id desc limit 1");
$sqlLow = sprintf("SELECT Temp FROM (SELECT * FROM `Data` order by Id DESC LIMIT 96) As dataa ORDER BY Temp LIMIT 1");
$sqlHigh = sprintf("SELECT Temp FROM (SELECT * FROM `Data` order by Id DESC LIMIT 96) As dataa ORDER BY Temp desc LIMIT 1");

$datasettNow = mysqli_query($conn,$sqlNow);
$datasettLow = mysqli_query($conn,$sqlLow);
$datasettHigh = mysqli_query($conn,$sqlHigh);

while ($row3 = mysqli_fetch_array($datasettNow)){
  $now = $row3["Temp"];
  $nowTime = $row3["Date"];
  $nowId = $row3["Id"];
}
while ($row4 = mysqli_fetch_array($datasettLow)){
  $low = $row4["Temp"];
}
while ($row5 = mysqli_fetch_array($datasettHigh)){
  $high = $row5["Temp"];
}

echo json_encode(array($now, $low, $high, $nowTime, $nowId));
?>
