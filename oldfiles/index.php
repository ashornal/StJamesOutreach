<?php
	/* Team AZAP
	 * Alex, Zach, Antonio, Pavel
	 * http://azap.greenrivertech.net/index.php 
	 * View and sort existing guests */
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
		<title>Home Page</title>
	</head>
	<body>
		<?php
			include "header.php"; // nav bar
		?>
		<div class="container">
			<div class="form-group col-14 has-warning" id="zipLabel">
				<label class="form-control-label">Zip Code:
				<input class="form-control" type="text" id="zipcode" name="zipcode" maxlength="5"></label>
			</div>
			<div class="btn-toolbar">
				<div class="btn-group mb-2">
					<button type="button" class="btn btn-primary" id="guestbtn">Guest Info</button>
					<button type="button" class="btn btn-primary" id="needbtn">Needs</button>
					<button type="button" class="btn btn-primary" id="incomebtn">Income</button>
					<button type="button" class="btn btn-primary" id="addressbtn">Address</button>
					<button type="button" class="btn btn-primary" id="housebtn">Household</button>
				</div>
			</div>
		</div> <!-- Table selection and zip checker -->
	
		<div class="container" id="info">
			<h3 class="text-muted">Guest Info</h3>
			<table id="guestInfo" class="display">
				<thead>
					<tr>
						<th>ID</th>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Birthdate</th>
						<th>Phone</th>
						<th>Visit Date</th>
						<th>View / Edit Form</th>
					</tr>
				</thead>
				<tbody>
					<?php
						//Define the SELECT query
						$sql = "SELECT * FROM Guests";
						//Send the query to the database
						$result = @mysqli_query($cnxn, $sql);
						//Process the rows
						while ($row = mysqli_fetch_assoc($result))
						{
							$id = $row['ClientId'];
							$first = $row['first'];
							$last = $row['last'];
							$birthdate = $row['birthdate'];
							$phone = $row['phone'];
							
							//Build the URL to edit the current guest
							$url = "newGuest.php?ClientId=$id";
							$url2 = "index.php?ClientId=$id";
							
							// select matching guest from Needs table
							$sql2 = "SELECT * FROM Needs WHERE Guests_ClientId = $id ";
							$result2 = @mysqli_query($cnxn, $sql2);
							while ($row = mysqli_fetch_assoc($result2))
							{
								$visitDate = $row['visitDate'];
							}
							// print table rows
							echo "<tr><td>$id</td><td>$first</td><td>$last</td><td>$birthdate</td><td>$phone</td><td>$visitDate</td><td>
									<a href='$url' class=\"clickForm\">View/Edit</a>
									</td></tr>";
									
							// select all tables together for clicking the edit button
							$sql = "SELECT * FROM Guests, Household, Needs
									WHERE Guests.ClientId = $id
									AND Household.Guests_ClientId = $id
									AND Needs.Guests_ClientId = $id;";
							
							$guest_result = mysqli_query($cnxn,$sql);
							
							while($guest_row = mysqli_fetch_assoc($guest_result))
							{
								$guest = $guest_row['first'];
							}		  
						}
					?>
				</tbody>
				<tfoot>
					<tr>
						<th>ID</th>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Birthdate</th>
						<th>Phone</th>
						<th>Visit Date</th>
						<th>View / Edit Form</th>
					</tr>
				</tfoot>
			</table> <!-- Main Table -->
		</div> <!-- Container -->
		
		<div class="container" id="needs">
			<h3 class="text-muted">Guest Needs</h3>
			<table id="needInfo" class="display">
				<thead>
					<tr>
						<th>ID</th>
						<th>First</th>
						<th>Last</th>
						<th>Resource</th>
						<th>Amount</th>
						<th>Visit Date</th>
					</tr>
				</thead>
				<tbody>
					<?php
						//Define the SELECT query
						$sql = "SELECT * FROM Needs ORDER BY visitDate";
						//Send the query to the database
						$result = @mysqli_query($cnxn, $sql);
						//Process the rows
						while ($row = mysqli_fetch_assoc($result))
						{
							$id = $row['Guests_ClientId'];
							$resource = $row['resource'];
							$amount = $row['amount'];
							$visitDate = $row['visitDate'];
							// get another select query
							$sql2 = "SELECT * FROM Guests WHERE ClientId = $id ";
							$result2 = @mysqli_query($cnxn, $sql2);
							while ($row = mysqli_fetch_assoc($result2))
							{
							  $first = $row['first'];
							  $last = $row['last'];
							}
							// print table rows
							echo "<tr><td>$id</td><td>$first</td><td>$last</td><td>$resource</td><td>$amount</td><td>$visitDate</td></tr>";
						}
					?>
				</tbody>
				<tfoot>
					<tr>
						<th>ID</th>
						<th>First</th>
						<th>Last</th>
						<th>Resource</th>
						<th>Amount</th>
						<th>Visit Date</th>
					</tr>
				</tfoot>
			</table> <!-- Need Table -->
		</div> <!-- Container -->
		
		<div class="container" id="income">
			<h3 class="text-muted">Guest Income</h3>
			<table id="incomeInfo" class="display">
				<thead>
					<tr>
						<th>ID</th>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Monthly Income</th>
						<th>Monthly Rent</th>
						<th>Food Stamps</th>
						<th>Additional Support</th>
					</tr>
				</thead>
				<tbody>
					<?php
						//Define the SELECT query
						$sql = "SELECT * FROM Guests ";
						//Send the query to the database
						$result = @mysqli_query($cnxn, $sql);
						//Process the rows
						while ($row = mysqli_fetch_assoc($result))
						{
							$id = $row['ClientId'];
							$first = $row['first'];
							$last = $row['last'];
							$income = $row['income'];
							$rent = $row['rent'];
							$foodstamp = $row['foodStamp'];
							$additional = $row['addSupport'];
							// print table rows
							echo "<tr><td>$id</td><td>$first</td><td>$last</td><td>$income</td><td>$rent</td><td>$foodstamp</td><td>$additional</td></tr>";
						}
					?>
				</tbody>
				<tfoot>
					<tr>
						<th>ID</th>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Monthly Income</th>
						<th>Monthly Rent</th>
						<th>Food Stamps</th>
						<th>Additional Support</th>
					</tr>
				</tfoot>
			</table> <!-- Income Table -->
		</div> <!-- Container -->
		<div class="container" id="address">
			<h3 class="text-muted">Guest Addresses</h3>
			<table id="addressInfo" class="display">
				<thead>
					<tr>
						<th>ID</th>
						<th>First Name</th>
						<th>Last Name</th>
						<th>City</th>
						<th>Street</th>
						<th>Zip</th>
						<th>Email</th>
					</tr>
				</thead>
				<tbody>
					<?php
						//Define the SELECT query
						$sql = "SELECT * FROM Guests ";
						//Send the query to the database
						$result = @mysqli_query($cnxn, $sql);
						//Process the rows
						while ($row = mysqli_fetch_assoc($result))
						{
							$id = $row['ClientId'];
							$first = $row['first'];
							$last = $row['last'];
							$city = $row['city'];
							$street = $row['street'];
							$zip = $row['zip'];
							$email = $row['email'];
							// print table rows
							echo "<tr><td>$id</td><td>$first</td><td>$last</td><td>$city</td><td>$street</td><td>$zip</td><td>$email</td></tr>";
						}
					?>
				</tbody>
				<tfoot>
					<tr>
						<th>ID</th>
						<th>First Name</th>
						<th>Last Name</th>
						<th>City</th>
						<th>Street</th>
						<th>Zip</th>
						<th>Email</th>
					</tr>
				</tfoot>
			</table> <!-- Address Table -->
		</div> <!-- Container -->
		<div class="container" id="household">
			<h3 class="text-muted">Household Info</h3>
			<table id="houseInfo" class="display">
				<thead>
					<tr>
						<th>ID</th>
						<th>First</th>
						<th>Last</th>
						<th>Household Member</th>
						<th>Age</th>
						<th>Gender</th>
					</tr>
				</thead>
				<tbody>
					<?php
						//Define the SELECT query
						$sql = "SELECT * FROM Household ";
						//Send the query to the database
						$result = @mysqli_query($cnxn, $sql);
						//Process the rows
						while ($row = mysqli_fetch_assoc($result))
						{
							$id = $row['Guests_ClientId'];
							$name = $row['name'];
							$age = $row['age'];
							$gender = $row['gender'];
							// select matching guest from Guests table
							$sql2 = "SELECT * FROM Guests WHERE ClientId = $id ";
							$result2 = @mysqli_query($cnxn, $sql2);
							while ($row = mysqli_fetch_assoc($result2))
							{
								$first = $row['first'];
								$last = $row['last'];
							}
							// print table rows
							echo "<tr><td>$id</td><td>$first</td><td>$last</td><td>$name</td><td>$age</td><td>$gender</td></tr>";
						}
					?>
				</tbody>
				<tfoot>
					<tr>
						<th>ID</th>
						<th>First</th>
						<th>Last</th>
						<th>Name</th>
						<th>Age</th>
						<th>Gender</th>
					</tr>
				</tfoot>
			</table> <!-- Houshold Table -->
		</div> <!-- Container -->
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="//code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
		<script src="//cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>
		<script src="js/zipValidate.js"></script>
		<script src="js/showTables.js"></script>
		<script>
			$("#guestInfo").DataTable();
			$("#needInfo").DataTable();
			$("#incomeInfo").DataTable();
			$("#addressInfo").DataTable();
			$("#houseInfo").DataTable();
		</script>
	</body>
</html>
