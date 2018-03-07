<?php
	/* Team AZAP
	 * Alex, Zach, Antonio, Pavel
     * azap.greenrivertech.net/305/login/user-db.php
	 * validates usernames and passwords */
    
    /*
    CREATE TABLE IF NOT EXISTS `users` (
        `id` smallint(6) PRIMARY KEY AUTO_INCREMENT NOT NULL,
        `username` varchar(20),
        `admin` enum('y','n') DEFAULT NULL,
        `password` char(40) NOT NULL
      );
      INSERT INTO users VALUES 
      (NULL, 'azap@greenriver.edu', 'n', SHA1('password123')),
    */

    function validUser($un, $pw)
    {
        //Don't use $username and $password here... they will be overwritten in db.php
        
        //Connect to DB
        require '/home/azap/db.php';
        
        //Query DB
        $sql = "SELECT * FROM users WHERE username='$un' AND password=SHA1('$pw')";
            //echo $sql;
        $result = mysqli_query($cnxn, $sql);
        
        //Return true if a row is returned, false otherwise
        return mysqli_num_rows($result) == 1;
    }
    
    