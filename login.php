<?php


$servername = "encode99.org.lk";
$username = "encodeor";
$password = "CoY738RWk-+7pl";
$database = "encodeor_tuition";


$conn = new mysqli($servername, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$email = $_POST['email'];
$password = $_POST['password'];

if(empty($email)){
  $response = array("success" => false, "message" => "Please enter your email.");
}


$sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    
    $row = $result->fetch_assoc();
    $username = $row['username'];
    $response = array("success" => true, "message" => "Login successful!", "username" => $username);
} else {
    
    $response = array("success" => false, "message" => "Invalid email or password.");
}

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
//  hello

?>
