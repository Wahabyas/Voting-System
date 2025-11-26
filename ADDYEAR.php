<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="style.css">
	<script src="js/jquery.min.js"></script>
    <script src="js/jquery-3.3.1.min.js"></script>
	<title>voting system</title>
	<style>
	



	</style>
</head>
<body>
<?php include 'sidebar/sidebar.php'?>




	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<?php include 'header/header.php'?>

		
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Add-Year</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="indexbase.php">Home</a>
						</li>
					</ul>
				</div>
			
			</div>

			


			<div class="table-data">
    <div class="order">
        <div class="head">
            <h3>Add Year</h3>
			<div class="" id="message"></div>
        </div>
        <form id="add-year-form"  name="user_form" method="POST">
            <div class="form-group">
                <label for="year-input">Enter Year:</label>
                <input 
                    type="number" 
                    id="year-input" 
                    name="year" 
                    class="form-control" 
                    placeholder="Enter a year (e.g., 2024)" 
                    required 
                    min="2013" 
                    max="2100">
            </div>
            <div class="form-group">
                <button type="submit" class="btn-submit">Add Year</button>
            </div>
        </form>
    </div>
</div>

		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	
		<script>
  $(document).ready(function() {
   $('form[name="user_form"]').on('submit', function(e){
      e.preventDefault();

      var a = $(this).find('input[name="year"]').val();
      

     if (a === ''){
          $('#message').html('<div class="alert alert-danger"> Required All Fields!</div>');
          window.scrollTo(0, 0);
        }else{
        $.ajax({
            url: 'controllers/add_year.php',
            method: 'post',
            data: {
				year: a
             
            },
            success: function(response) {

              $("#message").html(response);
              setTimeout(function () {
				window.history.go(-1);
             
            }, 1000); },
              error: function(response) {
                console.log("Failed");
              }
          });
       }
     });
  });
</script>
	
	

	<script src="script.js"></script>
</body>
</html>