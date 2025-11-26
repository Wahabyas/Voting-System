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
            <?php 
             include 'model/config/connection2.php';
             $GET_Year = intval($_GET['Year']);
             $Year_number = $_GET['Year-number'];
             $sql = "SELECT * FROM `year` WHERE `Year_id`= ? AND `Year` = ?";
             $stmt = $conn->prepare($sql); 
             $stmt->bind_param("is", $GET_Year, $Year_number);
             $stmt->execute();
             $result = $stmt->get_result();
             while ($row = $result->fetch_assoc()) {

                $Year = $row['Year']; 
                $Year_id = $row['Year_id'];
            }
                
            ?>
		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Edit-Year</h1>
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
            <h3>Edit Year</h3>
			<div class="" id="message"></div>
        </div>
        <form id="add-year-form"  name="user_form" method="POST">
            <div class="form-group">
                <label for="year-input">Enter Year:</label>
                <input 
                    value="<?php echo $Year  ?>"
                    type="number" 
                    id="year-input" 
                    name="year" 
                    class="form-control" 
                    placeholder="Enter a year (e.g., 2024)" 
                    required 
                    min="2013" 
                    max="2100">
            </div>
            <input type="text" name="year_id" value="<?php echo $Year_id  ?>" hidden >
            <div class="form-group">
                <button type="submit" class="btn-submit">Edit Submit</button>
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
      var b = $(this).find('input[name="year_id"]').val();

     if (a === ''){
          $('#message').html('<div class="alert alert-danger"> Required All Fields!</div>');
          window.scrollTo(0, 0);
        }else{
        $.ajax({
            url: 'controllers/edit_year.php',
            method: 'post',
            data: {
				year: a,
                year_id:b
             
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