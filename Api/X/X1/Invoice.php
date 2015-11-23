<?php

namespace baibaratsky\WebMoney\Api\X\X1;

class Invoice
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

    public function __construct(array $data)
    {
        $this->invoiceid    = $data['invoiceid'];
        $this->invoicets    = $data['invoicets'];
        $this->orderid      = $data['orderid'];
        $this->customerwmid = $data['customerwmid'];
        $this->storepurse   = $data['storepurse'];
        $this->amount       = $data['amount'];
        $this->desc         = $data['desc'];
        $this->address      = $data['address'];
        $this->period       = $data['period'];
        $this->expiration   = $data['expiration'];
        $this->state        = $data['state'];
        $this->datecrt      = $data['datecrt']; //wm format Ymd H:i:s
        $this->dateupd      = $data['dateupd']; //wm format Ymd H:i:s
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
