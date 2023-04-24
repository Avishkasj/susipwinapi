<?php

if (isset($_POST['data'])) {
  // Data has been received
  $qr_data = $_POST['data'];
  
  // Process the data here
  // ...
  
  // Return a response if necessary
  echo "Data received: " . $qr_data;
} else {
  // No data received
  echo "No data received";
}

?>
