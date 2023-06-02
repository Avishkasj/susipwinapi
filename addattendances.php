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

if(isset($_POST['data'])&&isset($_POST['name'])) {
    $selectedOption = $_POST['data'];
    $uname = $_POST['name'];

    $sql2 ="SELECT id FROM courses WHERE coursename = $selectedOption";


    // $sql = "SELECT * FROM courses WHERE coursename = '$selectedOption'";

    $result = $conn->query($sql2);

   

$sql = "INSERT INTO attendances (auserid, acourseid, aday, atime, createdAt, updatedAt)
VALUES ($uname, $result, '2023-06-02', '09:00:00', NOW(), NOW());
";
$result = mysqli_query($conn, $sql);


    if ($result) {
        echo "Data inserted successfully into the attendances table.";
        $check = "Mark";
        header('Content-Type: application/json');
        echo json_encode($check);
      }
      else{
        $check = "Not Mark";
        $response = array('error' => 'No data found');
        echo json_encode($check);
      }



}
// Close the database connection
$conn->close();
?>

