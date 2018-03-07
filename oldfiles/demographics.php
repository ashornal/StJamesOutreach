<?php
	/* Team AZAP
	 * Alex, Zach, Antonio, Pavel
	 * http://azap.greenrivertech.net/demographics.php
	 * View info about guest demographics */

	session_start();
	//Turn on error reporting
	//ini_set("display_errors",1);
	//error_reporting(E_ALL);
	//Connect to database
	require '/home/azap/db.php';//absolute path
	
	// redirect to login page if not logged in
	if (!isset($_SESSION['username']))
    {
		header ('location: login/index.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Demographic</title>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
		<link type="text/css" rel="stylesheet" href="css/index.css">
		<link type="text/css" rel="stylesheet" href="css/demographics.css">
		
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

		<!-- Ethnicity -->
		<?php
			$ethnicity = "";
			
			//Define the SELECT query
			$sql = "select 'White' as Label, count(ethnicity) as Value from Guests 
					where ethnicity= 'white'
					union (
					select 'Black' as Label, count(ethnicity) as Value from Guests 
					where ethnicity= 'black' )
					union (
					select 'Histpanic' as Label, count(ethnicity) as Value from Guests 
					where ethnicity= 'hispanic' )
					union (
					select 'Native' as Label, count(ethnicity) as Value from Guests 
					where ethnicity= 'native' )
					union (
					select 'Asian' as Label, count(ethnicity) as Value from Guests 
					where ethnicity= 'asian' )
					union (
					select 'Pacific' as Label, count(ethnicity) as Value from Guests 
					where ethnicity= 'pacific' )
					union (
					select 'Eskimo' as Label, count(ethnicity) as Value from Guests 
					where ethnicity= 'eskimo' )
					union (
					select 'Mixed' as Label, count(ethnicity) as Value from Guests 
					where ethnicity= 'mixed' )
					union (
					select 'Other' as Label, count(ethnicity) as Value from Guests 
					where ethnicity= 'other' )";
			//Send the query to the database
			$result = @mysqli_query($cnxn, $sql);
			
			$ethnicity_arr = [];
			
			//Process the rows
			while ($row = mysqli_fetch_assoc($result))
			{
				$ethnicity_arr[$row['Label']] = $row['Value'];
			}
			
			//print_r($ethnicity_arr);
		?>
		
		<script type="text/javascript">
			// load chart package
			google.charts.load("current", {packages:["corechart"]});
			google.charts.setOnLoadCallback(drawChart);
			// create ethnicity pie chart
			function drawChart() {
				// send to data table
				var data = google.visualization.arrayToDataTable([
					['Ethnicity', 'Number of guests'],
					
					<?php
						foreach ($ethnicity_arr as $ethnicity => $total) {
							// Add a new array to the data array with the ethnicity / total
							echo "['" . $ethnicity . "', " . $total . "],";
						}
					?>
				
				]);
			  
				// customize chart
				var options = {
				  title: 'Ethnicity',
				  is3D: true,
				};
				
				// draw chart at id
				var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
				chart.draw(data, options);
			}
		</script>
		
		<!-- Gender -->
		<?php
			$gender = "";
			
			//Define the SELECT query
			$sql = "select 'Male' as Label, count(gender) as Value from Household where gender= 'male'
					union (
					  select 'Female' as Label, count(gender) as Value from Household where gender= 'female' )
					union (
					  select 'Other' as Label, count(gender) as Value from Household where gender= 'other' )";
			//Send the query to the database
			$result = @mysqli_query($cnxn, $sql);
			
			$gender_arr = [];
			
			//Process the rows
			while ($row = mysqli_fetch_assoc($result))
			{
				$gender_arr[$row['Label']] = $row['Value'];
			}
			
			//print_r($gender_arr);
		?>
		
		<script type="text/javascript">
			// load chart package
			google.charts.load("current", {packages:["corechart"]});
			google.charts.setOnLoadCallback(drawChart);
			// create gender pie chart
			function drawChart() {
				// send to data table
				var data = google.visualization.arrayToDataTable([
					['Gender', 'Number of guests'],
				
					<?php
						foreach ($gender_arr as $gender => $total) {
							// Add a new array to the data array with the gender / total
							echo "['" . $gender . "', " . $total . "],";
						}
					?>
				]);
				// customize chart
				var options = {
					title: 'Gender',
					is3D: true,
				};
	  
				// draw chart to id
				var chart = new google.visualization.PieChart(document.getElementById('piechart_3d2'));
				chart.draw(data, options);
			}
		</script>
		
		<!-- Zips -->
		<?php
			$zips = "";
			
			//Define the SELECT query
			$sql = "select '98058' as Label, count(zip) as Value from Guests 
					where zip= '98058'
					union (
					select '98042' as Label, count(zip) as Value from Guests 
					where zip= '98042' )
					union (
					select '98032' as Label, count(zip) as Value from Guests 
					where zip= '98032' )
					union (
					select '98031' as Label, count(zip) as Value from Guests 
					where zip= '98031' )
					union (
					select '98030' as Label, count(zip) as Value from Guests 
					where zip= '98030' )
					union (
					select 'Other' as Label, count(zip) as Value from Guests 
					where zip NOT IN ('98030', '98058', '98042', '98032', '98031') )
					union (
					select 'Homeless' as Label, count(homeless) as Value from Guests 
					where homeless= '1' )";
			//Send the query to the database
			$result = @mysqli_query($cnxn, $sql);
			
			$zips_arr = [];
			
			//Process the rows
			while ($row = mysqli_fetch_assoc($result))
			{
			  $zips_arr[$row['Label']] = $row['Value'];
			}
		?>
		
		<script type="text/javascript">
			// load chart package
			google.charts.load("current", {packages:["corechart"]});
			google.charts.setOnLoadCallback(drawChart);
			// create zip code pie chart
			function drawChart() {
				// send to data table
				var data = google.visualization.arrayToDataTable([
				  ['Zip Code', 'Number of guests'],

				  <?php
					foreach ($zips_arr as $zips => $total) {
						// Add a new array to the data array with the ethnicity / total
						echo "['" . $zips . "', " . $total . "],";
					}
				  ?>
				  
				]);
			
				// customize chart
				var options = {
				  title: 'Zip Codes',
				  is3D: true,
				};
				
				// draw chart at id
				var chart = new google.visualization.PieChart(document.getElementById('piechart_3d3'));
				chart.draw(data, options);
			}
		</script>
		  
		<!--Disabilities -->
		<?php
			$disabilities = "";
			
			//Define the SELECT query
			$sql = "select 'Mental' as Label, count(mental) as Value from Guests 
					where mental= '1'
					union (
					select 'Physical' as Label, count(physical) as Value from Guests 
					where physical= '1' )
					union (
					select 'Both' as Label, count(physical) as Value from Guests 
					where physical= '1' AND mental = '1' )
					union (
					select 'Neither' as Label, count(physical) as Value from Guests 
					where physical= '0' AND mental = '0' )";
			//Send the query to the database
			$result = @mysqli_query($cnxn, $sql);
			
			$disabilities_arr = [];
			
			//Process the rows
			while ($row = mysqli_fetch_assoc($result))
			{
				$disabilities_arr[$row['Label']] = $row['Value'];
			}
		?>
		<script type="text/javascript">
			// load chart package
			google.charts.load("current", {packages:["corechart"]});
			google.charts.setOnLoadCallback(drawChart);
			// create disability pie chart
			function drawChart() {
				// send to data table
				var data = google.visualization.arrayToDataTable([
					['Disability', 'Number of guests'],
					
					<?php
					foreach ($disabilities_arr as $disabilities => $total) {
						// Add a new array to the data array with the ethnicity / total
						echo "['" . $disabilities . "', " . $total . "],";
					}
					?>

				]);
				
				// customize chart
				var options = {
					title: 'Disabilities',
					is3D: true,
				};
				
				// draw chart at id
				var chart = new google.visualization.PieChart(document.getElementById('piechart_3d4'));
				chart.draw(data, options);
			}
		</script>
		  
		<!-- Veterans-->
		<?php
			$veterans = "";
			
			//Define the SELECT query
			$sql = "select 'Veteran' as Label, count(veteran) as Value from Guests 
					where veteran= '1'
					union (
					select 'Non-veteran' as Label, count(veteran) as Value from Guests 
					where veteran= '0' )";
			//Send the query to the database
			$result = @mysqli_query($cnxn, $sql);
			
			$veterans_arr = [];
			
			//Process the rows
			while ($row = mysqli_fetch_assoc($result))
			{
				$veterans_arr[$row['Label']] = $row['Value'];
			}
		
		?>
		
		<script type="text/javascript">
			// load chart package
			google.charts.load("current", {packages:["corechart"]});
			google.charts.setOnLoadCallback(drawChart);
			// create veteran pie chart
			function drawChart() {
				// send to data table
				var data = google.visualization.arrayToDataTable([
					['Veteran status', 'Number of guests'],
					
					<?php
						foreach ($veterans_arr as $veterans => $total) {
							// Add a new array to the data array with the ethnicity / total
							echo "['" . $veterans . "', " . $total . "],";
						}
					?>
					
				]);
				
				// customize options
				var options = {
					title: 'Veterans',
					is3D: true,
				};
	  
				// draw chart at id
				var chart = new google.visualization.PieChart(document.getElementById('piechart_3d5'));
				chart.draw(data, options);
			}
		</script>
	</head>
	
	<body>
		<?php
			include "header.php"; // nav bar file
		?>
		<div class='row'>
			<div class="col-6">
				<!--Ethnicity -->
				<div id="piechart_3d"></div>
			</div>
			<div class="col-6">
				<!-- Gender-->
				<div id="piechart_3d2"></div>
			</div>
		</div>
		<div class='row'>
			<div class="col-6">
				<!-- Zips -->
				<div id="piechart_3d3"></div>
			</div>
			<div class="col-6">
				<!-- Disabilities -->
				<div id="piechart_3d4"></div>
			</div>
		</div>
		<div class='row'>
			<div class="col-6">
				<!-- Veterans -->
				<div id="piechart_3d5"></div>
			</div>
		</div>
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
		<script src="js/zipValidate.js"></script>
	</body>
</html>