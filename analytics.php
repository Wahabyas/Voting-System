<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="style.css">
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
		<?php  $Voucher=$conn->fetch_voucher();  ?>
		<?php $Allyears = $conn->select_years() ?>
	
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Analytics</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Analytics</a>
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
				<div class="order">
				<div class="head">
						<h3>Number of Voters</h3>
						
					</div>
					<button id="change-chart" class='bx bx-filter'>Change to Classic</button>
					
    <br><br>
    <div id="chart_div" style="width: 800px; height: 500px;"></div>
				</div>
				
				<div class="todo">
					
					<div class="head">
						<h3>Top Candidate</h3>
						
					</div>
					<div id="piechart_3d" style="width: 500px; height: 500px;"></div>
				</div>
			
			</div>
			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Voter Voucher</h3>
						<div class="search-container">
				<input type="text" id="searchInput" placeholder="Search by name or office">
				<i class='bx bx-search'></i>
			</div>
					</div>
					<table  id='dataTable'>
						<thead>
							<tr>
								<th>Voucher Code</th>
								<th>Use</th>
								<th>Voted</th>
							</tr>
						</thead>
						<tbody>
							<?php  $Voucher=$conn->fetch_voucher(); 
							foreach ($Voucher as $row):
							?>
							<tr>
								<td>
									
									<p><?= $row['Voucher_code'] ?></p>
								</td>
								<?php if($row['Status']== '1'){ ?>
								<td><span class="status completed">Used</span></td>
								<?php }elseif($row['Status']== '0'){?>
								<td><span class="status pending">Not yet</span></td>
								<?php } ?>
								<?php if ( $row['isvote'] == '1'){ ?>
								<td><span class="status completed">Voted</span></td>
								<?php }elseif($row['isvote'] == '0'){ ?>
								<td><span class="status pending">Not Yet</span></td>

									<?php } ?>
							</tr>
						
						<?php endforeach ?>
						
						
						</tbody>
					</table>
				</div>
			
			</div>
		</main>
		<!-- MAIN -->
	</section>
	<script src="script.js"></script>
	<script>
		google.charts.load("current", {packages: ["corechart"]});
google.charts.setOnLoadCallback(drawChart);
let isDarkMode = false;
<?php 
$candidatecurrent = $conn->fetchcandidatebyyear($Activeyear);
$chartDatash = [];
foreach ($candidatecurrent as $row) {
    // Get candidate ID and number of votes for that candidate
    $Candidate_id = $row['Candidate_id'];
    $numberofvotes = $conn->count_votes($Candidate_id);  // Get votes for each candidate

    // Ensure safe output for candidate names and numbers
    $candidate_name = addslashes($row['candidate']);
    $chartDatash[] = "['$candidate_name', $numberofvotes]";
  }
  $chartDataStringsh = implode(",", $chartDatash);
?>
function drawChart() {
  const backgroundColor = isDarkMode ? "transparent" : "transparent"; // Dark or light background
  const textColor = isDarkMode ? "#ffffff" : "#000000"; // Text color based on theme

  var data = google.visualization.arrayToDataTable([
    ["Task", "Hours per Day"]
	<?php echo $chartDataStringsh; ?> 
  ]);

  var options = {
    title: "Votes per Candidate",
    is3D: true,
    backgroundColor: backgroundColor,
    titleTextStyle: {
      color: textColor,
    },
    legend: {
      textStyle: { color: textColor },
    },
  };

  var chart = new google.visualization.PieChart(
    document.getElementById("piechart_3d")
  );
  chart.draw(data, options);
}

// Toggle dark mode
document.querySelector("#switch-mode").addEventListener("change", function () {
  isDarkMode = this.checked; // Set isDarkMode based on checkbox state
  document.body.classList.toggle("dark-mode", isDarkMode); // Toggle dark mode for body
  drawChart(); // Redraw chart with updated colors
});
window.addEventListener('resize', drawChart);


	</script>
	 <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart', 'bar']});
      google.charts.setOnLoadCallback(drawStuff);

      function drawStuff() {

        var button = document.getElementById('change-chart');
        var chartDiv = document.getElementById('chart_div');  
		<?php $Allyears = $conn->select_years();

		$chartData = [];
		foreach ($Allyears as $row) {
			$Activeyear = $row['Year'];
			$numberofvoter= $conn->count_Voter($Activeyear);
			$numberofCandidate = $conn->count_candidate($Activeyear);
            $chartData[] = "['" . $row['Year'] . "', '".$numberofvoter."', '".$numberofCandidate."']";
        }
        // Convert the PHP array to a JavaScript compatible string
        $chartDataString = implode(",", $chartData);
		?>
		
        var data = google.visualization.arrayToDataTable([
          ['Visual', 'Voters', 'Candidate'],
		  <?php echo $chartDataString; ?>
        ]);

        var materialOptions = {
          width: 900,
          chart: {
            title: 'Voters Each Election',
            subtitle: 'Voters on the left, Candidate on the right'
          },
		  backgroundColor: 'transparent',
          series: {
            0: { axis: 'Candidate' }, // Bind series 0 to an axis named 'distance'.
            1: { axis: 'Voters' } // Bind series 1 to an axis named 'brightness'.
          },
          axes: {
            y: {
              distance: {label: 'parsecs'}, // Left y-axis.
              brightness: {side: 'right', label: 'apparent magnitude'} // Right y-axis.
            }
          }
        };

        var classicOptions = {
          width: 900,
          series: {
            0: {targetAxisIndex: 0},
            1: {targetAxisIndex: 1}
          },
		  backgroundColor: 'transparent',
          title: 'Voters on the left, Candidate on the right',
          vAxes: {
            // Adds titles to each axis.
            0: {title: 'Candidate'},
            1: {title: 'Voters'}
          }
        };

        function drawMaterialChart() {
          var materialChart = new google.charts.Bar(chartDiv);
          materialChart.draw(data, google.charts.Bar.convertOptions(materialOptions));
          button.innerText = 'Change to Classic';
          button.onclick = drawClassicChart;
        }

        function drawClassicChart() {
          var classicChart = new google.visualization.ColumnChart(chartDiv);
          classicChart.draw(data, classicOptions);
          button.innerText = 'Change to Material';
          button.onclick = drawMaterialChart;
        }

        drawMaterialChart();
    };
    </script>
	<script>
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
    // Hide dropdown if clicked outside
    $(document).on('click', function (e) {
        if (!$(e.target).closest('.form-input').length) {
            $('#searchResults').hide();
        }
    });

	</script>
</body>
</html>