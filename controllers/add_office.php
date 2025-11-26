<?php
  require_once "../model/class_model.php";
	if(ISSET($_POST)){
		$conn = new class_model();

		$Electiveoffice = trim($_POST['Electiveoffice']);
		$Year = trim($_POST['Year']);

		



		$user = $conn->add_office($Electiveoffice,$Year);
		if($user == TRUE){
		    echo '<div class="alert alert-success">Add Elective office Successfully!</div><script> setTimeout(function() {  window.history.go(0); }, 2000); </script>';
		  }else{
			echo '<div class="alert alert-danger">Add Elective office Failed!</div><script> setTimeout(function() {  window.history.go(0); }, 2000); </script>';
		}
	}
?>

