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



$sql1 = "SELECT id FROM users WHERE username='$uname'";
$sql2 = "SELECT id FROM courses WHERE courseid='$selectedOption'";

// Execute the SQL queries to fetch the results
$result1 = mysqli_query($connection, $sql1);
$result2 = mysqli_query($connection, $sql2);

// Check if the queries executed successfully
if ($result1 && $result2) {
  // Fetch the results from the first query
  $row1 = mysqli_fetch_assoc($result1);
  $userId = $row1['id'];

  // Fetch the results from the second query
  $row2 = mysqli_fetch_assoc($result2);
  $courseId = $row2['id'];

  // Get the current day and time
  $currentDay = date("l");
  $current_time = date("H:i:s");

  // Create the SQL insert statement
  $sql3 = "INSERT INTO attendances (auserid, acourseid, aday, atime, astatus)
           VALUES ('$userId', '$courseId', '$currentDay', '$current_time', '1')";

  // Execute the insert query
  if (mysqli_query($connection, $sql3)) {
    echo "Attendance recorded successfully.";
    $check="successfully";
    header('Content-Type: application/json');
        echo json_encode($check);
  } else {
    echo "Error: " . mysqli_error($connection);
    $check = "Not Pay";
        $response = array('error' => 'No data found');
        echo json_encode($check);
    
  }
} else {
  echo "Error: " . mysqli_error($connection);
  $check = "Not Pay";
        $response = array('error' => 'No data found');
        echo json_encode($check);
}


    // $currentDay = date("l");
    // $current_time = date("H:i:s");

    // $sql1="SELECT id from users WHERE username='$uname'";
    // $sql2="SELECT id from courses WHERE courseid='$selectedOption'";
    // $sql3="INSERT INTO attendances (auserid,acourseid,aday,atime,astatus)values ($sql1,$sql2 , $currentDay,$current_time,'1'))"



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


// $sql ="SELECT p.cid, p.suid, p.month
//         FROM payments p
//         JOIN students s ON p.suid = s.id
//         JOIN courses c ON p.cid = c.id
//         WHERE s.sfullname = '$uname'
//         AND c.coursename = '$selectedOption'";


    // $sql = "SELECT * FROM courses WHERE coursename = '$selectedOption'";

    // $result = $conn->query($sql);

    // // Check if any rows were returned
    // if ($result->num_rows > 0) {
    //     $check = "Paid";
    //     // Create an array to store the data
    //     $data = array();
    
    //     // Loop through each row
    //     while ($row = $result->fetch_assoc()) {
    //         // Add the row data to the array
    //         $data[] = array(
    //             // 'id' => $row['id'],
    //             // 'coursename' => $row['coursename'],
    //             // 'description' => $row['description'],
    //             // Add any other fields you want to include here

    //             // 'cid' => $row1['cid'],
    //             // 'suid'=>$row1['suid'],
    //             // 'month'=>$row1['month'],
    //         );
    //     }
    
    //     // Send the JSON response back to the Flutter app
    //     header('Content-Type: application/json');
    //     echo json_encode($check);
    // } else {
    //     // No rows were returned
    //     $check = "Not Pay";
    //     $response = array('error' => 'No data found');
    //     echo json_encode($check);
        
    // }
}

// Close the database connection
$conn->close();
?>
