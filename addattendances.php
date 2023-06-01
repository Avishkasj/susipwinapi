<?php
require_once 'User.php';
session_start();
$servername = "encode99.org.lk";
$username = "encodeor";
$password = "CoY738RWk-+7pl";
$database = "encodeor_tuition";

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

        // Get the current day and time
        $currentDay = date("l");
        $current_time = date("H:i:s");

        // Create the SQL insert statement
        $sql2 = "INSERT INTO attendances (auserid, acourseid, aday, atime, astatus)
                 VALUES (?, ?, ?, ?, '1')";

        // Prepare the insert statement
        $stmt2 = $conn->prepare($sql2);

        // Bind parameters and execute the insert query
        $stmt2->bind_param("iiss", $suid, $cid, $currentDay, $current_time);
        if ($stmt2->execute()) {
            echo "Attendance recorded successfully.";
            $response = array('success' => 'Attendance recorded successfully.');
            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            echo "Error: " . $stmt2->error;
            $response = array('error' => 'Failed to record attendance.');
            header('Content-Type: application/json');
            echo json_encode($response);
        }

        // Close the prepared statement
        $stmt2->close();
    } else {
        echo "Error: " . $conn->error;
        $response = array('error' => 'No data found');
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>

