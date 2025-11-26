<?php
require '../model/class_model.php';
session_start();
$username = $_POST['username'];
$model = new class_model();
$result = $model->loginvoucher($username);
if (isset($result['count']) && $result['count'] > 0) {
    echo json_encode(array(
        'status' => 'success',
        'redirect' => 'voterdashboard.php'
    ));
	$_SESSION['user_idx'] = $result['Voucher_id'];
} else {
    echo json_encode(array(
        'status' => 'error',
        'message' => isset($result['message']) ? $result['message'] : 'An unexpected error occurred.'
    ));
}