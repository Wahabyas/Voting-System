<?php
// Include your database connection file (adjust the path as needed)
require_once "../model/class_model.php";
require_once "../model/config/connection2.php";





if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the input data from the AJAX request
    $sender_id = $_POST['sender_id'];
    $receiver_id = $_POST['receiver_id'];

    // Validate input data
    if (empty($sender_id) || empty($receiver_id)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
        exit;
    }

    // Prepare the SQL query to fetch messages between the sender and receiver
    $query = "SELECT * FROM messages 
              WHERE (sender_id = ? AND receiver_id = ?) 
              OR (sender_id = ? AND receiver_id = ?) 
              ORDER BY created_at ASC"; // Sort by the message timestamp

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("iiii", $sender_id, $receiver_id, $receiver_id, $sender_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if any messages are found
        if ($result->num_rows > 0) {
            $messages = [];
            while ($row = $result->fetch_assoc()) {
                $messages[] = [
                    'sender_id' => $row['sender_id'],
                    'message_text' => $row['message_text'],
                    'timestamp' => date('h:i A', strtotime($row['created_at'])), // Format timestamp as desired
                ];
            }

            // Return success response with messages
            echo json_encode([
                'status' => 'success',
                'messages' => $messages
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No messages found']);
        }

        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database query failed']);
    }
}
?>


