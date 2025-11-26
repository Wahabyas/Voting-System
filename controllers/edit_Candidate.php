<?php
  require_once "../model/class_model.php";

	if(ISSET($_POST)){
		$conn = new class_model();

		$fullname = trim($_POST['fullname']);
		$Balotno = trim($_POST['Balotno']);

		$Candidate_id = trim($_POST['Candidate_id']);
	;

		$course = $conn->edit_candidate($fullname, $Balotno,$Candidate_id);
		if($course == TRUE){
		    echo '<div class="alert alert-success">Edit Candidate Successfully!</div><script> setTimeout(function() {  window.history.go(0); }, 1000); </script>';

		  }else{
			echo '<div class="alert alert-danger">Edit Candidate Failed!</div><script> setTimeout(function() {  window.history.go(-0); }, 1000); </script>';
		}
	}
?>

