<?php
    /* Team AZAP
	 * Alex, Zach, Antonio, Pavel
	 * http://azap.greenrivertech.net/index.php */
    
    //Turn on error reporting
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    
    session_start();
    
    unset($_SESSION['username']);
    header('location: /login/index.php');