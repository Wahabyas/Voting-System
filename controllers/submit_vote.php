<?php
require_once "../model/class_model.php";
require_once "../model/config/connection2.php";

// Assuming you've instantiated your database model class
$conn = new class_model();

// Check if 'Voucher_code' exists in the POST request
if (isset($_POST['Voucher_code']) && isset($_POST['Activeyear'])) {
    // Get the form data from the POST request
    $voter = $_POST['Voucher_code'];
    $Activeyear = $_POST['Activeyear'];
    
    // Voter code from the form
    $votes = $_POST; // All POST data (which contains the candidate votes)

    $success = true; // Flag to track success or failure

    foreach ($votes as $key => $value) {
        if (strpos($key, 'vote_') === 0) {
            // Extract the position ID from the key
            $position_id = substr($key, 5); // Remove "vote_" from the key to get the position ID

            // Insert the vote for this position and candidate
            $candidate_id = $value; // The selected candidate ID
            
            if (!$conn->submit_vote($voter, $candidate_id, $Activeyear)) {
                $success = false;
                error_log("Failed to insert vote for voter: $voter, position_id: $position_id, candidate_id: $candidate_id");
                break; // Exit the loop on failure
            }
        }
    }

    if ($success) {
        echo "1";
    } else {
        echo "y";

    }
} else {
    echo "Voucher code is missing.";
    error_log("Voucher code is missing in the POST request.");
}

?>
