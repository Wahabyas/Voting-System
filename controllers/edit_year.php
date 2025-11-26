<?php
  require_once "../model/class_model.php";

	if(ISSET($_POST)){
		$conn = new class_model();

		$year = trim($_POST['year']);
		$year_id = trim($_POST['year_id']);
	;

		$course = $conn->edit_year($year, $year_id);
		if($course == TRUE){
		    echo '<div class="alert alert-success">Edit year Successfully!</div><script> setTimeout(function() {  window.history.go(0); }, 1000); </script>';

		  }else{
			echo '<div class="alert alert-danger">Edit year Failed!</div><script> setTimeout(function() {  window.history.go(-0); }, 1000); </script>';
		}
	}
?>

