<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="style.css">

	<title>voting system</title>
</head>
<style>
	button {
    border: none;
    background: none;
    padding: 2px 10px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
	border-radius: 30px;
}
.dropdown {
			padding: 5px;
			border: 1px solid #ccc;
			border-radius: 5px;
		}

button i {
    font-size: 20px;
    color: #fff;
    transition: color 0.3s;
}

button.edit-btn {
    background-color: #4CAF50; /* Green */
}

button.activate-btn {
    background-color: #008CBA; /* Blue */
}

button.delete-btn {
    background-color: #f44336; /* Red */
}

button:hover i {
    color: #fff;
}

button:hover {
    opacity: 0.8;
}
</style>
<body>
	
<?php include 'sidebar/sidebar.php'?>




	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<?php include 'header/header.php'?>
		<?php   $conn = new class_model(); 
		$Activeyear = $conn->fetchActive_year();
		$Users = $conn->fetchAll_User();

		foreach($Activeyear as $row){
			$Activeyear=$row['Year'];
		};

		?>
		
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Dashboard</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="#">Home</a>
						</li>
					</ul>
				</div>
				<a href="#" class="btn-download">
					<i class='bx bxs-cloud-download' ></i>
					<span class="text">Download PDF</span>
				</a>
			</div>

			<ul class="box-info">
				<li>
					<i class='bx bxs-user-check' ></i>
					<span class="text">
						<h3>1020</h3>
						<p>Voters</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-calendar-check' ></i>
					<span class="text">
						<h3><?php echo $Activeyear; ?>  </h3>
						<p>(Active) Year Election</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-user-detail' ></i>
					<span class="text">
						<h3>200</h3>
						<p>Count of Candidate</p>
					</span>
				</li>
			</ul>
			<div class="table-data">
				<div class="order">
					<div class="head">
					<div class="" id="message"></div>
						<h3>Users</h3>
						<div class="search-container">
				<input type="text" id="searchInput" placeholder="Search by name or office">
				<i class='bx bx-search'></i>
				<a class='bx bx-plus'  href='ADDUSER.php'></a>
			</div>
					</div>
					
					<table  id="dataTable">
						<thead>
							<tr>
								<th>Name</th>
								<th>Role</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach($Users as $row){ 
							$pro = $row['profile_picture'];	
							?>
							<tr >
								<td>
									<img src="uploads/profile_pictures/<?php  echo  $pro?>">
						
									<p><?php echo $row['Fullname'] ?></p>
								</td>
								<td><?php echo $row['role'] ?></td>
								<td><span class="status completed"><?php echo $row['account_status'] ?></span></td>
								<td> <button  class="edit-btn" onclick="updateYear(<?= $row['user_id'] ?>)">
				<a href="Edit-User.php?Year=<?= $row['user_id']; ?>&Year-number=<?php echo $row['Fullname']; ?>" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
			<i class='bx bx-edit'></i> <!-- Edit Icon -->
                                                        </a> 
                </button>
			
				<button style="display:<?= $me == $row['user_id'] ? 'none' : '' ?>;" class="delete-btn" onclick="deleteYear(<?= $row['user_id'] ?>)" data-id="<?= $row['user_id']; ?>">
                    <i class='bx bx-trash'></i> <!-- Delete Icon -->
                </button>
			</td>
							</tr>
							<?php }; ?>
						</tbody>
					</table>
				</div>
				
			</div>
			
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
<script>

    // Hide dropdown if clicked outside
    $(document).on('click', function (e) {
        if (!$(e.target).closest('.form-input').length) {
            $('#searchResults').hide();
        }
    });



$(document).ready(function() {
			// Search Functionality
			$('#searchInput').on('keyup', function() {
				let value = $(this).val().toLowerCase();
				$('#dataTable tbody tr').filter(function() {
					$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
				});
			});

			// Rows per Page Dropdown
			$('#rowsPerPage').on('change', function() {
				let rowsToShow = $(this).val();
				let rows = $('#dataTable tbody tr');
				rows.hide(); // Hide all rows
				rows.slice(0, rowsToShow).show(); // Show the selected number of rows
			});

			// Initial Rows Display
			$('#rowsPerPage').trigger('change');
		});

		
		$(document).ready(function() {load_data();

var count = 1;

function load_data() {
	$(document).on('click', '.delete-btn', function() {


		var user_id = $(this).attr("data-id");
		// console.log("================get course_id================");
		// console.log(course_id);
		if (confirm("Are you sure want to remove this data?")) {
			$.ajax({
				url: 'controllers/delete_user.php',
				method: "POST",
				data: {
					Year_id: user_id
				},
			  success: function(response) {

				  $("#message").html(response);
				  },
				  error: function(response) {
					console.log("Failed");
				  }
			})
		}
	});
}

});
</script>
	<script src="script.js"></script>
</body>
</html>