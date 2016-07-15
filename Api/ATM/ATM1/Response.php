<?php

namespace baibaratsky\WebMoney\Api\ATM\ATM1;

use baibaratsky\WebMoney\Request\AbstractResponse;

/**
 * Class Response
 *
 * @link http://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_ATM1
 */
class Response extends AbstractResponse
{
    /** @var string payment/@currency */
    protected $currency;

    /** @var string payment/@exchange */
    protected $exchange;

    /** @var string payment/purse */
    protected $payeePurse;

    /** @var float payment/upexchange */
    protected $upExchange;

    /** @var float payment/course */
    protected $course;

    /** @var float payment/price */
    protected $price;

    /** @var float payment/amount */
    protected $amount;

    /** @var float payment/rest */
    protected $rest;

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
            $this->currency   = (string) $payment['currency'];
            $this->exchange   = (string) $payment['exchange'];
            $this->payeePurse = (string) $payment->purse;
            $this->upExchange = (float)  $payment->upexchange;
            $this->course     = (float)  $payment->course;
            $this->price      = (float)  $payment->price;
            $this->amount     = (float)  $payment->amount;
            $this->rest       = (float)  $payment->rest;
            $this->dayLimit   = (float)  $payment->limit->day;
            $this->monthLimit = (float)  $payment->limit->month;
        }
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @return string
     */
    public function getExchange()
    {
        return $this->exchange;
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
    public function getUpExchange()
    {
        return $this->upExchange;
    }

    /**
     * @return float
     */
    public function getCourse()
    {
        return $this->course;
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
    public function getRest()
    {
        return $this->rest;
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
