<?php

namespace baibaratsky\WebMoney\Api\WMC\WMC1;

use baibaratsky\WebMoney\Request\AbstractResponse;

/**
 * Class Response
 *
 * @link http://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_WMC1
 */
class Response extends AbstractResponse
{
    /** @var string payment/@currency */
    protected $currency;

    /** @var string payment/@merchant */
    protected $merchant;

    /** @var string payment/@status */
    protected $status;

    /** @var string payment/purse */
    protected $payeePurse;

    /** @var string payment/phone */
    protected $phone;

    /** @var float payment/price */
    protected $price;

    /** @var float payment/amount */
    protected $amount;

    /** @var float payment/limit */
    protected $limit;

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
            $this->currency = (string)$payment['currency'];
            $this->merchant = (int)$payment['merchant'];
            $this->status = (string)$payment['status'];
            $this->payeePurse = (string)$payment->purse;
            $this->phone = (string)$payment->phone;
            $this->price = (float)$payment->price;
            $this->amount = (float)$payment->amount;
            $this->limit = (float)$payment->limit;
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
     * @return int
     */
    public function getMerchant()
    {
        return $this->merchant;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
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
    public function getLimit()
    {
        return $this->limit;
    }
}
