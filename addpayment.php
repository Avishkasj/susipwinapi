<?php
require_once 'User.php';
session_start();

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

if (isset($_POST['data']) && isset($_POST['name'])) {
    $selectedOption = $_POST['data'];
    $uname = $_POST['name'];
    $currentDate = date('Y-m-d');

    // Retrieve the course ID from the 'courses' table
    $sql1 = "SELECT id FROM courses WHERE coursename = ?";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->bind_param("s", $selectedOption);
    $stmt1->execute();
    $result1 = $stmt1->get_result();

    if ($result1->num_rows > 0) {
        $row = $result1->fetch_assoc();
        $courseId = $row['id'];

        // Check if the attendance record already exists for the user and course on the current date
        $sql2 = "SELECT * FROM payments WHERE suid = ? AND cid = ? AND month = CURDATE()";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("ii", $uname, $courseId);
        $stmt2->execute();
        $result2 = $stmt2->get_result();

        if ($result2->num_rows > 0) {
            // The attendance record exists
            $check = "use";
            echo json_encode($check);
        } else {
            // Insert a new attendance record into the 'payments' table
            $sql3 = "INSERT INTO payments (suid, aid, month,  createdAt, updatedAt) VALUES (?, ?, CURDATE(), NOW(), NOW())";
            $stmt3 = $conn->prepare($sql3);
            $stmt3->bind_param("ii", $uname, $courseId);
            $stmt3->execute();

            if ($stmt3->affected_rows > 0) {
                // The attendance record was inserted successfully
                $check = "Mark";
                header('Content-Type: application/json');
                echo json_encode($check);
            } else {
                // Failed to insert the attendance record
                $check = "Not Mark";
                echo json_encode($check);
            }
        }
    }
}

// Close the prepared statements and database connection
$stmt1->close();
$stmt2->close();
$stmt3->close();
$conn->close();
?>
