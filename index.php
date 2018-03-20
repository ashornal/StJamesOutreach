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


//logout route
$f3->route('GET|POST /logout', function($f3,$params)
{
    //unsets the session variables
   unset($_SESSION['username']);
   unset($_SESSION['password']);

    $template = new Template();
    echo $template->render('views/login.html');
});

$f3->route('GET|POST /', function($f3,$params)
{
    $_SESSION['username'] = "";
    $_SESSION['password'] = "";
    $database = new Database();
    //if submitted login form
    if(isset($_POST['login']))
    {
        //if the username and password are not null
        if(!is_null($_POST['username'] && !is_null($_POST['password'])))
        {
            $username = $_POST['username'];
            $password = $_POST['password'];
            //checks the database if the credentail are correct
            $data = $database->validUser($username,$password);
            //returns 1 if correct, and nothing if inncorrect
            if($data == 1)
            {
                //sets the session
                $_SESSION['username'] = $username;
                $_SESSION['password'] = $password;
                $f3->reroute('/home');
            } else {
                $f3->set('error', 'Incorrect Login');
            }
        }
    }
    $template = new Template();
    echo $template->render('views/login.html');
}
);

//Define a default route(home)
$f3->route('GET /home', function($f3,$params)
{
    //if logged in
    if(empty($_SESSION['username']) || empty($_SESSION['password']))
    {
        $f3->reroute('/');
    }
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
$f3->route('GET|POST /reports', function($f3,$params)
{
    //if logged in
    if(empty($_SESSION['username']) || empty($_SESSION['password']))
    {
        $f3->reroute('/');
    }
    // initialize variable
    $start = date("Y-m-01");
    $end = date("Y-m-d");

    // set to new value when submitting
    if (isset($_POST['submit']))
    {
        if (!empty($_POST['start']))
        {
            $start = $_POST['start'];
        }
        if (!empty($_POST['end']))
        {
            $end = $_POST['end'];
        }
    }
    $f3->set('start', $start);
    $f3->set('end', $end);


    $database = new Database();

    //setters for the hive
    $guest = $database->getGuests();
    $f3->set('guests', $guest);

    $thrift = $database->getThrift($start,$end);
    $f3->set('thrift', $thrift);

    $gas = $database->getGas($start,$end);
    $f3->set('gas', $gas);

    $water = $database->getWater($start,$end);
    $f3->set('water', $water);

    $energy = $database->getEnergy($start,$end);
    $f3->set('energy', $energy);

    $food = $database->getFood($start,$end);
    $f3->set('food', $food);

    $dol = $database->getDol($start,$end);
    $f3->set('dol', $dol);

    $other = $database->getOther($start,$end);
    $f3->set('other', $other);

    $total = $database->getTotal($start,$end);
    $f3->set('total', $total);

    $template = new Template();
    echo $template->render('views/reports.html');
}
);

//json backside for storing member information
$f3->route('POST /get-membersSticky_JSON', function() {

    echo json_encode($_SESSION['stickyMembers']);
});

//json backside of storing vouchers information
$f3->route('POST /get-vouchersSticky_JSON', function() {

    echo json_encode($_SESSION['stickyVouchers']);
});

//setting the json/ajax call to a session
$f3->route('POST /get-members_JSON', function(){
    $_SESSION['stickyMembers'] = $_POST['members'];
});

//setting the json/ajax call to a session
$f3->route('POST /get-vouchers_JSON', function()
{
    $_SESSION['stickyVouchers'] = $_POST['vouchers'];

});

//newGuest
$f3->route('GET|POST /newGuest', function($f3)
{
    //if logged in
    if(empty($_SESSION['username']) || empty($_SESSION['password']))
    {
        $f3->reroute('/');
    }

    if(isset($_POST['submit'])){

        //setting variables
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

        //set to hive
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

            //replace values for easier access later
            if($homeless == null){
                $homeless = 0;
            }
            if($veteran == null){
                $veteran = 0;
            }
            if($physical == null){
                $physical = 0;
            }
            if($mental == null){
                $mental = 0;
            }


            //setter for the guest object
            $guest = new Guest($firstName,$lastName,$birthdate);
            //add setters for all variables
            $guest->setPhone($phone);
            $guest->setEmail($email);
            $guest->setEthnicity($ethnicity);
            $guest->setStreet($street);
            $guest->setCity($city);
            $guest->setZip($zip);
            $guest->setMental($mental);
            $guest->setPhysical($physical);
            $guest->setVeteran($veteran);
            $guest->setHomeless($homeless);
            $guest->setIncome($income);
            $guest->setRent($rent);
            $guest->setFoodStamp($foodStamp);
            $guest->setAddSupport($addSupport);
            $guest->setLicense($license);
            $guest->setPse($pse);
            $guest->setWater($water);
            $guest->setNotes($notes);

            $database = new Database();

            //insert the guest into the database
            $database->insertGuest($guest->getfname(),$guest->getlname(),$guest->getBirthdate(),$guest->getPhone(),
                $guest->getEmail(),$guest->getEthnicity(),$guest->getStreet(),$guest->getCity(),$guest->getZip(),
                $guest->getLicense(),$guest->getPse(),$guest->getWater(),$guest->getIncome(),$guest->getRent(),
                $guest->getFoodStamp(),$guest->getAddSupport(),$guest->getMental(),$guest->getPhysical(),
                $guest->getVeteran(),$guest->getHomeless(),$guest->getNotes());

            //insert the vouchers into the database
            if(isset($_SESSION['stickyVouchers'])) {
                for ($i = 0; $i < sizeof($_SESSION['stickyVouchers']); $i++) {
                    if($_SESSION['stickyVouchers'][$i][0] != null) {
                        $database->insertNeeds($_SESSION['stickyVouchers'][$i][3], $_SESSION['stickyVouchers'][$i][2],
                            $_SESSION['stickyVouchers'][$i][0], $_SESSION['stickyVouchers'][$i][1]);
                    }
                }
            }

            //insert the members into the database
            if(isset($_SESSION['stickyMembers'])) {
                for ($j = 0; $j < sizeof($_SESSION['stickyMembers']); $j++) {
                    if ($_SESSION['stickyMembers'][$j][0] != null) {
                        $database->insertHousehold($_SESSION['stickyMembers'][$j][0], $_SESSION['stickyMembers'][$j][1], $_SESSION['stickyMembers'][$j][2]);

                    }
                }
            }

        }

    }
    $template = new Template();
    echo $template->render('views/newGuest.html');
}
);

//edit guest
$f3->route('GET|POST /@client_id', function($f3,$params) {
    if(empty($_SESSION['username']) || empty($_SESSION['password']))
    {
        $f3->reroute('/');
    }
    $id = $params['client_id'];

    $database = new Database();
    $guest = $database->getGuest($id);



    $f3->set('firstName', $guest['first']);
    $f3->set('lastName', $guest['last']);
    $f3->set('birthdate', $guest['birthdate']);
    $f3->set('phone', $guest['phone']);
    $f3->set('email', $guest['email']);
    $f3->set('ethnicity', $guest['ethnicity']);
    $f3->set('street', $guest['street']);
    $f3->set('city', $guest['city']);
    $f3->set('zip', $guest['zip']);
    $f3->set('license', $guest['license']);
    $f3->set('pse', $guest['pse']);
    $f3->set('water', $guest['water']);
    $f3->set('income', $guest['income']);
    $f3->set('rent', $guest['rent']);
    $f3->set('foodStamp', $guest['foodStamp']);
    $f3->set('addSupport', $guest['addSupport']);
    $f3->set('mental', $guest['mental']);
    $f3->set('physical', $guest['physical']);
    $f3->set('veteran', $guest['veteran']);
    $f3->set('homeless', $guest['homeless']);
    $f3->set('members', $guest['members']);
    $f3->set('notes', $guest['notes']);


    if (isset($_POST['submit'])) {

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
        $notes = $_POST['notes'];

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
        $f3->set('notes', $notes);

        include('model/validation.php');
        $isValid = true;

        //validate first Name
        if (!validFirst($firstName)) {
            $f3->set('invalidFirstName', "invalid");
            $isValid = false;
        }

        //validate last name
        if (!validLast($lastName)) {
            $f3->set('invalidLastName', "invalid");
            $isValid = false;
        }

        //validate birthdate
        if (!validBirth($birthdate)) {
            $f3->set('invalidBirthdate', "invalid");
            $isValid = false;
        }

        //validate phone number
        if (!validPhone($phone)) {
            $f3->set('invalidPhone', "invalid");
            $isValid = false;
        }

        //validate zipcode
        if (!validZip($zip)) {
            $f3->set('invalidZip', "invalid");
            $isValid = false;
        }

        //validate monthly income
        if (!validIncome($income)) {
            $f3->set('invalidIncome', "invalid");
            $isValid = false;
        }

        //validate monthly rent
        if (!validRent($rent)) {
            $f3->set('invalidRent', "invalid");
            $isValid = false;
        }

        //validate foodstamps
        if (!validfoodstamps($foodStamp)) {
            $f3->set('invalidFoodstamps', "invalid");
            $isValid = false;
        }

        //validate gender

        //validate addsupport
        if (!validAddSupport($addSupport)) {
            $f3->set('invalidAddSupport', "invalid");
            $isValid = false;
        }


        if ($isValid) {

            if($homeless == null){
                $homeless = 0;
            }
            if($veteran == null){
                $veteran = 0;
            }
            if($physical == null){
                $physical = 0;
            }
            if($mental == null){
                $mental = 0;
            }

            $guest = new Guest($firstName,$lastName,$birthdate);
            //add setters for all variables
            $guest->setPhone($phone);
            $guest->setEmail($email);
            $guest->setEthnicity($ethnicity);
            $guest->setStreet($street);
            $guest->setCity($city);
            $guest->setZip($zip);
            $guest->setMental($mental);
            $guest->setPhysical($physical);
            $guest->setVeteran($veteran);
            $guest->setHomeless($homeless);
            $guest->setIncome($income);
            $guest->setRent($rent);
            $guest->setFoodStamp($foodStamp);
            $guest->setAddSupport($addSupport);
            $guest->setLicense($license);
            $guest->setPse($pse);
            $guest->setWater($water);
            $guest->setNotes($notes);

            $database = new Database();
            $database->EditGuest($id,$guest->getfname(),$guest->getlname(),$guest->getBirthdate(),$guest->getPhone(),
                $guest->getEmail(),$guest->getEthnicity(),$guest->getStreet(),$guest->getCity(),$guest->getZip(),
                $guest->getLicense(),$guest->getPse(),$guest->getWater(),$guest->getIncome(),$guest->getRent(),
                $guest->getFoodStamp(),$guest->getAddSupport(),$guest->getMental(),$guest->getPhysical(),
                $guest->getVeteran(),$guest->getHomeless(),$guest->getNotes());

            if(isset($_SESSION['stickyVouchers'])) {
                for ($i = 0; $i < sizeof($_SESSION['stickyVouchers']); $i++) {
                    if($_SESSION['stickyVouchers'][$i][0] != null) {
                        $database->editNeeds($id, $_SESSION['stickyVouchers'][$i][3], $_SESSION['stickyVouchers'][$i][2],
                            $_SESSION['stickyVouchers'][$i][0], $_SESSION['stickyVouchers'][$i][1]);
                    }

                }
            }

            if(isset($_SESSION['stickyMembers'])) {
                for ($j = 0; $j < sizeof($_SESSION['stickyMembers']); $j++) {
                    if ($_SESSION['stickyMembers'][$j][0] != null) {
                        $database->editHousehold($id, $_SESSION['stickyMembers'][$j][0], $_SESSION['stickyMembers'][$j][1], $_SESSION['stickyMembers'][$j][2]);
                    }
                }
            }


        }
    }

    $template = new Template();
    echo $template->render('views/newGuest.html');

}
);

//demographics
$f3->route('GET /demographics', function($f3)
{
    if(empty($_SESSION['username']) || empty($_SESSION['password']))
    {
        $f3->reroute('/');
    }
    $database = new Database();
    //call to the database and set to variables
    $ethnicity = $database->getEthnicity();
    $gender = $database->getGender();
    $zips = $database->getZips();
    $disabilities = $database->getDisabilities();
    $veterans = $database->getVeterans();

    //set tot hive
    $f3->set('ethnicity', $ethnicity);
    $f3->set('gender', $gender);
    $f3->set('zips', $zips);
    $f3->set('disabilities', $disabilities);
    $f3->set('veterans', $veterans);

    $template = new Template();
    echo $template->render('views/demographics.html');
}
);

//Run Fat-Free
$f3->run();