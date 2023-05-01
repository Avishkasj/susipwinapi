<?php
session_start();
$servername = "encode99.com.lk";
$username = "encodeco_lms";
$password = "%Lms%1234@Susipwin";
$database = "encodeco_lms";

// Retrieve the user ID from the session data
$uid = $_SESSION['user_id'];

// Create a new MySQLi instance and connect to the database
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the data sent from the mobile app
if(isset($_POST['data'])) {
    $selectedOption = $_POST['data'];

    // Process the data here
    // ...
    //stable version

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
        // Fetch the row as an associative array
        $row = $result->fetch_assoc();

        // Create an array containing the relevant data
        $data3 = array(
            'id' => $row['id'],
            'coursename' => $row['cid'],
            'description' => $row['suid'],
            // Add any other fields you want to include here
        );

        // Send the JSON response back to the Flutter app
        header('Content-Type: application/json');
        echo json_encode($data3);
    } else {
        // No rows were returned
        $response = array('error' => 'No data found');
        echo json_encode($response);
    }
} else {
    // No data received
    $response = array('error' => 'No data received');
    echo json_encode($response);
}

// Close the database connection
$conn->close();

?>
