<?php

namespace baibaratsky\WebMoney\Api\ATM\ATM2;

use baibaratsky\WebMoney\Request\AbstractResponse;

/**
 * Class Response
 *
 * @link http://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_ATM2
 */
class Response extends AbstractResponse
{
    /** @var string payment/@id */
    protected $id;

    /** @var string payment/@currency */
    protected $currency;

    /** @var int payment/@test */
    protected $test;

    /** @var string payment/purse */
    protected $payeePurse;

    /** @var float payment/price */
    protected $price;

    /** @var float payment/amount */
    protected $amount;

    /** @var float payment/comiss */
    protected $comiss;

    /** @var float payment/rest */
    protected $rest;

    /** @var string payment/date */
    protected $date;

    /** @var int payment/point */
    protected $point;

    /** @var int payment/wmtranid */
    protected $wmtranid;

    /** @var string payment/dateupd */
    protected $dateupd;

    /** @var float payment/limit/day */
    protected $dayLimit;

    /** @var float payment/limit/month */
    protected $monthLimit;

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $responseObject = new \SimpleXMLElement($response);
        $this->returnCode = (int)$responseObject->retval;
        $this->returnDescription = (string)$responseObject->retdesc;

        if (isset($responseObject->payment)) {
            $payment = $responseObject->payment;
            $this->id         = (int)    $payment['id'];
            $this->currency   = (string) $payment['currency'];
            $this->test       = (int)    $payment['test'];
            $this->payeePurse = (string) $payment->purse;
            $this->price      = (float)  $payment->price;
            $this->amount     = (float)  $payment->amount;
            $this->comiss     = (float)  $payment->comiss;
            $this->rest       = (float)  $payment->rest;
            $this->date       = (string) $payment->date;
            $this->point      = (int)    $payment->point;
            $this->wmtranid   = (int)    $payment->wmtranid;
            $this->dateupd    = (string) $payment->dateupd;
            $this->dayLimit   = (float)  $payment->limit->day;
            $this->monthLimit = (float)  $payment->limit->month;
        }
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
     * @return string
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
     * @return string
     */
    public function getDateupd()
    {
        return $this->dateupd;
    }

    /**
     * @return float
     */
    public function getDayLimit()
    {
        return $this->dayLimit;
    }

    /**
     * @return float
     */
    public function getMonthLimit()
    {
        return $this->monthLimit;
    }
}
