<?php
$api_try = $_POST['api_key'];
$date = $_POST['date'];
$temp = $_POST['temp'];
$dateAdded = $_POST['dateAdded'];

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
//Check for same result
  $sqlcheck = sprintf("SELECT date From yr ORDER BY id DESC LIMIT 1");
  $dataset = mysqli_query($conn,$sqlcheck);

while ($row = mysqli_fetch_array($dataset)){
  //echo $row[0];
  //echo $date;
  if($row[0] == $date){
    $sql = sprintf("UPDATE yr SET temp = ".$temp.", date_added = '".$dateAdded."' WHERE date = '".$date."'");
    if ($conn->query($sql) === TRUE) {
        echo "Updated forecast for " . $date . " at " . $dateAdded . " with " . $temp;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
  } 
  else {
    //all good? blast result into DB
    $sql = sprintf("INSERT INTO yr(date, temp, date_added)
    VALUES('" . $date . "', '" . $temp . "', '" . $dateAdded . "')");

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    //Booom
  }
}






  $conn->close();
} else{
  echo "Wrong API key";
}
