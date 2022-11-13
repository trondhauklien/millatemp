<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$uri = $_SERVER['REQUEST_URI'];
$page = end(explode("/", $uri));

if($_SESSION["level"] < 1){
  $access = [
    "profile.php",
    "reset.php",
    "profile.php?e=access"
  ];
  if(!in_array($page, $access)){
    //header("location: welcome.php");
    header("Location: profile.php?e=access");
    exit;
  }
}
?>
