<?php
require_once 'User.php';
session_start();
$servername = "encode99.org.lk";
$username = "encodeor";
$password = "CoY738RWk-+7pl";
$database = "encodeor_tuition";

// $user = new User();
// $uid = $user->getUserId();

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

    $sql2 = "SELECT id FROM courses WHERE coursename = ?";
    $stmt = $conn->prepare($sql2);
    $stmt->bind_param("s", $selectedOption);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $courseId = $row['id'];

        $sql = "INSERT INTO attendances (auserid, acourseid, aday, atime, createdAt, updatedAt)
                VALUES (?, ?, CURDATE(), '09:00:00', NOW(), NOW())";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $uname, $courseId);
        $stmt->execute();

        $sql2 = "SELECT * FROM attendances WHERE auserid = ? AND acourseid = ? AND aday = CURDATE()";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("ii", $uname, $courseId);
        $stmt2->execute();

        if ($stmt2->affected_rows > 0) {
            $check = "use";
            echo json_encode($check);
        } else {
            if ($stmt->affected_rows > 0) {
                $check = "Mark";
                header('Content-Type: application/json');
                echo json_encode($check);
            } else {
                $check = "Not Mark";
                echo json_encode($check);
            }
        }
    }else{
       
    } 

       
}

// Close the prepared statement and database connection
$stmt->close();
$conn->close();
?>


