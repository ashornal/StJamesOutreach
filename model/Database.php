<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 3/9/2018
 * Time: 11:31 AM
 */

/*
 * CREATE TABLE IF NOT EXISTS `Guests` (
  `ClientId` INT NOT NULL AUTO_INCREMENT,
  `first` VARCHAR(45) NOT NULL,
  `last` VARCHAR(45) NOT NULL,
  `birthdate` VARCHAR(45) NOT NULL,
  `phone` VARCHAR(11) NULL,
  `email` VARCHAR(100) NOT NULL,
  `ethnicity` VARCHAR(20) NULL,
  `street` VARCHAR(45) NULL,
  `city` VARCHAR(45) NULL,
  `zip` VARCHAR(5) NULL,
  `license` VARCHAR(15) NULL,
  `pse` VARCHAR(15) NULL,
  `water` VARCHAR(15) NULL,
  `income` FLOAT(8,2) NULL,
  `rent` FLOAT(8,2) NULL,
  `foodStamp` FLOAT(8,2) NULL,
  `addSupport` FLOAT(8,2) NULL,
  `mental` VARCHAR(1) NULL,
  `physical` VARCHAR(1) NULL,
  `veteran` VARCHAR(1) NULL,
  `homeless` VARCHAR(1) NULL,
  `members` TINYINT(2) NULL,
  `notes` TEXT NULL,
  PRIMARY KEY (`ClientId`))
;

CREATE TABLE IF NOT EXISTS `Household` (
  `name` VARCHAR(100) NOT NULL,
  `age` INT(3) NULL,
  `gender` VARCHAR(6) NOT NULL,
  `Guests_ClientId` INT NOT NULL,
  INDEX `fk_Household_Guests1_idx` (`Guests_ClientId` ASC),
  CONSTRAINT `fk_Household_Guests1`
    FOREIGN KEY (`Guests_ClientId`)
    REFERENCES `Guests` (`ClientId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
;


CREATE TABLE IF NOT EXISTS `Needs` (
  `resource` VARCHAR(50) NULL,
  `visitDate` DATE NULL,
  `amount` FLOAT(10,2) NULL,
  `voucher` VARCHAR(15) NULL,
  `checkNum` VARCHAR(15) NULL,
  `Guests_ClientId` INT NOT NULL,
  INDEX `fk_Needs_Guests1_idx` (`Guests_ClientId` ASC),
  CONSTRAINT `fk_Needs_Guests1`
    FOREIGN KEY (`Guests_ClientId`)
    REFERENCES `Guests` (`ClientId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
;

 */
require_once '/home/pvashchu/config2.php';
class Database
{
    protected $dbh;

    function __construct()
    {
        try {
            //Instantiate a database object
            $this->dbh = new PDO(DB_DSN, DB_USERNAME,
                DB_PASSWORD );
            //echo "Connected to database!!!";
        }
        catch (PDOException $e) {
            echo $e->getMessage();

        }
    }

    function insertGuest($first, $last, $birthdate, $phone, $email, $ethnicity, $street, $city, $zip, $license, $pse, $water, $income, $rent, $foodStamp, $addSupport, $mental, $physical, $veteran, $homeless, $members, $notes)
    {
        //global $dbh;

        //1. Define the query
         $sql= "INSERT INTO Guests (first, last, birthdate, phone, email, ethnicity, street, city, zip, license, pse, water, income, rent, foodStamp, addSupport, mental, physical, veteran, homeless, members, notes)
						VALUES (:first, :last,:birthdate, :phone, :email, :ethnicity, :street, :city, :zip, :license, :pse, :water, :income, :rent, :foodStamp, :addSupport, :mental, :physical, :veteran, :homeless, :members, :notes)";

        //2. Prepare the statement
        $statement = $this->dbh->prepare($sql);


        //3. Bind parameters
        $statement->bindParam(':first', $first, PDO::PARAM_STR);
        $statement->bindParam(':last', $last, PDO::PARAM_STR);
        $statement->bindParam(':birthdate', $birthdate, PDO::PARAM_STR);
        $statement->bindParam(':phone', $phone, PDO::PARAM_STR);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':ethnicity', $ethnicity, PDO::PARAM_STR);
        $statement->bindParam(':street', $street, PDO::PARAM_STR);
        $statement->bindParam(':city', $city, PDO::PARAM_STR);
        $statement->bindParam(':zip', $zip, PDO::PARAM_STR);
        $statement->bindParam(':license', $license, PDO::PARAM_STR);
        $statement->bindParam(':pse', $pse, PDO::PARAM_STR);
        $statement->bindParam(':water', $water, PDO::PARAM_STR);
        $statement->bindParam(':income', $income, PDO::PARAM_STR);
        $statement->bindParam(':rent', $rent, PDO::PARAM_STR);
        $statement->bindParam(':foodStamp', $foodStamp, PDO::PARAM_STR);
        $statement->bindParam(':addSupport', $addSupport, PDO::PARAM_STR);
        $statement->bindParam(':mental', $mental, PDO::PARAM_STR);
        $statement->bindParam(':physical', $physical, PDO::PARAM_STR);
        $statement->bindParam(':veteran', $veteran, PDO::PARAM_STR);
        $statement->bindParam(':homeless', $homeless, PDO::PARAM_STR);
        $statement->bindParam(':members', $members, PDO::PARAM_STR);
        $statement->bindParam(':notes', $notes, PDO::PARAM_STR);

