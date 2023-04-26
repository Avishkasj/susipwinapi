<?php

$servername = "encode99.com.lk";
$username = "encodeco_lms";
$password = "%Lms%1234@Susipwin";
$database = "encodeco_lms";

// Create a new MySQLi instance and connect to the database
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the data sent from the mobile app
if(isset($_POST['data'])) {
    $json_data = $_POST['data'];

    // Decode the JSON data into a PHP associative array
    $data = json_decode($json_data, true);
    
    // Assign each value to a separate variable
    $user_id = $data['userid'];
    // $course_id = $data['courses'];
    // $id = $data['id'];
    
    // Process the data here
    // ...
    
    // Send a response back to the mobile app
    $response = array('message' => 'Data received: ' . $json_data);
    echo json_encode($response);
} else {
    // No data received
    $response = array('error' => 'No data received');
    echo json_encode($response);
}

$sql = "SELECT sfullname FROM students WHERE id='$user_id";
$result = $conn->query($sql);

// Convert the data to a JSON array
$data = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Send the JSON response back to the Flutter app
header('Content-Type: application/json');
echo json_encode($data);

// Close the database connection
$conn->close();

?>
