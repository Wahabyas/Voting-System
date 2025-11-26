<?php
// Include your database connection file (adjust the path as needed)
require_once "../model/class_model.php";
require_once "../model/config/connection2.php";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the input data from the AJAX request
    $sender_id = $_POST['sender_id'];
    $receiver_id = $_POST['receiver_id'];
    $message_text = $_POST['message_text'];

    // Check if the input fields are valid
    if (empty($sender_id) || empty($receiver_id) || empty($message_text)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
        exit;
    }

    // Prepare the SQL query to insert the message
    $query = "INSERT INTO messages (sender_id, receiver_id, message_text, message_status) 
              VALUES (?, ?, ?, 'sent')"; // Default status is 'sent'
    
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("iis", $sender_id, $receiver_id, $message_text);

        if ($stmt->execute()) {
            // Message inserted successfully, return success response
            echo json_encode([
                'status' => 'success',
                'timestamp' => date('h:i A') // Return the current timestamp for display
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to send message']);
        }
        
        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database query failed']);
    }
}
?>
