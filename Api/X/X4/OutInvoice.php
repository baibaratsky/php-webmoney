<?php

namespace app\components\wm\Api\X\X4;

class OutInvoice
{
    /** @var int @id */
    protected $outInvoiceId;

    /** @var int orderid */
    protected $orderId;

    /** @var string customerwmid */
    protected $customerWmid;

    /** @var float storepurse */
    protected $purse;

    /** @var float amount */
    protected $amount;

    /** @var string desc */
    protected $description;

    /** @var string address */
    protected $address;

    /** @var int period */
    protected $period;

    /** @var int expiration */
    protected $expiration;

    /** @var int state */
    protected $state;

    /** @var int wmtranid */
    protected $wmtranid;

    /** @var \DateTime datecrt */
    protected $createDateTime;

    /** @var \DateTime dateupd */
    protected $updateDateTime;

    /** @var string customerpurse */
    protected $customerPurse;

    public function __construct(array $data)
    {
        $this->outInvoiceId = $data['outInvoiceId'];
        $this->orderId = $data['orderId'];
        $this->customerWmid = $data['customerWmid'];
        $this->purse = $data['purse'];
        $this->amount = $data['amount'];
        $this->description = $data['description'];
        $this->address = $data['address'];
        $this->period = $data['period'];
        $this->expiration = $data['expiration'];
        $this->state = $data['state'];
        $this->createDateTime = new \DateTime($data['createDateTime']);
        $this->updateDateTime = new \DateTime($data['updateDateTime']);
        $this->wmtranid = $data['wmtranid'];
        $this->customerPurse = $data['customerPurse'];

    }
    /**
     * @return int
     */
    public function getOutInvoiceid()
    {
        return $this->outInvoiceid;
    }

    /**
     * @return string
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @return string
     */
    public function getCustomerWmid()
    {
        return $this->customerWmid;
    }

    /**
     * @return string
     */
    public function getPurse()
    {
        return $this->purse;
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
    public function getDescription()
    {
        return $this->description;
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
     * @return int
     */
    public function getWmtranid()
    {
        return $this->wmtranid;
    }

    /**
     * @return \DateTime
     */
    public function getCreateDateTime()
    {
        return $this->createDateTime;
    }

    /**
     * @return \DateTime
     */
    public function getUpdateDateTime()
    {
        return $this->updateDateTime;
    }

    /**
     * @return \DateTime
     */
    public function getCustomerPurse()
    {
        return $this->customerPurse;
    }
}
