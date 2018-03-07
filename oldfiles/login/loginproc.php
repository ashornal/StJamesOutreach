<?php
	/* Team AZAP
	 * Alex, Zach, Antonio, Pavel
	 * azap.greenrivertech.net/305/login/loginproc.php
	 * Login process */

    //Turn on error reporting
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    
    //Start the session
    session_start();
    
    //Get POST data
    //Array ( [username] => azap [password] => password123  )
    //print_r($_POST);
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    //Check for missing values
    if(empty($username) OR empty($password)) 
    {
        //Redirect to login form
        header('location: index.php?pass=no');
        exit;
    }
    
    //Check username and password
    require ('usernames.php');
    
    //If the user exists and password is a match
    if (validUser($username, $password))
    {
    
        //Set session variable
        $_SESSION['username'] = $username;
        
        //Redirect to login page
        header ('location: /index.php');
        
    }
    else
    {    //Otherwise
		
		//Destroy session variable
		unset($_SESSION['username']);
		
		//Redirect to login form, with error
		header('location: index.php?pass=no');
    }
    
    
    
    
    
    
    
    