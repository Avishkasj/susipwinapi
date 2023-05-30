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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $requestData = json_decode(file_get_contents('php://input'), true);

    if (isset($requestData['name'])) {
        $uname = $requestData['name'];

        $sql1 = "SELECT id FROM students WHERE sfullname = '$uname'";

        // Fetch the data from the database
        $result1 = $conn->query($sql1);

        if ($result1->num_rows > 0) {
            $data = array();

            while ($row1 = $result1->fetch_assoc()) {
                $data[] = array(
                    'id' => $row1['id'],
                );
            }

            header('Content-Type: application/json');
            echo json_encode($data);
        } else {
            $response = array('error' => 'No data found');
            http_response_code(404);
            echo json_encode($response);
        }
    } else {
        $response = array('error' => 'Missing required parameter');
        http_response_code(400);
        echo json_encode($response);
    }
}

// Close the database connection
$conn->close();
?>
