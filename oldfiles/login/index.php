<?php
	/* Team AZAP
	 * Alex, Zach, Antonio, Pavel
	 * http://azap.greenrivertech.net/login/index.php
	 * Login page, sends to loginproc.php
	 */
	
	// turn on error reporting
	ini_set("display_errors", 1);
	error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
		<link type="text/css" rel="stylesheet" href="/css/login.css">
		<title>Login</title>
	</head>
	<body>
		<nav class="navbar navbar-expand-lg navbar-light bg-light" id="nav">
			<h1><a class="navbar-brand"><img id="logo" src="/images/StJamesLogo.png" alt="St. James Outreach"/></a></h1>
		</nav>
		<div class="container">
			<?php
				//See if there was an error
				if (isset($_GET['pass']))
				{    
					echo "<p>Invalid Email or Password.</p>";
				}
			?>

			<form class="form-signin" action="loginproc.php" method="post">
				
				<label> Email Address: 
				<input type="text" name="username" placeholder="azap@greenriver.edu"></label><br>
				<label> Password: 
				<input type="password" name="password" placeholder="password123"></label><br>
				<button class="btn btn-lg btn-primary btn-block" type="submit" value="Login" >Sign in</button>
		
			</form>
		  
		</div><!-- container -->
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
	</body>
</html>


