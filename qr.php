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
if(isset($_POST['data']) && isset($_POST['uid'])) {
    $selectedOption = $_POST['data'];
    $uid = $_POST['uid'];

    // Process the data here
    // ...

    // Prepare and execute the SQL query to retrieve user data
    $stmt = $conn->prepare("SELECT * FROM students WHERE userId = ?");
    $stmt->bind_param("s", $uid);
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Convert the result into an associative array
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    // Prepare and execute the SQL query to retrieve registered course names
    $stmt2 = $conn->prepare("SELECT coursename FROM courses WHERE courseid = ?");
    $stmt2->bind_param("s", $selectedOption);
    $stmt2->execute();

    // Get the result
    $result2 = $stmt2->get_result();

    // Convert the result into an associative array
    $data2 = array();
    while ($row = $result2->fetch_assoc()) {
        $data2[] = $row;
    }

    // Combine the data into a single array
    $response = array(
        'data' => $data,
        'data2' => $data2
    );

    // Send the JSON response back to the Flutter app
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // No data received
    $response = array('error' => 'No data received');
    echo json_encode($response);
}

// Close the database connection
$conn->close();

?>
