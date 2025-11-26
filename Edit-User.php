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
             $sql = "SELECT * FROM `user` WHERE `user_id`= ? AND `Fullname` = ?";
             $stmt = $conn->prepare($sql); 
             $stmt->bind_param("is", $GET_Year, $Year_number);
             $stmt->execute();
             $result = $stmt->get_result();
             while ($row = $result->fetch_assoc()) {

                $Fullname = $row['Fullname']; 
                $UserName = $row['UserName']; 
                $Password = $row['Password']; 
                $account_status = $row['account_status']; 
                $role = $row['role']; 
                $user_id = $row['user_id'];
            }
                
            ?>
		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Edit-User</h1>
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
            <h3>Edit User</h3>
			<div class="" id="message"></div>
        </div>
        <form id="edit-user-form" name="user_form" method="POST" style="max-width: 600px; margin: 0 auto;border: 1px solid #ccc; border-radius: 8px;padding: 20px;">
    <h3 style="text-align: center; margin-bottom: 20px;">Edit User</h3>
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
        <label for="username" style="display: block; margin-bottom: 5px;">Username:</label>
        <input 
            value="<?php echo $UserName; ?>" 
            type="text" 
            id="username" 
            name="username" 
            class="form-control" 
            placeholder="Enter username" 
            style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" 
            required>
    </div>
    <div class="form-group" style="margin-bottom: 15px;">
        <label for="password" style="display: block; margin-bottom: 5px;">Password:</label>
        <input 
            value="<?php echo $Password; ?>" 
            type="text" 
            id="password" 
            name="password" 
            class="form-control" 
            placeholder="Enter password" 
            style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" 
            required>
    </div>
    <div class="form-group" style="margin-bottom: 15px;">
        <label for="status" style="display: block; margin-bottom: 5px;">Account Status:</label>
        <select 
            name="status" 
            id="status" 
            class="form-control" 
            style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
            <option value="Active" <?php echo $account_status == 'Active' ? 'selected' : ''; ?>>Active</option>
            <option value="Inactive" <?php echo $account_status == 'Inactive' ? 'selected' : ''; ?>>Inactive</option>
        </select>
    </div>
    <div class="form-group" style="margin-bottom: 15px;">
        <label for="role" style="display: block; margin-bottom: 5px;">Role:</label>
        <select 
            name="role" 
            id="role" 
            class="form-control" 
            style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
            <option value="Admin" <?php echo $role == 'Admin' ? 'selected' : ''; ?>>Admin</option>
            <option value="User" <?php echo $role == 'User' ? 'selected' : ''; ?>>User</option>
        </select>
    </div>
    <input type="hidden" name="year_id" value="<?php echo $user_id; ?>">
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
      var username = $(this).find('input[name="username"]').val();
      var password = $(this).find('input[name="password"]').val();
      var status = $(this).find('select[name="status"]').val();
      var role = $(this).find('select[name="role"]').val();
      var year_id = $(this).find('input[name="year_id"]').val();

     if (fullname === '' || username === '' || password === '' || status === '' || role === ''){
          $('#message').html('<div class="alert alert-danger"> Required All Fields!</div>');
          window.scrollTo(0, 0);
        }else{
        $.ajax({
            url: 'controllers/edit_user.php',
            method: 'post',
            data: {
                fullname: fullname,
          username: username,
          password: password,
          status: status,
          role: role,
          year_id: year_id
             
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