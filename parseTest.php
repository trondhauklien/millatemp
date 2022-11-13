<?php
$api_try = $_POST['api_key'];
$date = $_POST['date'];
$temp = $_POST['temp'];
$hum = $_POST['hum'];

$api_key = "2415d202-d4d7-46dd-9903-a67e867aeac6";

$servername = "db";
$username = "root";
$password = "Password";
$dbname = "millatemp";

if ($api_try == $api_key) {

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }



  $sql = sprintf("INSERT INTO Data(Date, Temp, Hum)
  VALUES('" . $date . "', '" . $temp . "', '" . $hum . "')");

  if ($conn->query($sql) === TRUE) {
      echo "New record created successfully";
  } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
} else{
  echo "Wrong API key";
}
