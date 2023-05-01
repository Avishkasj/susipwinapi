<?php
session_start();
$user_id = $_SESSION['user_id'];

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

    // Assign the value to a variable
    $selectedOption = $data['selectedOption'];

    // Process the data here
    // ...

    // Fetch the data from the database
    $sql = "SELECT * FROM courses WHERE coursename = '$selectedOption'";
    $result = $conn->query($sql);

    // Check if any rows were returned
    if ($result->num_rows > 0) {
        // Fetch the row as an associative array
        $row = $result->fetch_assoc();

        // Create an array containing the relevant data
        $data3 = array(
            'id' => $row['id'],
            'coursename' => $row['coursename'],
            'description' => $row['description'],
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
