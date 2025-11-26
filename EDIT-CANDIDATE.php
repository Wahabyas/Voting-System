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
             $Candidate_fullname = $_GET['Candidate-fullname'];
             $Candidate_id = intval($_GET['Candidate_id']);
             $sql = "SELECT * FROM `candidate` WHERE `Candidate_id`= ? AND `Candidate_fullname` = ?";
             $stmt = $conn->prepare($sql); 
             $stmt->bind_param("is", $Candidate_id, $Candidate_fullname);
             $stmt->execute();
             $result = $stmt->get_result();
             while ($row = $result->fetch_assoc()) {

                $Fullname = $row['Candidate_fullname']; 
                $Balotno = $row['Balotno']; 
                $Password = $row['yearofcandidacy']; 
              
                $Candidate_id = $row['Candidate_id'];
            }
                
            ?>
		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Edit-Candidate</h1>
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
            <h3>Edit Candidate</h3>
			<div class="" id="message"></div>
        </div>
        <form id="edit-user-form" name="user_form" method="POST" style="max-width: 600px; margin: 0 auto;border: 1px solid #ccc; border-radius: 8px;padding: 20px;">
    <h3 style="text-align: center; margin-bottom: 20px;">Edit Candidate</h3>
    <div class="form-group" style="margin-bottom: 15px;">
        <label for="fullname" style="display: block; margin-bottom: 5px;">Full Name:</label>
        <input 
            value="<?php echo $Fullname; ?>" 
            type="text" 
            id="fullname" 
            name="fullname" 
            class="form-control" 
            placeholder="Enter full name" 
            style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" 
            required>
    </div>
    <div class="form-group" style="margin-bottom: 15px;">
        <label for="username" style="display: block; margin-bottom: 5px;">Balot no:</label>
        <input 
            value="<?php echo $Balotno; ?>" 
            type="text" 
            id="Balotno" 
            name="Balotno" 
            class="form-control" 
            placeholder="Enter username" 
            style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" 
            required>
    </div>
 

  
    <input type="hidden" name="Candidate_id" value="<?php echo $Candidate_id; ?>">
    <div class="form-group" style="text-align: center;">
        <button 
            type="submit" 
            class="btn-submit" 
            style="background-color: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; ">
            Edit Submit
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

      var fullname = $(this).find('input[name="fullname"]').val();
      var Balotno = $(this).find('input[name="Balotno"]').val();

      var Candidate_id = $(this).find('input[name="Candidate_id"]').val();

     if (fullname === '' || Balotno === '' ){
          $('#message').html('<div class="alert alert-danger"> Required All Fields!</div>');
          window.scrollTo(0, 0);
        }else{
        $.ajax({
            url: 'controllers/edit_Candidate.php',
            method: 'post',
            data: {
                fullname: fullname,
                Balotno: Balotno,
        
                Candidate_id: Candidate_id
             
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