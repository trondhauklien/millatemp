<?php
require_once "config.php";

$quote = $_POST['quote'];
date_default_timezone_set("Europe/Oslo");
$date = date("Y-m-d H:i:s");

$sql = sprintf("INSERT INTO Quotes(Sitat, Dato, Aktiv)
VALUES('" . $quote . "', '" . $date . "', 0)");

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
