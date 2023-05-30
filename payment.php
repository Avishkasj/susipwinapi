<?php
require_once 'User.php';
session_start();
$servername = "encode99.com.lk";
$username = "encodeco_lms";
$password = "%Lms%1234@Susipwin";
$database = "encodeco_lms";

$user = new User();
$uid = $user->getUserId();

// Create a new MySQLi instance and connect to the database
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the data sent from the mobile app
if (isset($_POST['data']) && isset($_POST['name'])) {
    $selectedOption = $_POST['data'];
    $name = $_POST['name'];

    // Process the data here
    // ...

    $sql = "SELECT p.* 
    FROM payments p 
    INNER JOIN students s ON p.suid = s.id 
    INNER JOIN courses c ON p.cid = c.id 
    WHERE s.userId = '$uid' 
    AND c.coursename = '$selectedOption'
    AND p.month = '5';
    ";

    // Fetch the data from the database
    $result = $conn->query($sql);

    // Check if any rows were returned
    if ($result->num_rows > 0) {
        // Fetch the first row of data
        $row = $result->fetch_assoc();

        // Send the JSON response back to the Flutter app
        $data = array(
            'id' => $row['id'],
            'coursename' => $row['coursename'],
            'description' => $row['description'],
            // Add any other fields you want to include here
        );

        header('Content-Type: application/json');
        echo json_encode($data);
    } else {
        // No rows were returned
        $response = array('error' => 'No data found');
        echo json_encode($response);
    }
}

// Close the database connection
$conn->close();
?>
