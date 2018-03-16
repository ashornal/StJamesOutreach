<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 3/14/18
 * Time: 12:40 PM
 */

class Needs
{
    protected $resource;
    protected $visitDate;
    protected $amount;
    protected $voucher;
    protected $checkNum;

    function __construct($visitDate){
        $this->visitDate = $visitDate;
    }

    /**
     * @return mixed
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @param mixed $resource
     */
    public function setResource($resource)
    {
        $this->resource = $resource;
    }

    /**
     * @return mixed
     */
    public function getVisitDate()
    {
        return $this->visitDate;
    }

    /**
     * @param mixed $visitDate
     */
    public function setVisitDate($visitDate)
    {
        $this->visitDate = $visitDate;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getVoucher()
    {
        return $this->voucher;
    }

    /**
     * @param mixed $voucher
     */
    public function setVoucher($voucher)
    {
        $this->voucher = $voucher;
    }

    /**
     * @return mixed
     */
    public function getCheckNum()
    {
        return $this->checkNum;
    }

    /**
     * @param mixed $checkNum
     */
    public function setCheckNum($checkNum)
    {
        $this->checkNum = $checkNum;
    }


}