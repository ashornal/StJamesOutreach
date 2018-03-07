<?php
/**
 * Created by PhpStorm.
 * User: Alex Pavel
 * Date: 3/7/2018
 * Time: 12:25 PM
 */

//Require the autoload file
require_once('vendor/autoload.php');
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 3);

//Create an instance of the Base Class
$f3 = Base::instance();


//Define a default route
$f3->route('GET /', function()
{
    $template = new Template();
    echo $template->render('pages/home.html');
}
);