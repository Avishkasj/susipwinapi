<?php
$servername = "encode99.com.lk";
$username = "encodeco_lms";
$password = "%Dilum%1234Test";
$database = "encodeco_lms";

// Create connection
$conn= new mysqli($servername, $username, $password,$database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>

