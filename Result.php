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
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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
					<h1>Data Result</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Dashboard </a>
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

			<div class="table-data">
				
				
			
				<div class="todo">
					<div class="head">
						<h3>Elective office (Position)</h3>
				<div class="" id="message1"></div>
						<a href="ADDOFFCICE.php" class='bx bx-plus' ></a>
					
					</div>
					<ul class="todo-list">
            <?php $office = $conn->fetch_office($Activeyear);
            foreach($office as $row){
            ?>
						<li class="completed">
							<p><?php echo $row['Electiveoffice'];  ?></p>
							<div class="dropdown">
        						<i class='bx bx-dots-vertical-rounded dropdown-btn'></i>
       							 <div class="dropdown-menu">
            					
									<a href="#" onclick="deleteYears(<?= $row['Office_id'] ?>)" class="delete-btns" data-ids="<?= $row['Office_id']; ?>">Delete</a>


       								 </div>
   							 </div>
						</li>
            <?php };  ?>
			<script>
			function deleteYears(office_id) {
    if (confirm("Are you sure you want to delete this office?")) {
        // Perform the AJAX request
        $.ajax({
            url: 'controllers/delete_office.php',
            method: 'POST',
            data: { office_id: office_id },
            success: function(response) {
                // Display success message
                $("#message1").html(response);
                console.log("Office deleted successfully.");
            },
            error: function() {
                console.log("Failed to delete office.");
            }
        });
    }
}


			</script>
					</ul>
				</div>
			</div>
			<div class="table-data">
				<div class="order">
				<div class="" id="message"></div>
					<div class="head">
						<h3>Candidate</h3>
						<div class="search-container">
				<input type="text" id="searchInput" placeholder="Search by name or office">
				<i class='bx bx-search'></i>
				<a href="ADDCANDIDATE.php" class='bx bx-plus' ></a>
			</div>
					</div>
					
					<table id='dataTable'>
						<thead>
							<tr>
								<th>Name</th>
								<th>Elective office</th>
								<th>Balot No.</th>
								<th>Year</th>
								<th>Number of votes</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php $ActiveYearz = $conn->fetchcandidatebyyear($Activeyear);
							foreach($ActiveYearz as $row){
								$pro = $row['profile_picture'];			
												?>
							<tr>
								<td>
									<img src="uploads/profile_pictures/<?php echo $pro?>" alt="Profile Picture">

									<p><?php echo $row['Candidate_fullname'];  ?></p>
								</td>
								<td><?php echo $row['Electiveoffice']; ?></td>
								<td><span style="padding:7px; border-radius:100px;background-color:#f44336;"><?php echo $row['Balotno']; ?></span></td>
								<td><span ><?php echo $row['OfficeYear']; ?></td>
								<td><span class="status completed">Completed</span></td>
								<td><button  class="edit-btn" onclick="updateYear(<?= $row['Candidate_id'] ?>)">
				<a href="EDIT-CANDIDATE.php?Candidate_id=<?= $row['Candidate_id']; ?>&Candidate-fullname=<?php echo $row['Candidate_fullname']; ?>" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
			<i class='bx bx-edit'></i> <!-- Edit Icon -->
                                                        </a> 
                </button>
			
				<button class="delete-btn" onclick="deleteYear(<?= $row['Candidate_id'] ?>)" data-id="<?= $row['Candidate_id']; ?>">
                    <i class='bx bx-trash'></i> <!-- Delete Icon -->
                </button></td>
							</tr>
							<?php }; ?>
						</tbody>
					</table>
				</div>
			
			</div>




