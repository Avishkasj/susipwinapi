<?php
require_once 'User.php';
session_start();
$servername = "encode99.org.lk";
$username = "encodeor";
$password = "CoY738RWk-+7pl";
$database = "encodeor_tuition";
$user = new User();
$uid = $user->getUserId();


$conn = new mysqli($servername, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // $requestData = json_decode(file_get_contents('php://input'), true);

    if (isset($requestData['name'])) {
        $uname = $requestData['name'];
        $coursename=$requestData['coursename'];

        $sql1 ="SELECT p.cid, p.suid, p.month
        FROM payments p
        JOIN students s ON p.suid = s.id
        JOIN courses c ON p.cid = c.id
        WHERE s.sfullname = '$uname'
        AND c.coursename = '$coursename'";

        // Fetch the data from the database
        $result1 = $conn->query($sql1);

        if ($result1->num_rows > 0) {
            $data = array();

            while ($row1 = $result1->fetch_assoc()) {
                
                $data[] = array(
                    'cid' => $row1['cid'],
                    'suid'=>$row1['suid'],
                    'month'=>$row1['month']
                );
            }


            echo json_encode($data);
        } else {
            $response = array('error' => 'No data found');
            http_response_code(404);
            echo json_encode($response);
        }
    } else {
        $response = array('error' => 'Missing required parameter');
        http_response_code(400);
        echo json_encode($response);
    }
}

// Close the database connection
$conn->close();
?>
