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
if(isset($_POST['data'])&&isset($_POST['name'])) {
    $selectedOption = $_POST['data'];
    $uname = $_POST['name'];

    // $sql1="SELECT id from students WHERE sfullname='$uname'";
    // $sql2="SELECT id from courses WHERE courseid='$selectedOption'";
    // $sql3="SELECT cid,suid,month FROM payments WHERE suid='$'"



    // Process the data here
    // ...
    //stable version

    // $sql2 = "SELECT id FROM students WHERE userId = '$user_id' ";
    // $sql3 = "SELECT id FROM courses WHERE coursename = '$selectedOption'";
    // $sql4 = "SELECT * FROM payments WHERE cid = '$sql3' AND suid='$sql2' AND month='5'";


    // $sql = "SELECT p.* 
    // FROM payments p 
    // INNER JOIN students s ON p.suid = s.id 
    // INNER JOIN courses c ON p.cid = c.id 
    // WHERE s.userId = '$uid' 
    // AND c.coursename = '$selectedOption'
    // AND p.month = '5';
    // ";



// $sql = " SELECT * FROM courses WHERE coursename = '$selectedOption' ";


$sql ="SELECT p.cid, p.suid, p.month
        FROM payments p
        JOIN users u ON p.suid = u.id
        JOIN courses c ON p.cid = c.id
        WHERE u.id = '$uname'
        AND c.coursename = '$selectedOption'";


    // $sql = "SELECT * FROM courses WHERE coursename = '$selectedOption'";

    $result = $conn->query($sql);

    // Check if any rows were returned
    if ($result->num_rows > 0) {
        $check = "Paid";
        // Create an array to store the data
        $data = array();
    
        // Loop through each row
        while ($row = $result->fetch_assoc()) {
            // Add the row data to the array
            $data[] = array(
                // 'id' => $row['id'],
                // 'coursename' => $row['coursename'],
                // 'description' => $row['description'],
                // Add any other fields you want to include here

                // 'cid' => $row1['cid'],
                // 'suid'=>$row1['suid'],
                // 'month'=>$row1['month'],
            );
        }
    
        // Send the JSON response back to the Flutter app
        header('Content-Type: application/json');
        echo json_encode($check);
    } else {
        // No rows were returned
        $check = "Not Pay";
        $response = array('error' => 'No data found');
        echo json_encode($check);
        
    }
}

// Close the database connection
$conn->close();
?>

