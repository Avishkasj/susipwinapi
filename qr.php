<?php
// Retrieve the QR code value passed from the previous page
$qr_code_value = $_GET['qr_code'];

// Process the QR code value (example code)
if ($qr_code_value == null) {
  echo 'QR code value is null';
} else {
  echo 'QR code value is notnull';
}
?>
