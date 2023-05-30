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
if(isset($_POST['data']) && isset($_POST['name'])) {
    $selectedOption = $_POST['data'];
    $uname = $_POST['name'];

    $sql1 = "SELECT id FROM users WHERE username=?";
    $sql2 = "SELECT id FROM courses WHERE courseid=?";

    // Prepare the SQL statements
    $stmt1 = $conn->prepare($sql1);
    $stmt2 = $conn->prepare($sql2);

    // Check if the SQL statements prepared successfully
    if ($stmt1 && $stmt2) {
        // Bind parameters and execute the queries
        $stmt1->bind_param("s", $uname);
        $stmt2->bind_param("s", $selectedOption);
        $stmt1->execute();
        $stmt2->execute();

        // Get the results
        $result1 = $stmt1->get_result();
        $result2 = $stmt2->get_result();

        // Check if the queries executed successfully
        if ($result1 && $result2) {
            // Fetch the results from the first query
            $row1 = $result1->fetch_assoc();
            $userId = $row1['id'];

            // Fetch the results from the second query
            $row2 = $result2->fetch_assoc();
            $courseId = $row2['id'];

            // Get the current day and time
            $currentDay = date("l");
            $current_time = date("H:i:s");

            // Create the SQL insert statement
            $sql3 = "INSERT INTO attendances (auserid, acourseid, aday, atime, astatus) VALUES (?, ?, ?, ?, '1')";

            // Prepare the insert statement
            $stmt3 = $conn->prepare($sql3);

            // Check if the insert statement prepared successfully
            if ($stmt3) {
                // Bind parameters and execute the insert query
                $stmt3->bind_param("iiss", $userId, $courseId, $currentDay, $current_time);
                if ($stmt3->execute()) {
                    echo "Attendance recorded successfully.";
                    $response = array('success' => 'Attendance recorded successfully.');
                    header('Content-Type: application/json');
                    echo json_encode($response);
                } else {
                    echo "Error: " . $stmt3->error;
                    $response = array('error' => 'Failed to record attendance.');
                    header('Content-Type: application/json');
                    echo json_encode($response);
                }
            } else {
                echo "Error: " . $conn->error;
                $response = array('error' => 'Failed to prepare attendance insert statement.');
                header('Content-Type: application/json');
                echo json_encode($response);
            }
        } else {
            echo "Error: " . $conn->error;
            $response = array('error' => 'No data found');
            header('Content-Type: application/json');
            echo json_encode($response);
        }
    } else {
        echo "Error: " . $conn->error;
        $response = array('error' => 'Failed to prepare SQL statements.');
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    // Close the prepared statements
    $stmt1->close();
    $stmt2->close();
    $stmt3->close();
} else {
    $response = array('error' => 'Invalid data sent from the mobile app.');
    header('Content-Type: application/json');
    echo json_encode($response);
}

// Close the database connection
$conn->close();
?>
