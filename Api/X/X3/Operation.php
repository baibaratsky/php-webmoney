<?php

namespace baibaratsky\WebMoney\Api\X\X3;

class Operation
{
    const STATUS_COMPLETED = 0;
    const STATUS_NOT_COMPLETED = 4;
    const STATUS_REFUNDED = 12;

    /** @deprecated Use STATUS_COMPLETED instead */
    const TYPE_SIMPLE = 0;

    /** @deprecated Use STATUS_NOT_COMPLETED instead */
    const TYPE_PROTECTED_NOT_COMPLETED = 4;

    /** @deprecated Use STATUS_REFUNDED instead */
    const TYPE_PROTECTED_REFUNDED = 12;

    /** @var int @id */
    protected $transactionId;

    /** @var string pursesrc */
    protected $payerPurse;

    /** @var string pursedest */
    protected $payeePurse;

    /** @var float amount */
    protected $amount;

    /** @var float comiss */
    protected $fee;

    /** @var string opertype */
    protected $status;

    /** @var int wminvid */
    protected $invoiceId;

    /** @var int orderid */
    protected $orderId;

    /** @var int tranid */
    protected $transactionExternalId;

    /** @var int period */
    protected $protectionPeriod;

    /** @var string desc */
    protected $description;

    /** @var \DateTime datecrt */
    protected $createDateTime;

    /** @var \DateTime dateupd */
    protected $updateDateTime;

    /** @var string corrwmid */
    protected $correspondentWmid;

    /** @var float rest */
    protected $balance;

    /** @var bool timelock */
    protected $incomplete;

    public function __construct(array $data)
    {
        $this->transactionId = $data['transactionId'];
        $this->payerPurse = $data['payerPurse'];
        $this->payeePurse = $data['payeePurse'];
        $this->amount = $data['amount'];
        $this->fee = $data['fee'];
        $this->status = $data['status'];
        $this->invoiceId = $data['invoiceId'];
        $this->orderId = $data['orderId'];
        $this->transactionExternalId = $data['transactionExternalId'];
        $this->protectionPeriod = $data['protectionPeriod'];
        $this->description = $data['description'];
        $this->createDateTime = $data['createDateTime'];
        $this->updateDateTime = $data['updateDateTime'];
        $this->correspondentWmid = $data['correspondentWmid'];
        $this->balance = $data['balance'];

        if (isset($data['incomplete'])) {
            $this->incomplete = $data['incomplete'];
        }
    }

    /**
     * @return int
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * @return string
     */
    public function getPayerPurse()
    {
        return $this->payerPurse;
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
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return float
     */
    public function getFee()
    {
        return $this->fee;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @deprecated Use getStatus() instead
     * @return string
     */
    public function getOperationType()
    {
        return $this->getStatus();
    }

    /**
     * @return int
     */
    public function getInvoiceId()
    {
        return $this->invoiceId;
    }

    /**
     * @return int
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @return int
     */
    public function getTransactionExternalId()
    {
        return $this->transactionExternalId;
    }

    /**
     * @return int
     */
    public function getProtectionPeriod()
    {
        return $this->protectionPeriod;
    }

    /**
     * @deprecated Use getProtectionPeriod() instead
     * @return int
     */
    public function getPeriod()
    {
        return $this->getProtectionPeriod();
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
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
    public function getCreateDateTime()
    {
        return $this->createDateTime;
    }

    /**
     * @return string
     */
    public function getCorrespondentWmid()
    {
        return $this->correspondentWmid;
    }

    /**
     * @return float
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * @return boolean
     */
    public function getIncomplete()
    {
        return $this->incomplete;
    }
}