        //4. Execute the query
        $statement->execute();

        $id = $this->dbh->lastInsertId();
    }

    function getGuests()
    {
        // Define the query
        $sql = "SELECT * FROM Guests LEFT JOIN Needs ON  Guests.ClientId = Needs.Guests_ClientId ORDER BY visitDate";
        // Prepare the statement
        $statement = $this->dbh->prepare($sql);
        // Execute the statement
        $statement->execute();
        // Process the result
        $row = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }

    function getGuest($id)
    {
        // Define the query
        $sql = "SELECT * FROM Guests WHERE ClientID = $id";
        // Prepare the statement
        $statement = $this->dbh->prepare($sql);
        // Execute the statement
        $statement->execute();
        // Process the result
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    function insertHousehold($name, $age, $gender){
        $sql= "INSERT INTO Household (name, age, gender)
                VALUES (:name,:age,:gender)";
        $statement = $this->dbh->prepare($sql);

        $statement->bindParam(':name', $name, PDO::PARAM_STR);
        $statement->bindParam(':age', $name, PDO::PARAM_STR);
        $statement->bindParam(':gender', $gender, PDO::PARAM_STR);

        $statement->execute();
    }

    function insertNeeds($resource, $visitDate, $amount, $voucher, $checkNum){
        $sql= "INSERT INTO Needs (resource, visitDate, amount, voucher, checkNum)
                VALUES (:resource, :visitDate, :amount, :voucher, :checkNum)";
        $statement = $this->dbh->prepare($sql);

        $statement->bindParam(':resource', $resource, PDO::PARAM_STR);
        $statement->bindParam(':visitDate', $visitDate, PDO::PARAM_STR);
        $statement->bindParam(':amount', $amount, PDO::PARAM_STR);
        $statement->bindParam(':voucher', $voucher, PDO::PARAM_STR);
        $statement->bindParam(':checkNum', $checkNum, PDO::PARAM_STR);

        $statement->execute();
    }

    function getHouseholds()
    {
        // Define the query
        $sql = "SELECT * FROM Guests LEFT JOIN Household ON  Guests.ClientId = Household.Guests_ClientId";
        // Prepare the statement
        $statement = $this->dbh->prepare($sql);
        // Execute the statement
        $statement->execute();
        // Process the result
        $row = $statement->fetchAll(PDO::FETCH_ASSOC);
        //echo"<pre>";var_dump($row);echo"</pre>";

        return $row;
    }

    function editGuest($id, $first, $last, $birthdate, $phone, $email, $ethnicity, $street, $city, $zip, $license,
                       $pse, $water, $income, $rent, $foodStamp, $addSupport, $mental, $physical, $veteran, $homeless, $notes){
        $sql = "DELETE FROM Guests WHERE ClientID = $id";

        $statement = $this->dbh->prepare($sql);

        $statement->execute();

        $sql= "INSERT INTO Guests (first, last, birthdate, phone, email, ethnicity, street, city, zip, license, pse, water, income, rent, foodStamp, addSupport, mental, physical, veteran, homeless, notes)
						VALUES (:first, :last,:birthdate, :phone, :email, :ethnicity, :street, :city, :zip, :license, :pse, :water, :income, :rent, :foodStamp, :addSupport, :mental, :physical, :veteran, :homeless, :notes)";

        $statement = $this->dbh->prepare($sql);


        //3. Bind parameters
        $statement->bindParam(':first', $first, PDO::PARAM_STR);
        $statement->bindParam(':last', $last, PDO::PARAM_STR);
        $statement->bindParam(':birthdate', $birthdate, PDO::PARAM_STR);
        $statement->bindParam(':phone', $phone, PDO::PARAM_STR);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':ethnicity', $ethnicity, PDO::PARAM_STR);
        $statement->bindParam(':street', $street, PDO::PARAM_STR);
        $statement->bindParam(':city', $city, PDO::PARAM_STR);
        $statement->bindParam(':zip', $zip, PDO::PARAM_STR);
        $statement->bindParam(':license', $license, PDO::PARAM_STR);
        $statement->bindParam(':pse', $pse, PDO::PARAM_STR);
        $statement->bindParam(':water', $water, PDO::PARAM_STR);
        $statement->bindParam(':income', $income, PDO::PARAM_STR);
        $statement->bindParam(':rent', $rent, PDO::PARAM_STR);
        $statement->bindParam(':foodStamp', $foodStamp, PDO::PARAM_STR);
        $statement->bindParam(':addSupport', $addSupport, PDO::PARAM_STR);
        $statement->bindParam(':mental', $mental, PDO::PARAM_STR);
        $statement->bindParam(':physical', $physical, PDO::PARAM_STR);
        $statement->bindParam(':veteran', $veteran, PDO::PARAM_STR);
        $statement->bindParam(':homeless', $homeless, PDO::PARAM_STR);
        //$statement->bindParam(':members', $members, PDO::PARAM_STR);
        //$statement->bindParam(':voucher', $voucher, PDO::PARAM_STR);
        $statement->bindParam(':notes', $notes, PDO::PARAM_STR);




        //4. Execute the query
        $statement->execute();

    }

    function getThrift($start, $end)
    {
        // Define the query
        $sql = "SELECT COUNT(amount), SUM(amount) FROM Needs
								WHERE visitDate BETWEEN '$start' AND '$end'
								AND resource = 'thrift'";
        // Prepare the statement
        $statement = $this->dbh->prepare($sql);
        // Execute the statement
        $statement->execute();
        // Process the result
        $row = $statement->fetchAll(PDO::FETCH_ASSOC);
        //echo"<pre>";var_dump($row);echo"</pre>";

        return $row;
    }
    function getGas($start, $end)
    {
        // Define the query
        $sql = "SELECT COUNT(amount), SUM(amount) FROM Needs
								WHERE visitDate BETWEEN '$start' AND '$end'
								AND resource = 'gas'";
        // Prepare the statement
        $statement = $this->dbh->prepare($sql);
        // Execute the statement
        $statement->execute();
        // Process the result
        $row = $statement->fetchAll(PDO::FETCH_ASSOC);
        //echo"<pre>";var_dump($row);echo"</pre>";

        return $row;
    }
    function getWater($start, $end)
    {
        // Define the query
        $sql = "SELECT COUNT(amount), SUM(amount) FROM Needs
								WHERE visitDate BETWEEN '$start' AND '$end'
								AND resource = 'waterbill'";
        // Prepare the statement
        $statement = $this->dbh->prepare($sql);
        // Execute the statement
        $statement->execute();
        // Process the result
        $row = $statement->fetchAll(PDO::FETCH_ASSOC);
        //echo"<pre>";var_dump($row);echo"</pre>";

        return $row;
    }
    function getEnergy($start, $end)
    {
        // Define the query
        $sql = "SELECT COUNT(amount), SUM(amount) FROM Needs
								WHERE visitDate BETWEEN '$start' AND '$end'
								AND resource = 'energybill'";
        // Prepare the statement
        $statement = $this->dbh->prepare($sql);
        // Execute the statement
        $statement->execute();
        // Process the result
        $row = $statement->fetchAll(PDO::FETCH_ASSOC);
        //echo"<pre>";var_dump($row);echo"</pre>";

        return $row;
    }
    function getFood($start, $end)
    {
        // Define the query
        $sql = "SELECT COUNT(amount), SUM(amount) FROM Needs
								WHERE visitDate BETWEEN '$start' AND '$end'
								AND resource = 'food'";
        // Prepare the statement
        $statement = $this->dbh->prepare($sql);
        // Execute the statement
        $statement->execute();
        // Process the result
        $row = $statement->fetchAll(PDO::FETCH_ASSOC);
        //echo"<pre>";var_dump($row);echo"</pre>";

        return $row;
    }
    function getDol($start, $end)
    {
        // Define the query
        $sql = "SELECT COUNT(amount), SUM(amount) FROM Needs
								WHERE visitDate BETWEEN '$start' AND '$end'
								AND resource = 'dol'";
        // Prepare the statement
        $statement = $this->dbh->prepare($sql);
        // Execute the statement
        $statement->execute();
        // Process the result
        $row = $statement->fetchAll(PDO::FETCH_ASSOC);
        //echo"<pre>";var_dump($row);echo"</pre>";

        return $row;
    }
    function getOther($start, $end)
    {
        // Define the query
        $sql = "SELECT COUNT(amount), SUM(amount) FROM Needs
								WHERE visitDate BETWEEN '$start' AND '$end'
								AND resource = 'other'";
        // Prepare the statement
        $statement = $this->dbh->prepare($sql);
        // Execute the statement
        $statement->execute();
        // Process the result
        $row = $statement->fetchAll(PDO::FETCH_ASSOC);
        //echo"<pre>";var_dump($row);echo"</pre>";

        return $row;
    }
    function getTotal($start, $end)
    {
        // Define the query
        $sql = "SELECT COUNT(amount), SUM(amount) FROM Needs
								WHERE visitDate BETWEEN '$start' AND '$end'";
        // Prepare the statement
        $statement = $this->dbh->prepare($sql);
        // Execute the statement
        $statement->execute();
        // Process the result
        $row = $statement->fetchAll(PDO::FETCH_ASSOC);
        //echo"<pre>";var_dump($row);echo"</pre>";

        return $row;
    }
}