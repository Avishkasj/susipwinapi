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

        $sql2 = "SELECT * FROM payments WHERE cid = ? AND suid = ? AND month = MONTH(CURDATE())";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("ii", $courseId, $uname);
        $stmt2->execute();
        $result = $stmt2->get_result();// Fetch the result set

       
        if ($result->num_rows > 0) {
        // The result set is not empty
        $check = "use";
        echo json_encode($check);
        } else {
            $sql = "INSERT INTO payments (cid, suid, month, createdAt, updatedAt)
         VALUES (?, ?, MONTH(CURDATE()), NOW(), NOW())";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $courseId, $uname);
            $stmt->execute();

        // The result set is empty
        if ($stmt->affected_rows > 0) {


 // sms api call

 $api_url = 'http://sender.zirconhost.com/api/v2/send.php';
 $user_id = 105082;
 $api_key = 'xv8np326kfaw3uqjt';
 $sender_id = 'Encode99';
 $to = '0762697156';
 $message = 'hello';

 // Create the query string with the parameters
 $query_string = http_build_query([
     'user_id' => $user_id,
     'api_key' => $api_key,
     'sender_id' => $sender_id,
     'to' => $to,
     'message' => $message,
 ]);

 // Construct the full URL with the query string
 $request_url = $api_url . '?' . $query_string;

 // Send the GET request to the API
 $response = file_get_contents($request_url);

 // Check if the request was successful
 if ($response !== false) {
     // API returned a response, you can check and process it here
     echo "SMS sent successfully!";
 } else {
     // Request failed
     echo "Failed to send SMS.";
 }




            $check = "Mark";
            header('Content-Type: application/json');
            echo json_encode($check);


            //send sms
            // $sql4 = "SELECT parentId FROM parentstudents WHERE studentid = ?";
            // $stmt = $conn->prepare($sql4);
            // $stmt->bind_param("s", $uname);
            // $stmt->execute();
            // $result = $stmt->get_result();

            // if ($result->num_rows > 0) {
            //     $row = $result->fetch_assoc();
            //     $parent = $row['parentId'];

            //     $sql5 = "SELECT tel FROM users WHERE id = ?";
            //     $stmt2 = $conn->prepare($sql5);
            //     $stmt2->bind_param("ii", $parent);
            //     $stmt2->execute();
            //     $result = $stmt2->get_result();

            //     if ($result->num_rows > 0) {
            //         $row = $result->fetch_assoc();
            //         $tel = $row['tel'];
            //     }
            // }

            
        } else {
            $check = "Not Mark";
            echo json_encode($check);
        }
        }


}
}

// Close the prepared statement and database connection
$stmt->close();
$conn->close();
?>


