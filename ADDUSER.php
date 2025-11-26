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
					<h1>Add-User</h1>
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
            <h3>Add User</h3>
			<div class="" id="message"></div>
        </div>
        <form id="add-year-form" name="user_form" method="POST" style="max-width: 500px; margin: 20px auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px;">
    <h3 style="text-align: center; margin-bottom: 20px;">Add User</h3>
    
    <!-- Full Name -->
    <div class="form-group" style="margin-bottom: 15px;">
        <label for="fullname-input" style="display: block; margin-bottom: 5px; font-weight: bold;">Full Name:</label>
        <input 
            type="text" 
            id="fullname-input" 
            name="Fullname" 
            class="form-control" 
            placeholder="Enter Full Name" 
            required 
            style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
    </div>
    
    <!-- Username -->
    <div class="form-group" style="margin-bottom: 15px;">
        <label for="username-input" style="display: block; margin-bottom: 5px; font-weight: bold;">Username:</label>
        <input 
            type="text" 
            id="username-input" 
            name="Username" 
            class="form-control" 
            placeholder="Enter Username" 
            required 
            style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
    </div>
    
    <!-- Password -->
    <div class="form-group" style="margin-bottom: 15px;">
        <label for="password-input" style="display: block; margin-bottom: 5px; font-weight: bold;">Password:</label>
        <input 
            type="password" 
            id="password-input" 
            name="password" 
            class="form-control" 
            placeholder="Enter Password" 
            required 
            style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
    </div>
    <div class="form-group" style="margin-bottom: 20px;">
        <label for="profile-picture" style="display: block; margin-bottom: 5px; font-weight: bold;">Profile Picture of Candidate:</label>
        <input type="file" id="profile-picture" name="profile_picture" accept="image/*" 
               style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
    </div>
    
    <!-- Role Selection -->
    <div class="form-group" style="margin-bottom: 20px;">
        <label for="role-select" style="display: block; margin-bottom: 5px; font-weight: bold;">Role:</label>
        <select 
            id="role-select" 
            name="sel" 
            class="form-control" 
            style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
            <option value="User">User</option>
            <option value="Admin">Admin</option>
        </select>
    </div>
    
    <!-- Submit Button -->
    <div class="form-group" style="text-align: center;">
        <button 
            type="submit" 
            class="btn-submit" 
            style="background-color: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">
            Add User
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

      var a = $(this).find('input[name="Fullname"]').val();
      var b = $(this).find('input[name="Username"]').val();
      var c = $(this).find('input[name="password"]').val();
      var d = $(this).find('select[name="sel"]').val();
      var profile_picture = $('input[name="profile_picture"]')[0].files[0];


     if (a === ''){
          $('#message').html('<div class="alert alert-danger"> Required All Fields!</div>');
          window.scrollTo(0, 0);
        }else{
            var formData = new FormData();
            formData.append('Fullname', a);
            formData.append('Username', b);
            formData.append('password', c);
            formData.append('sel', d);
            formData.append('profile_picture', profile_picture);     
            $.ajax({
                url: 'controllers/add_user.php',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $("#message").html(response);
                    setTimeout(function () {
                      
                    }, 1000);
                },
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