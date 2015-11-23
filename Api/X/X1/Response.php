<?php

namespace baibaratsky\WebMoney\Api\X\X1;

use baibaratsky\WebMoney\Request\AbstractResponse;

/**
 * Class Response
 *
 * @link https://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X1
 */
class Response extends AbstractResponse
{
    /** @var int @id */
    protected $invoiceid;

    /** @var int @ts */
    protected $invoicets;

    /** @var int invoice/orderid */
    protected $orderid;

    /** @var int invoice/customerwmid */
    protected $customerwmid;

    /** @var string invoice/storepurse */
    protected $storepurse;

    /** @var float invoice/amount */
    protected $amount;

    /** @var string invoice/desc */
    protected $desc;

    /** @var string invoice/address */
    protected $address;

    /** @var int invoice/period */
    protected $period;

    /** @var int invoice/expiration */
    protected $expiration;

    /** @var int invoice/state */
    protected $state;

    /** @var \DateTime invoice/datecrt */
    protected $datecrt;

    /** @var \DateTime invoice/dateupd */
    protected $dateupd;

    public function __construct($response)
    {
        $responseObject = new \SimpleXMLElement($response);
        $this->requestNumber = (int)$responseObject->reqn;
        $this->returnCode = (int)$responseObject->retval;
        $this->returnDescription = (string)$responseObject->retdesc;

        if (isset($responseObject->invoice)) {
            $invoice = $responseObject->invoice;
            $this->invoiceid = (int)$invoice['id'];
            $this->invoicets = (int)$invoice['ts'];
            $this->orderid = (string)$invoice->orderid;
            $this->customerwmid = (string)$invoice->customerwmid;
            $this->storepurse = (string)$invoice->storepurse;
            $this->amount = (float)$invoice->amount;
            $this->desc = (string)$invoice->desc;
            $this->address = (string)$invoice->address;
            $this->period = (int)$invoice->period;
            $this->expiration = (int)$invoice->expiration;
            $this->state = (int)$invoice->state;
            $this->datecrt = (string)$invoice->datecrt; //wm format Ymd H:i:s
            $this->dateupd = (string)$invoice->dateupd; //wm format Ymd H:i:s
        }
    }

    /**
     * @return int
     */
    public function getInvoiceid()
    {
        return $this->invoiceid;
    }

    /**
     * @return int
     */
    public function getInvoicets()
    {
        return $this->invoicets;
    }

    /**
     * @return string
     */
    public function getOrderid()
    {
        return $this->orderid;
    }

    /**
     * @return string
     */
    public function getCustomerwmid()
    {
        return $this->customerwmid;
    }

    /**
     * @return string
     */
    public function getStorepurse()
    {
        return $this->storepurse;
    }

    /**
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return float
     */
    public function getDesc()
    {
        return $this->desc;
    }

    /**
     * @return float
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getPeriod()
    {
        return $this->period;
    }

    /**
     * @return int
     */
    public function getExpiration()
    {
        return $this->expiration;
    }

    /**
     * @return int
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return \DateTime
     */
    public function getDatecrt()
    {
        return $this->datecrt;
    }

    /**
     * @return \DateTime
     */
    public function getDateupd()
    {
        return $this->dateupd;
    }
}
