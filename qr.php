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

// Set the default timezone to avoid any warning
date_default_timezone_set('Asia/Colombo');

// Retrieve the data sent from the mobile app
if(isset($_POST['data'])) {
    $json_data = $_POST['data'];

    // Decode the JSON data into a PHP associative array
    $data = json_decode($json_data, true);
    
    // Assign each value to a separate variable
    $user_id = $data['userid'];
    
    // Prepare the SQL statement to retrieve the student's name
    $stmt = $conn->prepare("SELECT sfullname FROM students WHERE userId = ?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    
    // Get the result of the SQL query
    $result = $stmt->get_result();
    
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
    
    // Close the prepared statement
    $stmt->close();
} else {
    // No data received
    $response = array('error' => 'No data received');
    echo json_encode($response);
}

// Close the database connection
$conn->close();

?>

