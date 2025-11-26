<?php
  require_once "../model/class_model.php";
	if(ISSET($_POST)){
		$conn = new class_model();

		$year = trim($_POST['year']);
		$status = 1;
		

		

		$user = $conn->add_year($year,$status);
		if($user == TRUE){
		    echo '<div class="alert alert-success">Add User Successfully!</div><script> setTimeout(function() {  window.history.go(-1); }, 2000); </script>';
		  }else{
			echo '<div class="alert alert-danger">Add User Failed!</div><script> setTimeout(function() {  window.history.go(1); }, 2000); </script>';
		}
	}
?>

