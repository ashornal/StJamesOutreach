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

ini_set('display_errors', 1);
error_reporting(E_ALL);

//Create an instance of the Base Class
$f3 = Base::instance();

$f3->set('ethnicities', array('white', 'black', 'hispanic', 'native', 'asian', 'pacific', 'eskimo','mixed','other' ));
$f3->set('membersArray', array('1','2','3','4','5','6','7','8','9','10'));
$f3->set('voucherNumbers', array('1','2','3','4','5'));

$f3->route('GET|POST /', function($f3, $params)
{
    $database = new Database();

    $guest = $database->getGuests();
    $f3->set('guests', $guest);

    $needs = $database->getNeeds();
    $f3->set('needs', $needs);

    $households = $database->getHouseholds();
    $f3->set('households', $households);

    $template = new Template();
    echo $template->render('views/home.html');
}
);

//Define a default route(home)
$f3->route('GET /home', function($f3, $params)
{
    $database = new Database();

    $guest = $database->getGuests();
    $f3->set('guests', $guest);

    $needs = $database->getNeeds();
    $f3->set('needs', $needs);

    $households = $database->getHouseholds();
    $f3->set('households', $households);

    $template = new Template();
    echo $template->render('views/home.html');
}
);

//reports
$f3->route('GET|POST /reports', function()
{
    $template = new Template();
    echo $template->render('views/reports.html');
}
);

//newGuest
$f3->route('GET|POST /newGuest', function($f3)
{
    if(isset($_POST['submit'])){
       $firstName = $_POST['first'];
       $lastName = $_POST['last'];
       $birthdate = $_POST['birthdate'];
       $phone = $_POST['phone'];
       $email = $_POST['email'];
       $ethnicity = $_POST['ethnicity'];
       $street = $_POST['street'];
       $city = $_POST['city'];
       $zip = $_POST['zip'];
       $mental = $_POST['mental'];
       $physical = $_POST['physical'];
       $veteran = $_POST['veteran'];
       $homeless = $_POST['homeless'];
       $income = $_POST['income'];
       $rent = $_POST['rent'];
       $foodStamp = $_POST['foodStamp'];
       $addSupport = $_POST['addSupport'];
       $license = $_POST['license'];
       $pse = $_POST['pse'];
       $water = $_POST['water'];
       $members = $_POST['members'];
       $notes = $_POST['notes'];
       $voucherNum = $_POST['vouchernum'];

        $f3->set('firstName', $firstName);
        $f3->set('lastName', $lastName);
        $f3->set('birthdate', $birthdate);
        $f3->set('phone', $phone);
        $f3->set('email', $email);
        $f3->set('ethnicity', $ethnicity);
        $f3->set('street', $street);
        $f3->set('city', $city);
        $f3->set('zip', $zip);
        $f3->set('mental', $mental);
        $f3->set('physical', $physical);
        $f3->set('veteran', $veteran);
        $f3->set('homeless', $homeless);
        $f3->set('income', $income);
        $f3->set('rent', $rent);
        $f3->set('foodStamp', $foodStamp);
        $f3->set('addSupport', $addSupport);
        $f3->set('license', $license);
        $f3->set('pse', $pse);
        $f3->set('water', $water);
        $f3->set('members', $members);
        $f3->set('notes', $notes);
        $f3->set('vouchernum', $voucherNum);

        include('model/validation.php');
        $isValid = true;

        //validate first Name
        if(!validFirst($firstName)){
            $f3->set('invalidFirstName', "invalid");
            $isValid  = false;
        }

        //validate last name
        if (!validLast($lastName)) {
            $f3->set('invalidLastName', "invalid");
            $isValid = false;
        }

        //validate birthdate
        if(!validBirth($birthdate)){
            $f3->set('invalidBirthdate', "invalid");
            $isValid = false;
        }

        //validate phone number
        if(!validPhone($phone)){
            $f3->set('invalidPhone', "invalid");
            $isValid = false;
        }

        //validate zipcode
        if(!validZip($zip)){
            $f3->set('invalidZip', "invalid");
            $isValid = false;
        }

        //validate monthly income
        if(!validIncome($income)){
            $f3->set('invalidIncome', "invalid");
            $isValid = false;
        }

        //validate monthly rent
        if(!validRent($rent)) {
            $f3->set('invalidRent', "invalid");
            $isValid = false;
        }

        //validate foodstamps
        if(!validfoodstamps($foodStamp)){
            $f3->set('invalidFoodstamps', "invalid");
            $isValid = false;
        }

        //validate gender

        //validate addsupport
        if(!validAddSupport($addSupport)){
            $f3->set('invalidAddSupport', "invalid");
            $isValid = false;
        }


        if($isValid){

            $guest = new Guest($firstName,$lastName,$birthdate);
            //add setters for all variables
            //print_r($guest);
        }

    }
    $template = new Template();
    echo $template->render('views/newGuest.html');
}
);

//demographics
$f3->route('GET /demographics', function()
{
    $template = new Template();
    echo $template->render('views/demographics.html');
}
);

//Run Fat-Free
$f3->run();