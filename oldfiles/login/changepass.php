<?php
	/* Team AZAP
	 * Alex, Zach, Antonio, Pavel
	 * http://azap.greenrivertech.net/index.php 
	 * Admin change password */
	session_start();
	
	require '/home/azap/db.php';//absolute path
	
	//error reporting
	ini_set('display-errors',1);
	error_reporting(E_ALL);
	
	// if not logged in
	if (!isset($_SESSION['username']))
	{
		header ('location: login/index.php');
	}
	/*if (checkAdmin($_SESSION['username']))
    {
        //Redirect to login page
        header ('location: changepass.php'); 
    }
    else
    {    //Otherwise
		//Redirect to view guest
		header('location: ../index.php?');
    }*/
?>
<!DOCTYPE html>
<html lang="en">
  
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap and jQuery js and css -->
    <!-- Cannot change order or dialogs won't display correctly -->
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="js/jquery-ui.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.4/css/jquery.dataTables.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="../css/index.css">
    
    <title>Settings</title>
  </head>
  
  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light" id="nav">
		<h1><a class="navbar-brand" href="index.php"><img id="logo" src="../images/StJamesLogo.png" alt="St. James Outreach"/></a></h1>
		<div class="container">
			  <ul class="nav nav-tabs nav-justified">
				  <li><a class="dropdown-item" href="../newGuest.php">New Guest</a></li>
				  <li><a class="dropdown-item" href="../index.php">View Guests</a></li>
				  <li><a class="dropdown-item" href="../reports.php">Reports</a></li>
				  <li><a class="dropdown-item" href="../demographics.php">Demographics</a></li>
				  <li><a class="dropdown-item" href="changepass.php">Settings</a></li>
			  </ul>
			  <h4><a id="login" href="logout.php">Log out</a></h4> <br>
		</div>
  </nav>
    
      <div class="container" id="main">
        <div class="col-4">
          <h3>Change Password</h3>
        </div>
      
      
       <form method="post">
        <div class="form-group form-row w-25">
           <input type="text" class="form-control" id="newPassword1" name="newPassword1" placeholder="New Password" autocomplete="off">
        </div>
        <div class="form-group form-row w-25">
           <input type="text" class="form-control" id="newPassword2" name="newPassword2" placeholder="Re-type New Password" autocomplete="off">
        </div>
        <div id="button">
          <input type="submit" name='submit' id="submit" value="Change" autocomplete="off">
        </div>
       </form>
       <?php
         if (isset($_POST['submit']))
         {
          
           $valid = true;
		   /*if(( if (($_POST['prevPassword']) != ($_POST['newPassword2']))
           {
             echo "<p>Incorrect password</p>";
             $valid = false;
           }*/
		   
           //password validation
           if (($_POST['newPassword1']) != ($_POST['newPassword2']))
           {
             echo "<p>Passwords do not match</p>";
             $valid = false;
           }
           
           //password
           if (!empty($_POST['newPassword1']) OR !empty ($_POST['newPassword2'])) {
             $password = $_POST['newPassword1'];
           }
           else
           {
             echo "<p>Please enter a password</p>";
             $valid = false;
           }
           
          if($valid)
          {
          
             //query the database
             $sql = "UPDATE users SET password=SHA1('$password') WHERE username = 'user'";
			 $password = mysqli_real_escape_string($cnxn, $password);
             $result = mysqli_query($cnxn, $sql);
             
             if($result)
             {
               echo "<p id='changed'>Password changed!</p>";
             }
			 else
			{
				echo "<p>Error: " . mysqli_error($cnxn) . "</p>";
			}
          }
         }
       ?>
      </div>
  </body>
</html>