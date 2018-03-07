<?php
	/* Team AZAP
	 * Alex, Zach, Antonio, Pavel
	 * http://azap.greenrivertech.net/reports.php
	 * Keep track of money spent for each resource, vouchers, and checks */

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
	  <!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
		<link rel="stylesheet" href="//cdn.datatables.net/1.10.4/css/jquery.dataTables.css">
		<link type="text/css" rel="stylesheet" href="css/index.css">
		<link type="text/css" rel="stylesheet" href="css/reports.css"> 
		<title>Salary Data</title>
    
	</head>
	<body>
		<?php
			include "header.php";
		?>
		<!-- Main content area -->
    
		<?php
			// initialize variable
			$start = date('Y-m-01'); // first of current month
			$end = date('Y-m-d');
			
			// set to new value when submitting
			if (isset($_POST['submit']))
			{
				if (!empty($_POST['start']))
				{
					$start = $_POST['start'];
				}
				if (!empty($_POST['end']))
				{
					$end = $_POST['end'];
				}
			}
		?>
		
		<div class="container">
			<h3 class="text-muted">Select Dates</h3>
			<form action="#" method="post">
				<fieldset class="form-group">
					<div class="row">
						<div class="form-group col-3">
							<label class="form-control-label">Start Date:</b></label><input type="date" class="form-control" id="start" name="start" value="<?php echo $start; ?>"required>
						</div>
						<div class="form-group col-3">
							<label class="form-control-label">End Date:</b></label><input type="date" class="form-control" id="end" name="end" value="<?php echo $end ?>" required>
						</div>
					</div>
				</fieldset>
			
				<input class="form-control-label" id="submit" name="submit" type="submit" value="Calculate &raquo;">
			</form> <!-- Date Selection -->

			<h3 class="text-muted">Reports Data</h3>
			<table id="resources">
				<thead>
					<tr>
						<th>Resource</th>
						<th>Number Given</th>
						<th>Amount Given</th>
					</tr>
				</thead>
				<tbody>
					<?php
						//Define the SELECT query, add up thrift shop totals
						$sql = "SELECT COUNT(amount), SUM(amount) FROM Needs
								WHERE visitDate BETWEEN '$start' AND '$end'
								AND resource = 'thriftshop'";
						//Send the query to the database
						$result = @mysqli_query($cnxn, $sql);		  
						//Process the rows
						while ($row = mysqli_fetch_assoc($result))
						{
							$thriftNum = $row['COUNT(amount)'];
							$thiftTot = $row['SUM(amount)'];
						}
						
						//Define the SELECT query, add up gas totals
						$sql = "SELECT COUNT(amount), SUM(amount) FROM Needs
								WHERE visitDate BETWEEN '$start' AND '$end'
								AND resource = 'gas'";
						//Send the query to the database
						$result = @mysqli_query($cnxn, $sql);		  
						//Process the rows
						while ($row = mysqli_fetch_assoc($result))
						{
							$gasNum = $row['COUNT(amount)'];
							$gasTot = $row['SUM(amount)'];
						}
						
						//Define the SELECT query, add up water bill totals
						$sql = "SELECT COUNT(amount), SUM(amount) FROM Needs
								WHERE visitDate BETWEEN '$start' AND '$end'
								AND resource = 'waterbill'";
						//Send the query to the database
						$result = @mysqli_query($cnxn, $sql);		  
						//Process the rows
						while ($row = mysqli_fetch_assoc($result))
						{
							$waterNum = $row['COUNT(amount)'];
							$waterTot = $row['SUM(amount)'];
						}
						
						//Define the SELECT query, add up energy bill totals
						$sql = "SELECT COUNT(amount), SUM(amount) FROM Needs
								WHERE visitDate BETWEEN '$start' AND '$end'
								AND resource = 'energybill'";
						//Send the query to the database
						$result = @mysqli_query($cnxn, $sql);		  
						//Process the rows
						while ($row = mysqli_fetch_assoc($result))
						{
							$energyNum = $row['COUNT(amount)'];
							$energyTot = $row['SUM(amount)'];
						}
						
						//Define the SELECT query, add up food totals
						$sql = "SELECT COUNT(amount), SUM(amount) FROM Needs
								WHERE visitDate BETWEEN '$start' AND '$end'
								AND resource = 'food'";
						//Send the query to the database
						$result = @mysqli_query($cnxn, $sql);		  
						//Process the rows
						while ($row = mysqli_fetch_assoc($result))
						{
							$foodNum = $row['COUNT(amount)'];
							$foodTot = $row['SUM(amount)'];
						}
						
						//Define the SELECT query, add up dol totals
						$sql = "SELECT COUNT(amount), SUM(amount) FROM Needs
								WHERE visitDate BETWEEN '$start' AND '$end'
								AND resource = 'dol'";
						//Send the query to the database
						$result = @mysqli_query($cnxn, $sql);		  
						//Process the rows
						while ($row = mysqli_fetch_assoc($result))
						{
							$dolNum = $row['COUNT(amount)'];
							$dolTot = $row['SUM(amount)'];
						}
						
						//Define the SELECT query, add up other totals
						$sql = "SELECT COUNT(amount), SUM(amount) FROM Needs
								WHERE visitDate BETWEEN '$start' AND '$end'
								AND resource = 'other'";
						//Send the query to the database
						$result = @mysqli_query($cnxn, $sql);		  
						//Process the rows
						while ($row = mysqli_fetch_assoc($result))
						{
							$otherNum = $row['COUNT(amount)'];
							$otherTot = $row['SUM(amount)'];
						}
						
						//Define the SELECT query
						$sql = "SELECT COUNT(amount), SUM(amount) FROM Needs
								WHERE visitDate BETWEEN '$start' AND '$end'";
						//Send the query to the database
						$result = @mysqli_query($cnxn, $sql);		  
						//Process the rows
						while ($row = mysqli_fetch_assoc($result))
						{
							$number = $row['COUNT(amount)'];
							$total = $row['SUM(amount)'];
						}
						
						// print out the results
						echo "<tr class='odd'><td>Thrift Shop</td><td>$thriftNum</td><td>$thiftTot</td></tr>";
						echo "<tr><td>Gas</td><td>$gasNum</td><td>$gasTot</td></tr>";
						echo "<tr class='odd'><td>Water Bill</td><td>$waterNum</td><td>$waterTot</td></tr>";
						echo "<tr><td>Energy Bill</td><td>$energyNum</td><td>$energyTot</td></tr>";
						echo "<tr class='odd'><td>Food</td><td>$foodNum</td><td>$foodTot</td></tr>";
						echo "<tr><td>Dept of Lisencing</td><td>$dolNum</td><td>$dolTot</td></tr>";
						echo "<tr class='odd'><td>Other</td><td>$otherNum</td><td>$otherTot</td></tr>";
						echo "<tr><td>Total</td><td>$number</td><td>$total</td></tr>";
					?>
				</tbody>
			</table> <!-- Reports Table -->
		</div> <!-- container -->
		
		<div class="container" id="voucher">
			<h3 class="text-muted">Vouchers/ Checks</h3>
			<table id="vouchers" class="display">
				<thead>
					<tr>
						<th>First</th>
						<th>Last</th>
						<th>Voucher</th>
						<th>Check</th>
						<th>Resource</th>
						<th>Amount</th>
						<th>Visit Date</th>
					</tr>
				</thead>
				<tbody>
					<?php
						//Define the SELECT query
						$sql = "SELECT * FROM Needs";
						//Send the query to the database
						$result = @mysqli_query($cnxn, $sql);
						//Process the rows
						while ($row = mysqli_fetch_assoc($result))
						{
							// don't need to print out if voucher and check fields are empty
							if(!($row['voucher'] == "" && $row['checkNum'] == ""))
							{
								$id = $row['Guests_ClientId'];
								$voucher = $row['voucher'];
								$check = $row['checkNum'];
								$resource = $row['resource'];
								$amount = $row['amount'];
								$visitDate = $row['visitDate'];
								// select name of guest based on matching voucher
								$sql2 = "SELECT * FROM Guests WHERE ClientId = $id ";
								
								$result2 = @mysqli_query($cnxn, $sql2);
								while ($row = mysqli_fetch_assoc($result2))
								{
									$first = $row['first'];
									$last = $row['last'];
								}
								// print table rows
								echo "<tr><td>$first</td><td>$last</td><td>$voucher</td><td>$check</td><td>$resource</td><td>$amount</td><td>$visitDate</td></tr>";
							}
						}
					?>
				</tbody>
				<tfoot>
					<tr>
					  <th>First</th>
						<th>Last</th>
						<th>Voucher</th>
						<th>Check</th>
						<th>Resource</th>
						<th>Amount</th>
						<th>Visit Date</th>
					</tr>
				</tfoot>
			</table>
		</div>
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="//code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
		<script src="//cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script> 
		<script>
			$("#vouchers").DataTable();  
		</script>
	</body>
</html>