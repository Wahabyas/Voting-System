<?php

require '../model/class_model.php';

// Start the session for error handling or redirect messages
session_start();

// Get POST data from the login form
$username = $_POST['username'];
$password = $_POST['password'];

// Create an instance of the class_model
$model = new class_model();

// Call the login method
$result = $model->login($username, $password, 'Active');

// Check if the result is an array and contains the 'count' key
if (isset($result['count']) && $result['count'] > 0) {
    // Successful login, redirect to the dashboard
    echo json_encode(array(
        'status' => 'success',
        'redirect' => 'indexbase.php'
    ));
	
	$_SESSION['user_ids'] = $result['user_id'];
 
} else {
    // Failed login, return an error message
    echo json_encode(array(
        'status' => 'error',
        'message' => isset($result['message']) ? $result['message'] : 'An unexpected error occurred.'
    ));
}

