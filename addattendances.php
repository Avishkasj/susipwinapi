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
if(isset($_POST['data'])&&isset($_POST['name'])) {
    $selectedOption = $_POST['data'];
    $uname = $_POST['name'];



    $sql = "SELECT p.cid, p.suid, p.month
    FROM payments p
    JOIN students s ON p.suid = s.id
    JOIN courses c ON p.cid = c.id
    WHERE s.sfullname = ?
    AND c.coursename = ?";

// Prepare the SQL statement
$stmt = $conn->prepare($sql);

// Bind parameters and execute the query
$stmt->bind_param("ss", $uname, $selectedOption);
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Check if the query executed successfully
if ($result) {
// Fetch the result row
$row = $result->fetch_assoc();
$cid = $row['cid'];
$suid = $row['suid'];
$month = $row['month'];

// Process the result as needed
// ...

echo "Query executed successfully.";
$response = array('success' => 'Query executed successfully.');
header('Content-Type: application/json');
echo json_encode($response);
} else {
echo "Error: " . $conn->error;
$response = array('error' => 'No data found');
header('Content-Type: application/json');
echo json_encode($response);
}

// Close the prepared statement
$stmt->close();
}
?>