<?php  foreach($office as $row){
	$position_idz = $row['Office_id']
	?>
			<div class="table-data">
    <div class="order">
        <div class="" id="message"></div>
        <div class="head">
            <h3>Candidate (<?= $row['Electiveoffice']; ?>)</h3>
            <div class="search-container">
                <input type="text" id="searchInput" placeholder="Search by name or office">
                <i class='bx bx-search'></i>
                <a href="ADDCANDIDATE.php" class='bx bx-plus'></a>
            </div>
        </div>

        <table id='dataTable'>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Elective office</th>
                    <th>Balot No.</th>
                    <th>Year</th>
                    <th>Number of votes</th> <!-- Added column for votes -->
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                // Fetch the candidates along with their vote count
                $Candidate = $conn->fetchcandidatebyyear_and_position_andvote($position_idz, $Activeyear);
                foreach ($Candidate as $row):
                    $pro = $row['profile_picture'];            
                ?>
                <tr>
                    <td>
                        <img src="uploads/profile_pictures/<?php echo $pro ?>" alt="Profile Picture">
                        <p><?php echo $row['Candidate_fullname']; ?></p>
                    </td>
                    <td><?php echo $row['Electiveoffice']; ?></td>
                    <td><span style="padding:7px; border-radius:100px;background-color:#f44336;"><?php echo $row['Balotno']; ?></span></td>
                    <td><span><?php echo $row['yearofcandidacy']; ?></span></td>
                    <!-- Display the number of votes -->
					 <?php
					$Candidate_id = $row['Candidate_id'];
					 $countvotess = $conn-> count_votes($Candidate_id); ?>
                    <td><span><?php echo  $countvotess  ?></span></td> <!-- Display TotalVotes here -->
                    <td>
                        <button class="edit-btn" onclick="updateYear(<?= $row['Candidate_id'] ?>)">
                            <a href="EDIT-CANDIDATE.php?Candidate_id=<?= $row['Candidate_id']; ?>&Candidate-fullname=<?php echo $row['Candidate_fullname']; ?>" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                                <i class='bx bx-edit'></i> <!-- Edit Icon -->
                            </a> 
                        </button>

                        <button class="delete-btn" onclick="deleteYear(<?= $row['Candidate_id'] ?>)" data-id="<?= $row['Candidate_id']; ?>">
                            <i class='bx bx-trash'></i> <!-- Delete Icon -->
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


			<?php } ?>
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	<style>
		/* Dropdown container */
.dropdown {
    position: relative;
    display: inline-block;
}

/* Dropdown menu hidden by default */
.dropdown-menu {
    display: none;
    position: absolute;
    background-color: #fff;
    min-width: 150px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    z-index: 1;
    border-radius: 4px;
    overflow: hidden;
	transition: opacity 0.3s ease, transform 0.3s ease;
    opacity: 0;
    transform: translateY(-10px);
}

/* Dropdown menu items */
.dropdown-menu a {
    color: #333;
    padding: 10px 15px;
    text-decoration: none;
    display: block;
}

/* Dropdown menu item hover effect */
.dropdown-menu a:hover {
    background-color: #f1f1f1;
}

/* Show dropdown when active */
.dropdown.show .dropdown-menu {
    display: block;
    opacity: 1;
    transform: translateY(0);
    transition: opacity 0.3s ease, transform 0.3s ease;
}

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
	<script src="script.js"></script>
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

function load_data() {
	$(document).on('click', '.delete-btn', function() {


		var user_id = $(this).attr("data-id");
		// console.log("================get course_id================");
		// console.log(course_id);
		if (confirm("Are you sure want to remove this data?")) {
			$.ajax({
				url: 'controllers/delete_candidate.php',
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






// Event listener using event delegation
document.addEventListener("click", function (e) {
    const dropdownBtn = e.target.closest(".dropdown-btn");
    if (dropdownBtn) {
        // Prevent closing all dropdowns immediately
        e.stopPropagation();
        const dropdown = dropdownBtn.parentElement;
        dropdown.classList.toggle("show");
    } else {
        // Close all dropdowns when clicking outside
        document.querySelectorAll(".dropdown").forEach(dropdown => {
            dropdown.classList.remove("show");
        });
    }
});

});
// Toggle dark mode
document.querySelector("#switch-mode").addEventListener("change", function () {
  isDarkMode = this.checked; // Set isDarkMode based on checkbox state
  document.body.classList.toggle("dark-mode", isDarkMode); // Toggle dark mode for body
  drawChart(); // Redraw chart with updated colors
});
window.addEventListener('resize', drawChart);

// Add click event listener to all dropdown buttons
document.querySelectorAll(".dropdown-btn").forEach(button => {
    button.addEventListener("click", function (e) {
        e.stopPropagation();
        const dropdown = this.nextElementSibling; // Correct reference to dropdown menu
        dropdown.classList.toggle("show");
    });
});


// Close all dropdowns when clicking outside
document.addEventListener("click", function () {
    document.querySelectorAll(".dropdown").forEach(dropdown => {
        dropdown.classList.remove("show");
    });
});

	</script>

	

</body>
</html>