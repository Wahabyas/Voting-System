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

</head>

<body>
<?php include 'sidebar/sidebar.php'?>

<?php   $conn = new class_model(); 
		$Activeyear = $conn->fetchActive_year();
		foreach($Activeyear as $row){
	
			$Activeyear=$row['Year'];
		};
		?>


	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<?php include 'header/header.php'?>

		
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Add-Elective office</h1>
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
            <h3>Add Elective office</h3>
			<div class="" id="message"></div>
        </div>
        <form id="add-year-form" name="user_form" method="POST" style="max-width: 500px; margin: 20px auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px;">
    <h3 style="text-align: center; margin-bottom: 20px;">Add Elective office</h3>
    
    <!-- Full Name -->
    <div class="form-group" style="margin-bottom: 15px;">
        <label for="fullname-input" style="display: block; margin-bottom: 5px; font-weight: bold;">Elective office</label>
        <input 
            type="text" 
            id="fullname-input" 
            name="Elective_office" 
            class="form-control" 
            placeholder="Enter Elective office" 
            required 
            style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
    </div>
    <div class="form-group" style="margin-bottom: 15px;">
        <label for="fullname-input" style="display: block; margin-bottom: 5px; font-weight: bold;">Year</label>
        <input 
            type="number" 
            id="fullname-input" 
            name="Year" 
            class="form-control" 
            value="<?php  echo $Activeyear ?>"
            placeholder="Year (Active Election)" 
            required 
            style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" 
            readonly
            >
    </div>
 
    
    <!-- Submit Button -->
    <div class="form-group" style="text-align: center;">
        <button 
            type="submit" 
            class="btn-submit" 
            style="background-color: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">
            Add Elective office
        </button>
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

      var a = $(this).find('input[name="Elective_office"]').val();
      var b = $(this).find('input[name="Year"]').val();
    

     if (a === ''){
          $('#message').html('<div class="alert alert-danger"> Required All Fields!</div>');
          window.scrollTo(0, 0);
        }else{
        $.ajax({
            url: 'controllers/add_office.php',
            method: 'post',
            data: {
				Electiveoffice: a,
				Year: b
			
             
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