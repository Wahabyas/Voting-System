<?php
  require_once "../model/class_model.php";;
	if(ISSET($_POST)){
		$conn = new class_model();
		$year_id = trim($_POST['Year_id']);
		$year = $conn->delete_Candidate($year_id);
		if($year == TRUE){
		    echo '<div class="alert alert-danger">Delete Candidate Successfully!</div><script> setTimeout(function() {  window.history.go(-0); }, 1000); </script>';

		  }else{
			echo '<div class="alert alert-danger">Delete Candidate Failed!</div><script> setTimeout(function() {  window.history.go(-0); }, 1000); </script>';
		}
	}
?>

