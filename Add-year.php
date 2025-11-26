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
	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<?php include 'header/header.php'?>
		<!-- NAVBAR -->
		<!-- MAIN -->
		<?php   $conn = new class_model();
		 $years = $conn->fetchAll_year();
		 $conn = new class_model(); 
		 $Activeyear = $conn->fetchActive_year();
		 foreach($Activeyear as $row){
	 
			 $Activeyear=$row['Year'];
		 };
		 $numberofvoter= $conn->count_Voter($Activeyear);
		$numberofCandidate = $conn->count_candidate($Activeyear);
		?>
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
				<a href="#" class="btn-download">
					<i class='bx bxs-cloud-download' ></i>
					<span class="text">Download PDF</span>
				</a>
			</div>

			<ul class="box-info">
				<li>
					<i class='bx bxs-user-check' ></i>
					<span class="text">
						<h3><?= $numberofvoter ?></h3>
						<p>Voters</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-calendar-check' ></i>
					<span class="text">
						<h3><?php echo $Activeyear; ?> </h3>
						<p>(Active) Year Election</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-user-detail' ></i>
					<span class="text">
						<h3><?= $numberofCandidate  ?></h3>
						<p>Count of Candidate</p>
					</span>
				</li>
			</ul>
			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Add Year</h3>
						
						<div class="search-container">
				<input type="text" id="searchInput" placeholder="Search by Year">
				<i class='bx bx-search'></i>
			</div>
						<a class='bx bx-filter' id="sort" ></a>
						<a class='bx bx-plus'  href='ADDYEAR.php'></a>
						<select id="rowsPerPage" class="dropdown">
					<option value="20">Show 20</option>
					<option value="100">Show 100</option>
					<option value="200">Show 200</option>
				</select>
					</div>
					<div class="" id="message"></div>
					<table id="dataTable">
						<thead>
							<tr>
								<th id="yearHeader" class="sortable">Year of Election</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
    <?php foreach ($years as $roq): ?>
        <tr>
            <td>
                <img src="img/Yassef.jpg">
                <p><?php echo $roq['Year']; ?></p>
            </td>
            <td>
                <?= $roq['Status'] == 1 ? '<span class="status completed">Active</span>' : '<span class="status pending">Deactivated</span>' ?>
            </td>
            <td>
                <button  class="edit-btn" onclick="updateYear(<?= $roq['Year_id'] ?>)">
				<a href="Edit-year.php?Year=<?= $roq['Year_id']; ?>&Year-number=<?php echo $roq['Year']; ?>" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
			<i class='bx bx-edit'></i> <!-- Edit Icon -->  </a> 
                </button>
				
                <button class="activate-btn" onclick="activateYear(<?= $roq['Year_id'] ?> )" data-ids="<?= $roq['Year_id']; ?>">
                    <i class='bx bx-check-circle'></i> <!-- Activate Icon -->
                </button>
                <button class="delete-btn" onclick="deleteYear(<?= $roq['Year_id'] ?>)" data-id="<?= $roq['Year_id']; ?>">
                    <i class='bx bx-trash'></i> <!-- Delete Icon -->
                </button>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>

					</table>
				</div>
		
			</div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	 <script>
		
		  
		 $(document).ready(function() {load_data();

var count = 1;

function load_data() {
	$(document).on('click', '.delete-btn', function() {


		var user_id = $(this).attr("data-id");
		// console.log("================get course_id================");
		// console.log(course_id);
		if (confirm("Are you sure want to remove this data?")) {
			$.ajax({
				url: 'controllers/delete_year.php',
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
	  <script>
		
		  
		$(document).ready(function() {load_data();

var count = 1;

function load_data() {
   $(document).on('click', '.activate-btn', function() {


	   var user_ids = $(this).attr("data-ids");
	   // console.log("================get course_id================");
	   // console.log(course_id);
	   if (confirm("Are you sure want to Activate this year of election?")) {
		   $.ajax({
			   url: 'controllers/activate_year.php',
			   method: "POST",
			   data: {
				   Year_id: user_ids
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
	<script>
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
		$(document).ready(function () {
    let isAscending = true; // Sorting flag

    // Sorting functionality
    $('#sort').on('click', function () {
        const rows = $('#dataTable tbody tr').get();

        rows.sort(function (a, b) {
            const yearA = parseInt($(a).find('td p').text(), 10);
            const yearB = parseInt($(b).find('td p').text(), 10);
            return isAscending ? yearA - yearB : yearB - yearA;
        });

        $.each(rows, function (index, row) {
            $('#dataTable tbody').append(row);
        });

        isAscending = !isAscending;
        $('#yearHeader').text(`Year of Election (${isAscending ? '↓' : '↑'})`);
    });

    // Search functionality
    $('#searchInput').on('keyup', function () {
        const value = $(this).val().toLowerCase();
        $('#dataTable tbody tr').filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    // Rows per page functionality
    $('#rowsPerPage').on('change', function () {
        const rowsToShow = $(this).val();
        const rows = $('#dataTable tbody tr');
        rows.hide();
        rows.slice(0, rowsToShow).show();
    }).trigger('change');
});


    // Hide dropdown if clicked outside
    $(document).on('click', function (e) {
        if (!$(e.target).closest('.form-input').length) {
            $('#searchResults').hide();
        }
    });


	</script>

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

	<script src="script.js"></script>
</body>
</html>