<?php
  require_once "../model/class_model.php";
	if(ISSET($_POST)){
		$conn = new class_model();
		$year_id = trim($_POST['Year_id']);
		$year = $conn->Activate_year($year_id);
		if($year == TRUE){
		    echo '<div class="alert alert-success">Activate Year Successfully!</div><script> setTimeout(function() {  window.history.go(-0); }, 1000); </script>';

		  }else{
			echo '<div class="alert alert-danger">Activate Year Failed!</div><script> setTimeout(function() {  window.history.go(-0); }, 1000); </script>';
		}
	}
?>

