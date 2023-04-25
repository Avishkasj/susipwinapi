<?php

if (isset($_POST['data'])) {
  // Data has been received
  $qr_data = $_POST['data'];

  // Process the data here
  // ...

  // Return a JSON response with the QR code data
  $response = array('qr_data' => $qr_data);
  header('Content-Type: application/json');
  echo json_encode($response);
} else {
  // No data received
  echo "No data received";
}


?>

