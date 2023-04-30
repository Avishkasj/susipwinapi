<?php

$servername = "encode99.com.lk";
$username = "encodeco_lms";
$password = "%Lms%1234@Susipwin";
$database = "encodeco_lms";

// Create a new MySQLi instance and connect to the database
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the data sent from the mobile app
if(isset($_POST['data'])) {
    $json_data = $_POST['data'];

    // Decode the JSON data into a PHP associative array
    $data = json_decode($json_data, true);
    
    // Assign each value to a separate variable
    $user_id = $data['userid'];
    // $course_id = $data['courses'];
    // $id = $data['id'];
    
    // Process the data here
    // ...
    
   

    // registerd course 
    $sql2 = "SELECT t1.coursename
    FROM courses t1
    INNER JOIN coursestudents t2 ON t1.id = t2.courseId
    
    ";

    //  $sql2="SELECT coursename FROM courses";

    $result2 = $conn->query($sql2);

    $data2 = array();
        if ($result2->num_rows > 0) {
            while($row = $result2->fetch_assoc()) {
                $data2[] = $row;
            }
        }


      //   $data1 = array(
      //     'data' => $data,
      //     'data2' => $data2
      //  );

    // Send the JSON response back to the Flutter app
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
