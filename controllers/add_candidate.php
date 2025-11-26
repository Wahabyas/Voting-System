<?php
require_once "../model/class_model.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Create an instance of the class_model
    $conn = new class_model();

    // Text Inputs
    $Fullname = trim($_POST['Fullname']);
    $Username = trim($_POST['Username']); // This is actually the Office_id now
    $Balotno = trim($_POST['Balotno']);
    $yearofcandidacy = trim($_POST['yearofcandidacy']);

    // Check for empty fields
    if (empty($Fullname) || empty($Username) || empty($Balotno) || empty($yearofcandidacy)) {
        echo '<div class="alert alert-danger">All fields are required!</div>';
        exit;
    }

    // Handle file upload
    $profile_picture = null;
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profile_picture']['tmp_name'];
        $fileName = $_FILES['profile_picture']['name'];
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

       
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif' , 'jfif'];
        if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
            echo '<div class="alert alert-danger">Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.</div>';
            exit;
        }

        $newFileName = uniqid('profile_', true) . '.' . $fileExtension;
        $uploadDir = '../uploads/profile_pictures/';
        $dest_path = $uploadDir . $newFileName;

        // Check if upload directory exists, if not create it
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Move the uploaded file
        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $profile_picture = $newFileName; // Save only the file name for the database
        } else {
            echo '<div class="alert alert-danger">Error uploading the profile picture!</div>';
            exit;
        }
    }else{
      


    }

    // Sanitize user input (e.g., to prevent SQL injection or XSS attacks)
    $Fullname = htmlspecialchars($Fullname, ENT_QUOTES, 'UTF-8');
    $Username = htmlspecialchars($Username, ENT_QUOTES, 'UTF-8'); // Office_id is passed as Username
    $Balotno = intval($Balotno); // Ensure it's an integer
    $yearofcandidacy = htmlspecialchars($yearofcandidacy, ENT_QUOTES, 'UTF-8');

    // Insert candidate with profile picture
    if ($Fullname && $Balotno && $yearofcandidacy && $Username && $profile_picture){
    $user = $conn->add_candidate($Fullname, $Balotno, $yearofcandidacy, $Username, $profile_picture);
    }else{
        echo '<div class="alert alert-danger">Required to enter Profile</div>';
        exit();
    }

    // Check if insertion was successful
    if ($user === true) {
        echo '<div class="alert alert-success">Candidate added successfully!</div>
              <script> setTimeout(function() { window.history.go(-1); }, 2000); </script>';
    } else {
        echo '<div class="alert alert-danger">Failed to add candidate. Please try again.</div>
              <script> setTimeout(function() { window.history.go(1); }, 2000); </script>';
    }
}
?>
