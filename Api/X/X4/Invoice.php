<?php

namespace baibaratsky\WebMoney\Api\X\X4;

class Invoice
{
    const STATUS_NOT_PAID = 0;
    const STATUS_PAID_WITH_PROTECTION = 1;
    const STATUS_PAID = 2;
    const STATUS_DECLINED = 3;

    /** @var int @id */
    protected $id;

    /** @var string orderid */
    protected $orderId;

    /** @var string customerwmid */
    protected $customerWmid;

    /** @var string storepurse */
    protected $purse;

    /** @var float amount */
    protected $amount;

    /** @var string desc */
    protected $description;

    /** @var string address */
    protected $address;

    /** @var int period */
    protected $protectionPeriod;

    /** @var int expiration */
    protected $expiration;

    /** @var int state */
    protected $status;

    /** @var int wmtranid */
    protected $transactionId;

    /** @var \DateTime datecrt */
    protected $createDateTime;

    /** @var \DateTime dateupd */
    protected $updateDateTime;

    /** @var string customerpurse */
    protected $customerPurse;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->orderId = $data['orderId'];
        $this->customerWmid = $data['customerWmid'];
        $this->purse = $data['purse'];
        $this->amount = $data['amount'];
        $this->description = $data['description'];
        $this->address = $data['address'];
        $this->protectionPeriod = $data['protectionPeriod'];
        $this->expiration = $data['expiration'];
        $this->status = $data['status'];
        $this->createDateTime = $data['createDateTime'];
        $this->updateDateTime = $data['updateDateTime'];
        $this->transactionId = $data['transactionId'];
        $this->customerPurse = $data['customerPurse'];

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
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return int
     */
    public function getProtectionPeriod()
    {
        return $this->protectionPeriod;
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
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return int
     */
    public function getTransactionId()
    {
        return $this->transactionId;
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
