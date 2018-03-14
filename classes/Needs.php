<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 3/14/18
 * Time: 12:40 PM
 */

class Needs extends Guest
{
    private $_resource;
    private $_visitDate;
    private $_amount;
    private $_voucher;
    private $_checkNum;

    /**
     * @return mixed
     */
    public function getResource()
    {
        return $this->_resource;
    }

    /**
     * @param mixed $resource
     */
    public function setResource($resource)
    {
        $this->_resource = $resource;
    }

    /**
     * @return mixed
     */
    public function getVisitDate()
    {
        return $this->_visitDate;
    }

    /**
     * @param mixed $visitDate
     */
    public function setVisitDate($visitDate)
    {
        $this->_visitDate = $visitDate;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->_amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->_amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getVoucher()
    {
        return $this->_voucher;
    }

    /**
     * @param mixed $voucher
     */
    public function setVoucher($voucher)
    {
        $this->_voucher = $voucher;
    }

    /**
     * @return mixed
     */
    public function getCheckNum()
    {
        return $this->_checkNum;
    }

    /**
     * @param mixed $checkNum
     */
    public function setCheckNum($checkNum)
    {
        $this->_checkNum = $checkNum;
    }


}