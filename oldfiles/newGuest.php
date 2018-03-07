<?php
	/* Team AZAP
	 * Alex, Zach, Antonio, Pavel
	 * http://azap.greenrivertech.net/newGuest.php
	 * Fill out a guest form and send to the database, or edit an existing form */

	 session_start();
	// error reporting
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	//connect to Database
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
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
		<link type="text/css" rel="stylesheet" href="css/index.css">
		<link type="text/css" rel="stylesheet" href="css/newGuest.css">    
		<title>Guest Form</title>
	</head>
	<body>
		<?php
			include "header.php"; // navbar file
			$edit = isset($_GET['ClientId']);
			if(isset($_POST))
			{
				//print_r($_POST);
				
				// initialze variables
				$isValid = true;
				$first = $last = $birthdate = $phone = $email = $ethnicity = $street = $city = $zip = $mental = $physical =
				$veteran = $homeless = $rent = $income = $foodStamp = $addSupport = $license = $pse = $selected =
				$water = $members = $notes = $voucher = $checkNum = $amount = $resource = $male = $female = $other =
				$selected2 = $thrift = $gas = $food = $dol = $waterbill = $energybill = $otherResource = $vouchernum = "";
				$visitDate = date("Y-m-d");
				
				if($edit) // if editing guest from index
				{
					//Get the ClientId
					$id = mysqli_real_escape_string($cnxn, $_GET['ClientId']);
					// select statement in database
					$sql = "SELECT * FROM Guests, Household, Needs
							WHERE Guests.ClientId = $id
							AND Household.Guests_ClientId = $id
							AND Needs.Guests_ClientId = $id;";
					$result = mysqli_query($cnxn, $sql);
					
					$row = mysqli_fetch_assoc($result); // process rows
					// save rows to variables
					$first = $row['first'];
					$last = $row['last'];
					$birthdate = $row['birthdate'];
					$phone = $row['phone'];
					$email = $row['email'];
					$ethnicity = $row['ethnicity'];
					$street = $row['street'];
					$city = $row['city'];
					$zip = $row['zip'];
					$license = $row['license'];
					$pse = $row['pse'];
					$water = $row['water'];
					$income = $row['income'];
					$rent = $row['rent'];
					$foodStamp = $row['foodStamp'];
					$addSupport = $row['addSupport'];
					$mental = $row['mental'];
					$physical = $row['physical'];
					$veteran = $row['veteran'];
					$homeless = $row['homeless'];
					$notes = $row['notes'];
					$members = $row['members'];
					$vouchernum = $row['vouchernum'];
					
					// select statement for household members
					$sql2 = "SELECT * FROM Household WHERE Guests_ClientId = $id";
					$result2 = mysqli_query($cnxn, $sql);
					// create array to hold data for each household member
					$nameArr = array();
					$ageArr = array();
					$genderArr = array();
					while ($row = mysqli_fetch_assoc($result2)) // process rows
					{
						array_push($nameArr, $row['name']);
						array_push($ageArr, $row['age']);
						array_push($genderArr, $row['gender']);
					}
					// keeps array length at 10
					for($i = 0; $i < 10 - $members; $i++)
					{
						array_push($nameArr, "");
						array_push($ageArr, "");
						array_push($genderArr, "");
					}
					
					// select statement for different vouchers
					$sql3 = "SELECT * FROM Needs WHERE Guests_ClientId = $id";
					$result3 = mysqli_query($cnxn, $sql);
					// create array to hold data for each household member
					$voucherArr = array();
					$checkNumArr = array();
					$amountArr = array();
					$resourceArr = array();
					$visitDateArr = array();
					while ($row = mysqli_fetch_assoc($result3)) // process rows
					{
						array_push($voucherArr, $row['voucher']);
						array_push($checkNumArr, $row['checkNum']);
						array_push($amountArr, $row['amount']);
						array_push($resourceArr, $row['resource']);
						array_push($visitDateArr, $row['visitDate']);
					}
					// keeps array length at 5
					for($i = 0; $i < 5 - $vouchernum; $i++)
					{
						array_push($voucherArr, "");
						array_push($checkNumArr, "");
						array_push($amountArr, "");
						array_push($resourceArr, "");
						array_push($visitDateArr, "");
					}
				}
				// Form has been submitted
				if (isset($_POST['submit']))
				{
					$isValid = true;
					// Validate first name
					if (!empty($_POST['first']))
					{
						$first = $_POST['first'];
					}
					else
					{
						echo '<p>Please enter a First Name.</p>';
						$isValid = false;
					}
					// Validate last name
					if (!empty($_POST['last']))
					{
						$last = $_POST['last'];
					}
					else
					{
						echo '<p>Please enter a Last Name.</p>';
						$isValid = false;
					}
					// Validate birthdate
					if (!empty($_POST['birthdate']))
					{
						$birthdate = $_POST['birthdate'];
					}
					else
					{
						echo '<p>Please enter a birthdate.</p>';
						$isValid = false;
					} 
					// vallidate phone
					if (empty($_POST['phone'])) // doesn't validate if empty
					{
						$phone = $_POST['phone'];
					}
					else if ((strlen($_POST['phone']) == 10) && (is_numeric($_POST['phone'])))
					{
						$phone = $_POST['phone'];
					}
					else
					{
						echo '<p>Please enter a valid phone number. (numbers only, 10 digits)</p>';
						$isValid = false;
					}
					// don't need validation
					$ethnicity = $_POST['ethnicity'];
					$street = $_POST['street'];
					$city = $_POST['city'];
					$license = $_POST['license'];
					$notes = $_POST['notes'];
					$pse = $_POST['pse'];
					$water = $_POST['water'];
					$members = $_POST['members'];
					$vouchernum = $_POST['vouchernum'];
					// validate zip code
					if (empty($_POST['zip'])) // doesn't validate if empty
					{
						$zip = $_POST['zip'];
					}
					else if ((strlen($_POST['zip']) == 5) && (is_numeric($_POST['zip'])))
					{
						$zip = $_POST['zip'];
					}
					else
					{
						echo '<p>Please enter a valid zip code. (numbers only, 5 digits)</p>';
						$isValid = false;
					}
					$email = $_POST['email'];
					// validate monthly income
					if (empty($_POST['income']) || is_numeric($_POST['income']))
					{
						$income = $_POST['income'];
					}
					else
					{
						echo '<p>Please enter a numeric income amount.</p>';
						$isValid = false;
					}
					// validate monthly rent
					if (empty($_POST['rent']) || is_numeric($_POST['rent']))
					{
						$rent = $_POST['rent'];
					}
					else
					{
						echo '<p>Please enter a numeric rent amount.</p>';
						$isValid = false;
					}
					// validate monthly food stamps
					if (empty($_POST['foodStamp']) || is_numeric($_POST['foodStamp']))
					{
						$foodStamp = $_POST['foodStamp'];
					}
					else
					{
						echo '<p>Please enter a numeric food stamp amount.</p>';
						$isValid = false;
					}
					if(isset($_POST['gender1']))
					{
						$gender = $_POST['gender1'];
					}
					else
					{
						echo '<p>Gender is required.</p>';
						$isValid = false;
					}
					// validate additional monthly addSupport
					if (empty($_POST['addSupport']) || is_numeric($_POST['addSupport']))
					{
						$addSupport = $_POST['addSupport'];
					}
					else
					{
						echo '<p>Please enter a numeric value for additional addSupport.</p>';
						$isValid = false;
					}
					// validate amount given
					if (empty($_POST['amount1']) || is_numeric($_POST['amount1']))
					{
						$amount = $_POST['amount1'];
					}
					else
					{
						echo '<p>Please enter a numeric value for amount.</p>';
						$isValid = false;
					}
				}
				//Display summary if form is valid
				if ($isValid && isset($_POST['submit']))
				{
					//Escape the data and send to database
					$first = mysqli_real_escape_string($cnxn, $first);
					$last = mysqli_real_escape_string($cnxn, $last);
					$birthdate = mysqli_real_escape_string($cnxn, $birthdate);
					$phone = mysqli_real_escape_string($cnxn, $phone);
					$email = mysqli_real_escape_string($cnxn, $email);
					$ethnicity = mysqli_real_escape_string($cnxn, $ethnicity);
					$street = mysqli_real_escape_string($cnxn, $street);
					$city = mysqli_real_escape_string($cnxn, $city);
					$zip = mysqli_real_escape_string($cnxn, $zip);
					$license = mysqli_real_escape_string($cnxn, $license);
					$pse = mysqli_real_escape_string($cnxn, $pse);
					$water = mysqli_real_escape_string($cnxn, $water);
					$income = mysqli_real_escape_string($cnxn, $income);
					$rent = mysqli_real_escape_string($cnxn, $rent);
					$foodStamp = mysqli_real_escape_string($cnxn, $foodStamp);
					$addSupport = mysqli_real_escape_string($cnxn, $addSupport);
					if(isset($_POST['mental'])) // 1 if true, 0 if false
					{
						$mental = mysqli_real_escape_string($cnxn, 1);
					}
					else
					{
						$mental = mysqli_real_escape_string($cnxn, 0);
					}
					if(isset($_POST['physical']))
					{
						$physical = mysqli_real_escape_string($cnxn, 1);
					}
					else
					{
						$physical = mysqli_real_escape_string($cnxn, 0);
					}
					if(isset($_POST['veteran']))
					{
						$veteran = mysqli_real_escape_string($cnxn, 1);
					}
					else
					{
						$veteran = mysqli_real_escape_string($cnxn, 0);
					}
					if(isset($_POST['homeless']))
					{
						$homeless = mysqli_real_escape_string($cnxn, 1);
					}
					else
					{
						$homeless = mysqli_real_escape_string($cnxn, 0);
					}
					$notes = mysqli_real_escape_string($cnxn, $notes);
					$resource = mysqli_real_escape_string($cnxn, $resource);
					$visitDate = mysqli_real_escape_string($cnxn, $visitDate);
					$amount = mysqli_real_escape_string($cnxn, $amount);
					$voucher = mysqli_real_escape_string($cnxn, $voucher);
					$checkNum = mysqli_real_escape_string($cnxn, $checkNum);
					$members = mysqli_real_escape_string($cnxn, $members);
					$vouchernum = mysqli_real_escape_string($cnxn, $vouchernum);
					
					if($edit) // if editing delet current guest before replacing
					{
						//$id = mysqli_real_escape_string($cnxn, $_GET['ClientId']);
						//Define the query
						$sql ="DELETE FROM Household
								  WHERE Guests_ClientId= $id";
						mysqli_query($cnxn, $sql);
						$sql ="DELETE FROM Needs
								  WHERE Guests_ClientId= $id";
						mysqli_query($cnxn, $sql);
						$sql ="DELETE FROM Guests
								  WHERE ClientId= $id";
						mysqli_query($cnxn, $sql);
						// insert new info
						$sql= "INSERT INTO Guests (ClientId,first, last, birthdate, phone, email, ethnicity, street, city, zip, license, pse, water, income, rent, foodStamp, addSupport, mental, physical, veteran, homeless, members, vouchernum, notes)
						VALUES ('$id','$first', '$last','$birthdate','$phone','$email', '$ethnicity', '$street','$city','$zip','$license','$pse','$water','$income','$rent', '$foodStamp','$addSupport','$mental','$physical','$veteran', '$homeless', '$members', '$vouchernum', '$notes')";
					}
					else
					{ // id not needed
						$sql= "INSERT INTO Guests (first, last, birthdate, phone, email, ethnicity, street, city, zip, license, pse, water, income, rent, foodStamp, addSupport, mental, physical, veteran, homeless, members, vouchernum, notes)
						VALUES ('$first', '$last','$birthdate','$phone','$email', '$ethnicity', '$street','$city','$zip','$license','$pse','$water','$income','$rent', '$foodStamp','$addSupport','$mental','$physical','$veteran', '$homeless', '$members', '$vouchernum', '$notes')";
					}			  
					$result = mysqli_query($cnxn, $sql); // removed @ before my
					// Test for result
					if($result)
					{
						// get guest id of new guest
						$id = mysqli_insert_id($cnxn);
						
						for($i = 1; $i <= $vouchernum; $i++)
						{
							$vouchernum = mysqli_real_escape_string($cnxn, $_POST["vouchernum"]);
							$visitDate = mysqli_real_escape_string($cnxn, date("Y-m-d"));
							$amount = mysqli_real_escape_string($cnxn, $_POST["amount$i"]);
							$voucher = mysqli_real_escape_string($cnxn, $_POST["voucher$i"]);
							$checkNum = mysqli_real_escape_string($cnxn, $_POST["checkNum$i"]);
							$resource = mysqli_real_escape_string($cnxn, $_POST["resource$i"]);
							$sql2= "INSERT INTO Needs (resource, visitDate, amount, voucher, checkNum, Guests_ClientId)
							VALUES ('$resource', '$visitDate', '$amount', '$voucher', '$checkNum', '$id')";
							$result2 = mysqli_query($cnxn, $sql2);
						}
						
						for($i = 1; $i <= $members; $i++)
						{
							$members = mysqli_real_escape_string($cnxn, $_POST["members"]);
							$name = mysqli_real_escape_string($cnxn, $_POST["name$i"]);
							$age = mysqli_real_escape_string($cnxn, $_POST["age$i"]);
							$gender = mysqli_real_escape_string($cnxn, $_POST["gender$i"]);
							// insert into household table
							$sql3= "INSERT INTO Household (name, age, gender, Guests_ClientId)
							VALUES ('$name', '$age', '$gender', '$id')";
							$result3 = mysqli_query($cnxn, $sql3);
						}
						echo "<p id='success'>Form submitted!</p>";
					}
					else
					{
						echo "<p>Error: " . mysqli_error($cnxn) . "</p>";
					}
				}
			}
		?>
		<div class="container">
			<form action="#" method="post" id="formGuest">
				<h2>Outreach Contact Report</h2>
				<p id="obligitory"><i>* obligatory fields</i></p>
				<fieldset class="form-group">
					<legend>Guest's Information</legend>
					<div class="row">
						<div class="form-group col-8">
							<label class="form-control-label"><b>*Name:</b></label>
							<div class="row">
								<div class="form-group col-6">
									<input class="form-control" type="text" id="first" name="first" placeholder="First Name" value="<?php echo $first; ?>" required>
								</div>
								<div class="form-group col-6">
									<input class="form-control" type="text" id="last" name="last" placeholder="Last Name" value="<?php echo $last; ?>" required>
								</div>
							</div>
						</div>
						<div class="form-group col-3">
							<label class="form-control-label"><b>*Date of Birth:</b></label><input type="date" class="form-control" id="birthdate" name="birthdate" value="<?php echo $birthdate; ?>" required>
						</div>
					</div> <!-- row -->
					
					<div class="row">
						<div class="form-group col-4">
							<div class="row">
								<div class="form-group col-10">
									<label class="form-control-label">Phone:</label><input class="form-control" type="text" id="phone" name="phone" maxlength="10" placeholder="no spaces or dashes" value="<?php echo $phone; ?>">
								</div>
							</div>
						</div>
						<div class="form-group col-4">
							<label class="form-control-label">Email:</label><input class="form-control" type="email" id="email" name="email" value="<?php echo $email; ?>">
						</div>
						<div class="form-group col-3">
							<label class="form-check-label">Ethnicity:</label>
							<label class="d-block"></label>
							<select class="form-control dropdown" id="ethnicity" name="ethnicity">
								<option value="">-- select one --</option>
								<option value="white" <?php if ($ethnicity == "white") echo "selected='selected'"; ?>>White</option>
								<option value="black" <?php if ($ethnicity == "black") echo "selected='selected'"; ?>>African American</option>
								<option value="hispanic" <?php if ($ethnicity == "hispanic") echo "selected='selected'"; ?>>Hispanic or Latino</option>
								<option value="native" <?php if ($ethnicity == "indian") echo "selected='selected'"; ?>>Native American</option>
								<option value="asian" <?php if ($ethnicity == "asian") echo "selected='selected'"; ?>>Asian</option>
								<option value="pacific" <?php if ($ethnicity == "pacific") echo "selected='selected'"; ?>>Pacific Islander</option>
								<option value="eskimo" <?php if ($ethnicity == "eskimo") echo "selected='selected'"; ?>>Eskimo</option>
								<option value="mixed" <?php if ($ethnicity == "mixed") echo "selected='selected'"; ?>>Mixed</option>
								<option value="other" <?php if ($ethnicity == "other") echo "selected='selected'"; ?>>Other</option>
							</select>
						</div>
					</div> <!-- row -->
					
					<div class="row">
						<div class="form-group col-10">
							<label class="form-control-label">Address:</label>
							<div class="row">
								<div class="form-group col-5">
									<input class="form-control" type="text" id="street" name="street" placeholder="Street" value="<?php if(!empty($street)) echo $street ?>">
								</div>
								<div class="form-group col-4">
									<input class="form-control" type="text" id="city" name="city" placeholder="City" value="<?php if(!empty($city)) echo $city ?>">
								</div>
								<div class="form-group col-3">
									<input class="form-control" type="text" id="zip" name="zip" placeholder="Zip" maxlength="5" value="<?php echo $zip; ?>">
								</div>
							</div>
						</div>
					</div> <!-- row -->
					
					<div class="row">
						<div class="form-group col-3">
							<div class="form-check">
								<label class="d-block">Mental Disability:</label>
								<label class="form-check-label">
									<input class="form-check-input" type="checkbox" id='mental' name='mental' <?php if(isset($_POST['mental']) || $mental == 1) echo "checked='checked'"; ?>>
								</label>
							</div>
						</div>
						<div class="form-group col-3">
							<div class="form-check">
								<label class="d-block">Physical Disability:</label>
								<label class="form-check-label">
									<input class="form-check-input" type="checkbox" id='physical' name='physical' <?php if(isset($_POST['physical']) || $physical == 1) echo "checked='checked'"; ?>>
								</label>
							</div>
						</div>
						<div class="form-group col-3">
							<div class="form-check">
								<label class="d-block">Veteran:</label>
								<label class="form-check-label">
									<input class="form-check-input" type="checkbox" id='veteran' name='veteran' <?php if(isset($_POST['veteran']) || $veteran == 1) echo "checked='checked'"; ?>>
								</label>
							</div>
						</div>
						<div class="form-group col-3">
							<div class="form-check">
								<label class="d-block">Homeless:</label>
								<label class="form-check-label">
									<input class="form-check-input" type="checkbox" id='homeless' name='homeless' <?php if(isset($_POST['homeless']) || $homeless == 1) echo "checked='checked'"; ?>>
								</label>
							</div>
						</div>
					</div> <!-- row -->
				</fieldset>	<!-- Guest Information fieldset -->
				
				<fieldset class="form-group">
					<legend>Income and Accounts</legend>
					<div class="row">
						<div class="form-group col-3">
							<label class="form-control-label">Monthly income:</label>
							<div class="input-group">
								<span class="input-group-addon">$</span><input class="form-control" type="tel" id="income" name="income" value="<?php echo $income; ?>">
							</div>
						</div>
						<div class="form-group col-3">
							<label class="form-control-label">Monthly Rent:</label>
							<div class="input-group">
								<span class="input-group-addon">$</span><input class="form-control" type="text" id="rent" name="rent" value="<?php echo $rent; ?>">
							</div>
						</div>
						<div class="form-group col-3">
							<label class="form-control-label">Food Stamps:</label>
							<div class="input-group">
								<span class="input-group-addon">$</span><input class="form-control" type="text" id="foodStamp" name="foodStamp" value="<?php echo $foodStamp; ?>">
							</div>
						</div>
						<div class="form-group col-3">
							<label class="form-control-label">Additional Support:</label>
							<div class="input-group">
								<span class="input-group-addon">$</span><input class="form-control" type="text" id="addSupport" name="addSupport" value="<?php echo $addSupport; ?>">
							</div>
						</div>
					</div> <!-- row -->
					
					<div class="row">
						<div class="form-group col-4">
							<label class="form-control-label">Driver's License or Photo ID#:</label><input class="form-control" type="text" id="license" name="license" value="<?php echo $license ?>"> 
						</div>
						<div class="form-group col-4">
							<label class="form-control-label">Puget Sound Energy Account #:</label><input class="form-control" type="tel" id="pse" name="pse" value="<?php echo $pse ?>">
						</div>
						<div class="form-group col-4">
							<label class="form-control-label">Water Account #:</label><input class="form-control" type="text" id="water" name="water" value="<?php echo $water ?>">
						</div>
					</div> <!-- row -->
				</fieldset> <!-- Income and Accounts fieldset -->
				
				<fieldset class="form-group">
					<legend>Household Members</legend>
					<div class="row" id="household">
						<div class="form-group col-4">
							<label class="form-checkNum-label">Members in household:</label>
							<select class="form-control dropdown" id="members" name="members">
								<option value="">-- (include yourself) --</option>
								<option value="1" <?php if ($members == "1") echo "selected='selected'"; ?>>1</option>
								<option value="2" <?php if ($members == "2") echo "selected='selected'"; ?>>2</option>
								<option value="3" <?php if ($members == "3") echo "selected='selected'"; ?>>3</option>
								<option value="4" <?php if ($members == "4") echo "selected='selected'"; ?>>4</option>
								<option value="5" <?php if ($members == "5") echo "selected='selected'"; ?>>5</option>
								<option value="6" <?php if ($members == "6") echo "selected='selected'"; ?>>6</option>
								<option value="7" <?php if ($members == "7") echo "selected='selected'"; ?>>7</option>
								<option value="8" <?php if ($members == "8") echo "selected='selected'"; ?>>8</option>
								<option value="9" <?php if ($members == "9") echo "selected='selected'"; ?>>9</option>
								<option value="10" <?php if ($members == "10") echo "selected='selected'"; ?>>10</option>
							</select>
						</div>
					</div> <!-- row -->
					<?php
						// create arrays to hold genders
						$selectedArr = array();
						$maleArr = array();
						$femaleArr = array();
						$otherArr = array();
						// loop through members by selecting id's
						for ($i = 1; $i <= 5; $i++)
						{
							if(isset($_POST["name$i"])) // check for name
							{
								$name = $_POST["name$i"];
							}
							else
							{
								$name = "";
							}
							if(isset($_POST["age$i"])) // check for age
							{
								$age = $_POST["age$i"];
							}
							else
							{
								$age = "";
							}
							// check for gender and mark matching gender as selected
							if(isset($_POST["gender$i"]) && ($_POST["gender$i"] == "male"))
							{
								$male = "selected='selected'";
							}
							else if(isset($_POST["gender$i"]) && ($_POST["gender$i"] == "female"))
							{
								$female = "selected='selected'";
							}
							else if(isset($_POST["gender$i"]) && ($_POST["gender$i"] == "other"))
							{
								$other = "selected='selected'";
							}
							else // no matches
							{
								$selected = "selected='selected'";
							}
							
							if($edit) // if editing the form
							{
								// select appropriate for each member
								// -1 because array starts at 0
								if($genderArr[$i - 1] == "male")
								{
									array_push($maleArr, "selected='selected'");
									array_push($femaleArr, "false");
									array_push($otherArr, "false");
									array_push($selectedArr, "false");
								}
								else if($genderArr[$i - 1] == "female")
								{
									array_push($femaleArr, "selected='selected'");
									array_push($maleArr, "false");
									array_push($otherArr, "false");
									array_push($selectedArr, "false");
								}
								else if($genderArr[$i - 1] == "other")
								{
									array_push($maleArr, "false");
									array_push($femaleArr, "false");
									array_push($otherArr, "selected='selected'");
									array_push($selectedArr, "false");
								}
								else
								{
									array_push($maleArr, "false");
									array_push($femaleArr, "false");
									array_push($otherArr, "false");
									array_push($selectedArr, "selected='selected'");
								}
							}
							// editing is different because we are getting the values from the gender array
							if($edit)
							{
								// print out 10 household member form fields
								echo "
								<div class='row' id='house$i'>
									<div class='form-group col-5'>
										<label class='form-control-label'>Name:</label><input class='form-control' type='text' id='name$i' name='name$i' value='".$nameArr[$i - 1]."'>
									</div>
									<div class='form-group col-2'>
										<label class='form-control-label'>Age:</label><input class='form-control' type='text' id='age$i' name='age$i' maxlength='3' value='".$ageArr[$i -1]."'>
									</div>
									<div class='form-group col-2'>";
									if ($i == 1)
									{
										echo "<label class='form-check-label'><b>*Gender:</b></label>";
									}
									else
									{
										echo "<label class='form-check-label'>Gender:</label>";
									}
									echo "<label class='d-block'></label>
										<select class='form-control dropdown' id='gender$i' name='gender$i'>
											<option value='' ".$selectedArr[$i -1].">select one</option>
											<option value='male' ".$maleArr[$i -1].">Male</option>
											<option value='female' ".$femaleArr[$i - 1].">Female</option>
											<option value='other' ".$otherArr[$i -1].">Other</option>
										</select>
									</div>
								</div>";
							}
							else // print out 10 household member form fields
							{
								echo "
								<div class='row' id='house$i'>
									<div class='form-group col-5'>
										<label class='form-control-label'>Name:</label><input class='form-control' type='text' id='name$i' name='name$i' value='".$name."'>
									</div>
									<div class='form-group col-2'>
										<label class='form-control-label'>Age:</label><input class='form-control' type='text' id='age$i' name='age$i' maxlength='3' value='".$age."'>
									</div>
									<div class='form-group col-2'>";
									if ($i == 1)
									{
										echo "<label class='form-check-label'><b>*Gender:</b></label>";
									}
									else
									{
										echo "<label class='form-check-label'>Gender:</label>";
									}
									echo "<label class='d-block'></label>
										<select class='form-control dropdown' id='gender$i' name='gender$i'>
											<option value='' $selected>select one</option>
											<option value='male' $male>Male</option>
											<option value='female' $female>Female</option>
											<option value='other' $other>Other</option>
										</select>
									</div>
								</div>";
							}
						}
					?>
				</fieldset> <!-- Household Member fieldset -->
				<fieldset class="form-group">
					<legend>Help Provided</legend>
					<div class="row">
						<div class="form-group col-12">
							<label class="form-control-label">Interviewer's notes:</label>
							<textarea class="form-control" id="notes" name="notes" rows="4"><?php echo $notes ?></textarea>
						</div>
					</div> <!-- row -->

					<div class="row" id="checkvoucher">
						<div class="form-group col-4">
							<label class="form-checkNum-label">Number of vouchers</label>
							<select class="form-control dropdown" id="vouchernum" name="vouchernum">
								<option value="">-- select number --</option>
								<option value="1" <?php if ($vouchernum == "1") echo "selected='selected'"; ?>>1</option>
								<option value="2" <?php if ($vouchernum == "2") echo "selected='selected'"; ?>>2</option>
								<option value="3" <?php if ($vouchernum == "3") echo "selected='selected'"; ?>>3</option>
								<option value="4" <?php if ($vouchernum == "4") echo "selected='selected'"; ?>>4</option>
								<option value="5" <?php if ($vouchernum == "5") echo "selected='selected'"; ?>>5</option>
							</select>
						</div>
					</div> <!-- row -->
					<?php
						// create arrays to hold genders
						$selected2Arr = array();
						$energybillArr = array();
						$waterbillArr = array();
						$gasArr = array();
						$thriftArr = array();
						$dolArr = array();
						$foodArr = array();
						$otherResourceArr = array();
						// loop through members by selecting id's
						for ($i = 1; $i <= 5; $i++)
						{
							if(isset($_POST["voucher$i"])) // check for name
							{
								$voucher = $_POST["voucher$i"];
							}
							else
							{
								$voucher = "";
							}
							if(isset($_POST["checkNum$i"])) // check for age
							{
								$checkNum = $_POST["checkNum$i"];
							}
							else
							{
								$checkNum = "";
							}
							if(isset($_POST["amount$i"])) // check for age
							{
								$amount = $_POST["amount$i"];
							}
							else
							{
								$amount = "";
							}
							// check for gender and mark matching gender as selected
							if(isset($_POST["resource$i"]) && ($_POST["resource$i"] == "thriftshop"))
							{
								$thrift = "selected='selected'";
							}
							else if(isset($_POST["resource$i"]) && ($_POST["resource$i"] == "gas"))
							{
								$gas = "selected='selected'";
							}
							else if(isset($_POST["resource$i"]) && ($_POST["resource$i"] == "waterbill"))
							{
								$waterbill = "selected='selected'";
							}
							else if(isset($_POST["resource$i"]) && ($_POST["resource$i"] == "energybill"))
							{
								$energybill = "selected='selected'";
							}
							else if(isset($_POST["resource$i"]) && ($_POST["resource$i"] == "food"))
							{
								$food = "selected='selected'";
							}
							else if(isset($_POST["resource$i"]) && ($_POST["resource$i"] == "dol"))
							{
								$dol = "selected='selected'";
							}
							else if(isset($_POST["resource$i"]) && ($_POST["resource$i"] == "other"))
							{
								$otherResource = "selected='selected'";
							}
							else // no matches
							{
								$selected2 = "selected='selected'";
							}
							
							if($edit) // if editing the form
							{
								// select appropriate for each voucher
								// -1 because array starts at 0
								if($resourceArr[$i - 1] == "thriftshop")
								{
									array_push($thriftArr, "selected='selected'");
									array_push($gasArr, "false");
									array_push($waterbillArr, "false");
									array_push($energybillArr, "false");
									array_push($foodArr, "false");
									array_push($dolArr, "false");
									array_push($otherResourceArr, "false");
									array_push($selected2Arr, "false");
								}
								else if($resourceArr[$i - 1] == "gas")
								{
									array_push($thriftArr, "false");
									array_push($gasArr, "selected='selected'");
									array_push($waterbillArr, "false");
									array_push($energybillArr, "false");
									array_push($foodArr, "false");
									array_push($dolArr, "false");
									array_push($otherResourceArr, "false");
									array_push($selected2Arr, "false");
								}
								else if($resourceArr[$i - 1] == "waterbill")
								{
									array_push($thriftArr, "false");
									array_push($gasArr, "false");
									array_push($waterbillArr, "selected='selected'");
									array_push($energybillArr, "false");
									array_push($foodArr, "false");
									array_push($dolArr, "false");
									array_push($otherResourceArr, "false");
									array_push($selected2Arr, "false");
								}
								else if($resourceArr[$i - 1] == "energybill")
								{
									array_push($thriftArr, "false");
									array_push($gasArr, "false");
									array_push($waterbillArr, "false");
									array_push($energybillArr, "selected='selected'");
									array_push($foodArr, "false");
									array_push($dolArr, "false");
									array_push($otherResourceArr, "false");
									array_push($selected2Arr, "false");
								}
								else if($resourceArr[$i - 1] == "food")
								{
									array_push($thriftArr, "false");
									array_push($gasArr, "false");
									array_push($waterbillArr, "false");
									array_push($energybillArr, "false");
									array_push($foodArr, "selected='selected'");
									array_push($dolArr, "false");
									array_push($otherResourceArr, "false");
									array_push($selected2Arr, "false");
								}
								else if($resourceArr[$i - 1] == "dol")
								{
									array_push($thriftArr, "false");
									array_push($gasArr, "false");
									array_push($waterbillArr, "false");
									array_push($energybillArr, "false");
									array_push($foodArr, "false");
									array_push($dolArr, "selected='selected'");
									array_push($otherResourceArr, "false");
									array_push($selected2Arr, "false");
								}
								else if($resourceArr[$i - 1] == "other")
								{
									array_push($thriftArr, "false'");
									array_push($gasArr, "false");
									array_push($waterbillArr, "false");
									array_push($energybillArr, "false");
									array_push($foodArr, "false");
									array_push($dolArr, "false");
									array_push($otherResourceArr, "selected='selected'");
									array_push($selected2Arr, "false");
								}
								else
								{
									array_push($thriftArr, "false");
									array_push($gasArr, "false");
									array_push($waterbillArr, "false");
									array_push($energybillArr, "false");
									array_push($foodArr, "false");
									array_push($dolArr, "false");
									array_push($otherResourceArr, "false");
									array_push($selected2Arr, "selected='selected'");
								}
							}
							// editing is different because we are getting the values from the gender array
							if($edit)
							{
								// print out 5 household member form fields
								echo "
								<div class='row' id='need$i'>
									<div class='form-group col-3'>
										<label class='form-control-label'>Voucher#:</label><input class='form-control' type='text' id='voucher$i' name='voucher$i' value='".$voucherArr[$i - 1]."'>
									</div>
									<div class='form-group col-3'>
										<label class='form-control-label'>Check#:</label><input class='form-control' type='text' id='checkNum$i' name='checkNum$i' value='".$checkNumArr[$i - 1]."'>
									</div>
									<div class='form-group col-2'>
										<label class='form-control-label'>Amount:</label>
										<div class='input-group'>
											<span class='input-group-addon'>$</span><input class='form-control' type='amount' id='amount$i' name='amount$i' value='".$amountArr[$i - 1]."'>
										</div>
									</div>
									<div class='form-group col-3'>
										<label class='form-check-label'>Resource needed:</label>
										<label class='d-block'></label>
										<select class='form-control dropdown' id='resource$i' name='resource$i'>
											<option value='' ".$selected2Arr[$i -1].">-- select one --</option>
											<option value='thriftshop' ".$thriftArr[$i -1].">Thrift Shop</option>
											<option value='gas' ".$gasArr[$i -1].">Gas</option>
											<option value='waterbill' ".$waterbillArr[$i -1].">Water Bill</option>
											<option value='energybill' ".$energybillArr[$i -1].">Energy Bill</option>
											<option value='food' ".$foodArr[$i -1].">Food</option>
											<option value='dol' ".$dolArr[$i -1].">Dept of Lisencing</option>
											<option value='other' ".$otherResourceArr[$i -1].">Other</option>
										</select>
									</div>
								</div>
								";
							}
							else // print out 10 voucher form fields
							{
								echo "
								<div class='row' id='need$i'>
									<div class='form-group col-3'>
										<label class='form-control-label'>Voucher#:</label><input class='form-control' type='text' id='voucher$i' name='voucher$i' value='$voucher'>
									</div>
									<div class='form-group col-3'>
										<label class='form-control-label'>Check#:</label><input class='form-control' type='text' id='checkNum$i' name='checkNum$i' value='$checkNum'>
									</div>
									<div class='form-group col-2'>
										<label class='form-control-label'>Amount:</label>
										<div class='input-group'>
											<span class='input-group-addon'>$</span><input class='form-control' type='amount' id='amount$i' name='amount$i' value='$amount'>
										</div>
									</div>
									<div class='form-group col-3'>
										<label class='form-check-label'>Resource needed:</label>
										<label class='d-block'></label>
										<select class='form-control dropdown' id='resource$i' name='resource$i'>
											<option value='' $selected2>-- select one --</option>
											<option value='thriftshop' $thrift>Thrift Shop</option>
											<option value='gas' $gas>Gas</option>
											<option value='waterbill' $waterbill>Water Bill</option>
											<option value='energybill' $energybill>Energy Bill</option>
											<option value='food' $food>Food</option>
											<option value='dol' $dol>Dept of Lisencing</option>
											<option value='other' $otherResource>Other</option>
										</select>
									</div>
								</div>
								";
							}
						}
					?>
				</fieldset> <!-- Help Provided Fieldset -->
				
				<input id="preview" name="preview" type="button" value="Preview &raquo;" data-toggle='modal' data-target='#confirm-submit'>
				<input id="submit" name="submit" type="submit" value="Submit Guest &raquo;">
				
				<?php
					
					if($edit) // extra options when editing
					{
						$url = "deleteGuest.php?ClientId=$id";
						// delete the guest
						//echo "<a href='$url' class=\"deleteForm\">Delete Guest</a>";
						// choose to update or create a new guest
						echo "<select id='update' name='update'>
								<option value='update' cheched='checked'>Update existing guest</option>
								<option value='new'>Create new guest</option>
							</select>";
					}
				?>
			</form>	<!-- Guest Form -->
			<div class="modal fade" id="confirm-submit" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header"><h4>Preview Form</h4></div>
						<div class="modal-body" id="previewForm">
							<h6>Are you sure you want to submit the following details?</h6>
						</div>
						<div class="modal-footer">
							<button type="button" id="close" class="btn btn-default" data-dismiss="modal">Return</button>
						</div>
					</div>
				</div>
			</div> <!-- Preview Form -->
		</div>
		<!-- Bootstrap and jQuery -->
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
		<script src="js/newGuest.js"></script>
	</body>
</html>

