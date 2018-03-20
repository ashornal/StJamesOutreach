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

$f3->route('GET /', function($f3,$params)
{
    $database = new Database();

    $guest = $database->getGuests();
    $f3->set('guests', $guest);

    $households = $database->getHouseholds();
    $f3->set('households', $households);

    $template = new Template();
    echo $template->render('views/home.html');
}
);

//Define a default route(home)
$f3->route('GET /home', function($f3,$params)
{
    $database = new Database();

    $guest = $database->getGuests();
    $f3->set('guests', $guest);

    $households = $database->getHouseholds();
    $f3->set('households', $households);

    $template = new Template();
    echo $template->render('views/home.html');
}
);

//reports
$f3->route('GET|POST /reports', function($f3,$params)
{
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

$f3->route('POST /get-membersSticky_JSON', function() {
//    echo "Sessions array <pre>";
//    var_dump($_SESSION['stickyMembers']);
//    echo "</pre>"
    echo json_encode($_SESSION['stickyMembers']);
});

$f3->route('POST /get-vouchersSticky_JSON', function() {
//    echo "Sessions array <pre>";
//    var_dump($_SESSION['stickyVouchers']);
//    echo "</pre>";
    echo json_encode($_SESSION['stickyVouchers']);
});

$f3->route('POST /get-members_JSON', function(){
    $_SESSION['stickyMembers'] = $_POST['members'];
});

$f3->route('POST /get-vouchers_JSON', function()
{
//    echo "get-vouchers";
//
//    $_POST['data'] = [
//        "data" => "testData",
//        "data2" => "moreTestData",
//        ];
//
//    echo "Post array <pre>";
//    var_dump($_POST);
//    echo "</pre>";
//
    $_SESSION['stickyVouchers'] = $_POST['vouchers'];
//
//    echo "json_encoded: <br>";

//    echo "data array <pre>";
//    var_dump($arrayToEncode);
//    echo "</pre>";

    //echo json_encode($arrayToEncode);
});

//newGuest
$f3->route('GET|POST /newGuest', function($f3)
{

    $todaysDate = date("Y-m-d");

    if(isset($_SESSION)){
        echo "Vouchers Session <pre>";
//        var_dump($_SESSION['stickyVouchers'][0][0]); // voucher number
//        var_dump($_SESSION['stickyVouchers'][0][1]); //check number
//
//        var_dump($_SESSION['stickyVouchers'][1][0]); //voucher number
//        var_dump($_SESSION['stickyVouchers'][1][1]); //check number

        var_dump($_SESSION['stickyVouchers']);

        echo "</pre>";
        echo "<p>Length of stickyVouchers: ". sizeof($_SESSION['stickyVouchers'])."</p>";
        echo "<p>Length of stickyMembers[0]: ". sizeof($_SESSION['stickyMembers'][0])."Data: ". $_SESSION['stickyMembers'][0][0]."</p>";


        echo "Members session <pre>";
        var_dump($_SESSION['stickyMembers']);
        echo "</pre>";
        //unset($_SESSION['stickyMembers']);
        //unset($_SESSION['stickyVouchers']);
    }

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

//        if(isset($_SESSION)){
//            for($i = 0; $i < sizeof($_SESSION['stickyVouchers']);$i++){
//               $Vresource[$i] = $_SESSION['stickyVouchers'][i][3];
//               $Vamount[$i] =  $_SESSION['stickyVouchers'][i][2];
//               $Vvoucher[$i] = $_SESSION['stickyVouchers'][i][0];
//               $VcheckNum[$i] = $_SESSION['stickyVouchers'][i][1];
//            }
//
//            $f3->set('resource'.$i,$Vresource);
//            $f3->set('amount',$Vamount);
//            $f3->set('voucher',$Vvoucher);
//            $f3->set('checkNum',$VcheckNum);
//        }


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

//            $needs = new Needs($todaysDate);
//            $needs->setAmount($Vamount);
//            $needs->setCheckNum($VcheckNum);
//            $needs->setResource($Vresource);
//            $needs->setVoucher($Vvoucher);
//
//            //guest object(class)
            //print_r($guest);

            $database = new Database();

            //$todaysDate, for the visitDate
            //$database->insertHousehold(name, age, gender);
            //$database->insertNeeds(resource, visitDate, amount, voucher, checkNum);
            for($i = 0; $i < sizeof($_SESSION['stickyVouchers']);$i++){
                $database->insertNeeds($_SESSION['stickyVouchers'][i][3],$todaysDate,$_SESSION['stickyVouchers'][i][2],
                    $_SESSION['stickyVouchers'][i][0],$_SESSION['stickyVouchers'][i][1]);

            }

            for($j = 0; $j < sizeof($_SESSION['stickyMembers']);$j++){
                $database->insertHousehold($_SESSION['stickyMembers'][i][0],$_SESSION['stickyMembers'][i][1],$_SESSION['stickyMembers'][i][2]);
            }

            $database->insertGuest($guest->getfname(),$guest->getlname(),$guest->getBirthdate(),$guest->getPhone(),
                $guest->getEmail(),$guest->getEthnicity(),$guest->getStreet(),$guest->getCity(),$guest->getZip(),
                $guest->getLicense(),$guest->getPse(),$guest->getWater(),$guest->getIncome(),$guest->getRent(),
                $guest->getFoodStamp(),$guest->getAddSupport(),$guest->getMental(),$guest->getPhysical(),
                $guest->getVeteran(),$guest->getHomeless(),$guest->getMembers(),$guest->getNotes());


        }

    }
    $template = new Template();
    echo $template->render('views/newGuest.html');
}
);

$f3->route('GET|POST /@client_id', function($f3,$params) {
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
    //$f3->set('vouchernum', $guest['first']);


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
        $members = $_POST['members'];
        $notes = $_POST['notes'];
        $vouchers = $_POST['vouchernum'];

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
        $f3->set('vouchers', $vouchers);

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
            $todaysDate = date("Y-m-d");
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
            //$guest->setVoucherNum($vouchers);

            //guest object(class)
            //print_r($guest);

            $database = new Database();
            $database->EditGuest($id,$guest->getfname(),$guest->getlname(),$guest->getBirthdate(),$guest->getPhone(),
                $guest->getEmail(),$guest->getEthnicity(),$guest->getStreet(),$guest->getCity(),$guest->getZip(),
                $guest->getLicense(),$guest->getPse(),$guest->getWater(),$guest->getIncome(),$guest->getRent(),
                $guest->getFoodStamp(),$guest->getAddSupport(),$guest->getMental(),$guest->getPhysical(),
                $guest->getVeteran(),$guest->getHomeless(),$guest->getNotes());

        }


    }

    $template = new Template();
    echo $template->render('views/newGuest.html');

}
);

//demographics
$f3->route('GET /demographics', function($f3)
{
    $database = new Database();
    $ethnicity = $database->getEthnicity();
    $gender = $database->getGender();
    $zips = $database->getZips();
    $disabilities = $database->getDisabilities();
    $veterans = $database->getVeterans();


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