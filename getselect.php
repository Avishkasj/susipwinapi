<?php
session_start(); 
// Retrieve the selected_option parameter from the POST request
$selectedOption = $_POST['selected_option'] ?? '';
$_SESSION['selectedOption'] = $selectedOption;

// Do something with the selected_option value (e.g. save it to a database)
// ...

// Prepare a JSON response
$response = ['status' => 'success', 'message' => 'Received selected option: ' . $selectedOption];
$jsonResponse = json_encode($response);

// Set the content type header to application/json
header('Content-Type: application/json');

// Send the JSON response back to the Flutter app
echo $jsonResponse;

?>
