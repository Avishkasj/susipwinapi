<?php
session_start(); 
require_once 'User.php';

$servername = "encode99.org.lk";
$username = "encodeor";
$password = "CoY738RWk-+7pl";
$database = "encodeor_tuition";


$conn = new mysqli($servername, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if(isset($_POST['data'])) {
    $json_data = $_POST['data'];


    $data = json_decode($json_data, true);
   
    $user_id = $data['userid'];
    $user = new User();
    $user->setUserId($user_id);

    $_SESSION['user_id'] = $user_id;
    // $course_id = $data['courses'];
    // $id = $data['id'];
    
    // Process the data here
    // ...
    
   

    // registerd course 
    $sql2 = "SELECT t1.coursename
    FROM courses t1
    INNER JOIN coursestudents t2 ON t1.id = t2.courseId AND t2.aprovel='1'
    WHERE t2.userId = '$user_id'";


    $result2 = $conn->query($sql2);

    $data2 = array();
        if ($result2->num_rows > 0) {
            while($row = $result2->fetch_assoc()) {
                $data2[] = $row;
            }
        }

    
    session_write_close();


    header('Content-Type: application/json');
    echo json_encode($data2);

} else {
    // No data received
    $response = array('error' => 'No data received');
    echo json_encode($response);
}

// Close the database connection
$conn->close();

?>
