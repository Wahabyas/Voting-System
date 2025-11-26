<?php
  // Include necessary files (ensure the paths are correct)
  require_once "../model/class_model.php";
  require_once "../model/config/connection2.php";

  // Database connection using mysqli


  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  // Get JSON input data from AJAX
  $data = json_decode(file_get_contents('php://input'), true);

  if (isset($data['vouchers']) && is_array($data['vouchers'])) {
      // Prepare SQL query to insert vouchers into the database
      $sql = "INSERT INTO Voter_Vouchers (Voucher_code,`year`, Voucher_expiry, Date_generated) VALUES (?, ?, ?,?)";

      // Prepare the statement
      if ($stmt = $conn->prepare($sql)) {
          // Set the parameters for each insert
          foreach ($data['vouchers'] as $voucher) {
              $voucherCode = $voucher['voucherCode'];
              $Activeyear = $voucher['Activeyear'];

              $voucherExpiry = date('Y-m-d', strtotime('+30 days'));  // Set expiry date 30 days from now
              $dateGenerated = date('Y-m-d H:i:s');  // current timestamp

              // Bind the parameters and execute the statement
              $stmt->bind_param('ssss', $voucherCode,$Activeyear, $voucherExpiry, $dateGenerated);
              $stmt->execute();
          }

          // Return success response
          echo json_encode(['status' => 'success', 'message' => 'Vouchers inserted successfully.']);
      } else {
          // Error preparing the statement
          echo json_encode(['status' => 'error', 'message' => 'Failed to prepare the SQL query.']);
      }
  } else {
      // If no vouchers are received
      echo json_encode(['status' => 'error', 'message' => 'No vouchers data received.']);
  }

  // Close the connection
  $conn->close();
?>
