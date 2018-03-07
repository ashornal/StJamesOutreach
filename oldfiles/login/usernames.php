<?php
	/* Team AZAP
	 * Alex, Zach, Antonio, Pavel
	 * azap.greenrivertech.net/305/login/usernames.php
	 * Contains usernames and passwords */
	
    //Turn on error reporting
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    //Assoc array containing username=>password pairs
    //$users = array("mathias"=>"mno", "iqbal"=>"ijk", "sarah"=>"stu");
    //print_r($users);
    
    function validUser($un, $pw)
    {
        //Connect to db
        require '/home/azap/db.php';
        
        //Query the db
        $sql = "SELECT * FROM `users`
                    WHERE username='$un' and password=SHA1('$pw')";
        //echo $sql;
        $result = mysqli_query($cnxn, $sql);
        
        //Return true if a match found, false otherwise
        return mysqli_num_rows($result) == 1;
    }