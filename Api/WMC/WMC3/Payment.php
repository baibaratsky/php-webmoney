<?php

namespace baibaratsky\WebMoney\Api\WMC\WMC3;

use DateTime;

class Payment
{
    /** @var int @id */
    protected $id;

    /** @var string @merchant */
    protected $currency;

    /** @var string @status */
    protected $status;

    /** @var string @test */
    protected $test;

    /** @var string purse */
    protected $payeePurse;

    /** @var string phone */
    protected $phone;

    /** @var float price */
    protected $price;

    /** @var float amount */
    protected $amount;

    /** @var float comiss */
    protected $comiss;

    /** @var DateTime date */
    protected $date;

    /** @var int point */
    protected $point;

    /** @var float rest */
    protected $rest;

    /** @var int wmtranid */
    protected $wmtranid;

    /** @var DateTime dateupd */
    protected $dateupd;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->currency = $data['currency'];
        $this->test = $data['test'];
        $this->payeePurse = $data['purse'];
        $this->phone = $data['phone'];
        $this->price = $data['price'];
        $this->amount = $data['amount'];
        $this->comiss = $data['comiss'];
        $this->rest = $data['rest'];
        $this->date = $data['date'];
        $this->point = $data['point'];
        $this->wmtranid = $data['wmtranid'];
        $this->dateupd = $data['dateupd'];
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @return int
     */
    public function getTest()
    {
        return $this->test;
    }

    /**
     * @return string
     */
    public function getPayeePurse()
    {
        return $this->payeePurse;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return float
     */
    public function getComiss()
    {
        return $this->comiss;
    }

    /**
     * @return float
     */
    public function getRest()
    {
        return $this->rest;
    }

    /**
     * @return DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return int
     */
    public function getPoint()
    {
        return $this->point;
    }

    /**
     * @return int
     */
    public function getWmtranid()
    {
        return $this->wmtranid;
    }

    /**
     * @return DateTime
     */
    public function getDateupd()
    {
        return $this->dateupd;
    }
}
