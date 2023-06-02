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

// Retrieve the data sent from the mobile app
// if(isset($_POST['data'])&&isset($_POST['name'])) {
//     $selectedOption = $_POST['data'];
//     $uid = $_POST['name'];



// $sql = "SELECT * FROM courses WHERE coursename = $selectedOption";
// $result = mysqli_query($connection, $sql);


// if ($result) {
//     $user = mysqli_fetch_assoc($result);
  
//     // Extracting the relevant data from the retrieved user
//     $cId = $user['id'];
    
  
//     // Inserting the data into the attendances table
//     $insertSql = "INSERT INTO attendances (id, auserid, acourseid, aday, atime, createdAt, updatedAt) 
//                   VALUES (1, $uid, $cId, CURDATE(), CURTIME(), NOW(), NOW())";
  
//     $insertResult = mysqli_query($connection, $insertSql);
    
//         // Send the JSON response back to the Flutter app
//         header('Content-Type: application/json');
//         echo json_encode($check);
//     } else {
//         // No rows were returned
//         $check = "Not Pay";
//         $response = array('error' => 'No data found');
//         echo json_encode($check);
        
//     }
// }

// Close the database connection
$conn->close();
?>

