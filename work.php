<?php


$servername = "encode99.org.lk";
$username = "encodeor";
$password = "CoY738RWk-+7pl";
$database = "encodeor_tuition";

// Create a new MySQLi instance and connect to the database
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the user's email and password from the request
$email = $_POST['email'];
$password = $_POST['password'];


if(empty($email)){
  $response = array("success" => false, "message" => "Please enter your email.");
}


// Query the database for the user's credentials
$sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
$result = $conn->query($sql);

// Check if the query returned a result
if ($result->num_rows > 0) {
    // User credentials are valid, return a success message
    $response = array("success" => true, "message" => "Login successful!");
} else {
    // User credentials are invalid, return an error message
    $response = array("success" => false, "message" => "Invalid email or password.");
}

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);

// Close the database connection
$conn->close();

?>
