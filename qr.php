<?php
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
    
    // Send a response back to the mobile app
    $response = array('message' => 'Data received: ' . $json_data);
    echo json_encode($response);
} else {
    // No data received
    $response = array('error' => 'No data received');
    echo json_encode($response);
}

?>
