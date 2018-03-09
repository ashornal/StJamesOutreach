<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 3/7/2018
 * Time: 12:55 PM
 */

class Guest
{
    protected $fname;
    protected $lname;
    protected $birthdate;
    protected $phone;
    protected $email;
    protected $ethnicity;
    protected $street;
    protected $city;
    protected $zip;
    protected $license;
    protected $pse;
    protected $water;
    protected $income;
    protected $rent;
    protected $foodStamp;
    protected $addSupport;
    protected $mental;
    protected $physical;
    protected $veteran;
    protected $homeless;
    protected $members;
    protected $notes;

    function __construct($fname,$lname,$birthdate){
        $this->fname = $fname;
        $this->lname = $lname;
        $this->birthdate = $birthdate;
    }

    //first name
    public function getfname(){
        return $this->fname;
    }
    public function setfname($name){
        $this->fname = $name;
    }

    //last name
    public function setlname($name){
        $this->lname = $name;
    }
    public function getlname(){
        return $this->lname;
    }

    //birthdate
    public function setBirthdate($date){
        $this->birthdate = $date;
    }
    public function getBirthdate(){
        return $this->birthdate;
    }

    //phone number
    public function setPhone($phone){
        $this->phone = $phone;
    }
    public function getPhone(){
        return $this->phone;
    }

    //email
    public function setEmail($email){
        $this->email = $email;
    }
    public function getEmail(){
        return $this->email;
    }

    //ethnicity
    public function setEthnicity($eth){
        $this->ethnicity = $eth;
    }
    public function getEthnicity(){
        return $this->ethnicity;
    }

    //street
    public function setStreet($street){
        $this->street = $street;
    }
    public function getStreet(){
        return $this->street;
    }

    //city
    public function setCity($city){
        $this->city = $city;
    }
    public function getCity(){
        return $this->city;
    }

    //zip
    public function setZip($zip){
        $this->zip = $zip;
    }
    public function getZip(){
        return $this->zip;
    }

    //license
    public function setLicense($license){
        $this->license = $license;
    }
    public function getLicense(){
        return $this->license;
    }

    //pse
    public function setPse($pse){
        $this->pse = $pse;
    }
    public function getPse(){
        return $this->pse;
    }

    //water
    public function setWater($water){
        $this->water = $water;
    }
    public function getWater(){
        return $this->water;
    }

    /**
     * @return mixed
     */
    public function getRent()
    {
        return $this->rent;
    }

    /**
     * @param mixed $rent
     */
    public function setRent($rent)
    {
        $this->rent = $rent;
    }


    /**
     * @return mixed
     */
    public function getIncome()
    {
        return $this->income;
    }

    /**
     * @param mixed $income
     */
    public function setIncome($income)
    {
        $this->income = $income;
    }

    /**
     * @return mixed
     */
    public function getFoodStamp()
    {
        return $this->foodStamp;
    }

    /**
     * @param mixed $foodStamp
     */
    public function setFoodStamp($foodStamp)
    {
        $this->foodStamp = $foodStamp;
    }

    /**
     * @return mixed
     */
    public function getAddSupport()
    {
        return $this->addSupport;
    }

    /**
     * @param mixed $addSupport
     */
    public function setAddSupport($addSupport)
    {
        $this->addSupport = $addSupport;
    }

    /**
     * @return mixed
     */
    public function getMental()
    {
        return $this->mental;
    }

    /**
     * @param mixed $mental
     */
    public function setMental($mental)
    {
        $this->mental = $mental;
    }

    /**
     * @return mixed
     */
    public function getPhysical()
    {
        return $this->physical;
    }

    /**
     * @param mixed $physical
     */
    public function setPhysical($physical)
    {
        $this->physical = $physical;
    }

    /**
     * @return mixed
     */
    public function getVeteran()
    {
        return $this->veteran;
    }

    /**
     * @param mixed $veteran
     */
    public function setVeteran($veteran)
    {
        $this->veteran = $veteran;
    }

    /**
     * @return mixed
     */
    public function getHomeless()
    {
        return $this->homeless;
    }

    /**
     * @param mixed $homeless
     */
    public function setHomeless($homeless)
    {
        $this->homeless = $homeless;
    }

    /**
     * @return mixed
     */
    public function getMembers()
    {
        return $this->members;
    }

    /**
     * @param mixed $members
     */
    public function setMembers($members)
    {
        $this->members = $members;
    }

    /**
     * @return mixed
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @param mixed $notes
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    }


}