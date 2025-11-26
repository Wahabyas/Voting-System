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
<body>
	
<?php include 'sidebar/sidebar.php'?>




	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<?php include 'header/header.php'?>
		<?php   $conn = new class_model(); 
		$Activeyear = $conn->fetchActive_year();
		foreach($Activeyear as $row){
	
			$Activeyear=$row['Year'];
		};
		$numberofvoter= $conn->count_Voter($Activeyear);
		$numberofCandidate = $conn->count_candidate($Activeyear);
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
						<h3><?= $numberofvoter ?></h3>
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
						<h3><?= $numberofCandidate ?></h3>
						<p>Count of Candidate</p>
					</span>
				</li>
			</ul>
			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Top Candidate</h3>
						<div class="search-container">
				<input type="text" id="searchInput" placeholder="Search by name or office">
				<i class='bx bx-search'></i>
				<a class='bx bx-filter' id="sort" ></a>
			</div>
					</div>
					
					<?php
// Fetch the candidates and their votes
$fetch = $conn->fetchcandidatebyyear($Activeyear);

// Store the highest vote per Electiveoffice
$highestVotes = [];

// First loop to find the highest votes per Electiveoffice
foreach($fetch as $row) {
    $Office_idp  = $row['Candidate_id'];
    $candidate = $conn->fetchAll_candidateposition($Office_idp);
    
    $id = null;
    $cont = 0;
    foreach($candidate as $roow) {
        $id = $roow['Candidate_id'];
        $cont = $conn->count_votes($id);  // Get the vote count for this candidate
    }
    
    // Store the highest vote for each office
    $electiveOffice = $row['Electiveoffice'];
    if (!isset($highestVotes[$electiveOffice]) || $highestVotes[$electiveOffice] < $cont) {
        $highestVotes[$electiveOffice] = $cont;
    }
}

// Now loop through the candidates and only display the ones with the highest votes for each office
?>
<table id='dataTable'>
    <thead>
        <tr>
            <th>Name</th>
            <th>Elective office</th>
            <th id="sorts">Number of votes</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        foreach($fetch as $row) {
            $Office_idp  = $row['Candidate_id'];
            $candidate = $conn->fetchAll_candidateposition($Office_idp);
            
            $id = null;
            $cont = 0;
            foreach($candidate as $roow) {
                $id = $roow['Candidate_id'];
                $cont = $conn->count_votes($id);  // Get the vote count for this candidate
            }
            
            // Only display the candidate if their votes match the highest votes for their office
            if ($cont == $highestVotes[$row['Electiveoffice']]) {
                ?>
                <tr>
                    <td>
                        <img src="uploads/profile_pictures/<?php echo $row['profile_picture']?>">
                        <p><?= $row['Candidate_fullname'] ?></p>
                    </td>
                    <td><?= $row['Electiveoffice'] ?></td>
                    <td><span class="status completed"><?= $cont ?></span></td>
                </tr>
                <?php
            }
        }
        ?>
    </tbody>
</table>

				</div>
				<div class="todo">
					<div class="head">
						<h3>Elective office</h3>
						<a href="ADDOFFCICE.php" class='bx bx-plus' ></a>
				
					</div>
					<ul class="todo-list">
					<?php $office = $conn->fetch_office($Activeyear);
            foreach($office as $row){
            ?>
						<li class="completed">
							<p><?php echo $row['Electiveoffice'];  ?></p>
							<i class='bx bx-dots-vertical-rounded' ></i>
						</li>
            <?php };  ?>
					</ul>
				</div>
			</div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
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
        $('#sorts').text(`Number of votes (${isAscending ? '↓' : '↑'})`);
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
	<script src="script.js"></script>
</body>
</html>