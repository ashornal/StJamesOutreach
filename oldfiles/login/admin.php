<?php
	function checkAdmin($un)
	{
		//Connect to DB
        require '/home/azap/db.php';
		
		$sql = "SELECT * FROM users WHERE username='$un' AND admin='y'";
		$result = mysqli_query($cnxn, $sql);
		
		//Return true if a row is returned, false otherwise
        return mysqli_num_rows($result) == 1;
	}