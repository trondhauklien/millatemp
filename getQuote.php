<?php

require_once "config.php";

//echo "Success!";

$sql = sprintf('SELECT Sitat FROM Quotes WHERE Aktiv=1 ORDER BY RAND() limit 1');
$result = mysqli_query($conn,$sql);

//echo "Got no result!";

while ($row = mysqli_fetch_array($result)) {
  echo $row[0];
}

?>
