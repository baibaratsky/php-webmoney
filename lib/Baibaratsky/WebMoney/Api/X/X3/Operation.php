<?php
namespace Baibaratsky\WebMoney\Api\X\X3;

class Operation
{
    const TYPE_SIMPLE = 0;
    const TYPE_PROTECTED_NOT_COMPLETED = 4;
    const TYPE_PROTECTED_REFUNDED = 12;

    /** @var int */
    protected $_invoiceId;

    /** @var int */
    protected $_systemInvoiceId;

    /** @var string pursesrc */
    protected $_senderPurse;

    /** @var string pursedest */
    protected $_recipientPurse;

    /** @var float amount */
    protected $_amount;

    /** @var float comiss */
    protected $_fee;

    /** @var string opertype */
    protected $_operationType;

    /** @var int wminvid */
    protected $_wmInvoiceNumber;

    /** @var int orderid */
    protected $_externalInvoiceId;

    /** @var int tranid */
    protected $_transactionId;

    /** @var int period */
    protected $_period;

    /** @var string desc */
    protected $_description;

    /** @var \DateTime datecrt */
    protected $_createDateTime;

    /** @var \DateTime dateupd */
    protected $_updateDateTime;

    /** @var string corrwmid */
    protected $_correspondentWmid;

    /** @var float rest */
    protected $_balance;

    /** @var bool timelock */
    protected $_incomplete;

    public function __construct(array $data)
    {
        $this->_invoiceId = $data['invoiceId'];
        $this->_systemInvoiceId = $data['systemInvoiceId'];
        $this->_senderPurse = $data['senderPurse'];
        $this->_recipientPurse = $data['recipientPurse'];
        $this->_amount = $data['amount'];
        $this->_fee = $data['fee'];
        $this->_operationType = $data['operationType'];
        $this->_wmInvoiceNumber = $data['wmInvoiceNumber'];
        $this->_externalInvoiceId = $data['externalInvoiceId'];
        $this->_transactionId = $data['transactionId'];
        $this->_period = $data['period'];
        $this->_description = $data['description'];
        $this->_createDateTime = new \DateTime($data['createDateTime']);
        $this->_updateDateTime = new \DateTime($data['updateDateTime']);
        $this->_correspondentWmid = $data['correspondentWmid'];
        $this->_balance = $data['balance'];

        if (isset($data['incomplete'])) {
            $this->_incomplete = $data['incomplete'];
        }
    }

    /**
     * @return int
     */
    public function getInvoiceId()
    {
        return $this->_invoiceId;
    }

    /**
     * @return int
     */
    public function getSystemInvoiceId()
    {
        return $this->_systemInvoiceId;
    }

    /**
     * @return string
     */
    public function getSenderPurse()
    {
        return $this->_senderPurse;
    }

    /**
     * @return string
     */
    public function getRecipientPurse()
    {
        return $this->_recipientPurse;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->_amount;
    }

    /**
     * @return float
     */
    public function getFee()
    {
        return $this->_fee;
    }

    /**
     * @return string
     */
    public function getOperationType()
    {
        return $this->_operationType;
    }

    /**
     * @return int
     */
    public function getWmInvoiceNumber()
    {
        return $this->_wmInvoiceNumber;
    }

    /**
     * @return int
     */
    public function getExternalInvoiceId()
    {
        return $this->_externalInvoiceId;
    }

    /**
     * @return int
     */
    public function getTransactionId()
    {
        return $this->_transactionId;
    }

    /**
     * @return int
     */
    public function getPeriod()
    {
        return $this->_period;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->_description;
    }

    /**
     * @return \DateTime
     */
    public function getUpdateDateTime()
    {
        return $this->_updateDateTime;
    }

    /**
     * @return \DateTime
     */
    public function getCreateDateTime()
    {
        return $this->_createDateTime;
    }

    /**
     * @return string
     */
    public function getCorrespondentWmid()
    {
        return $this->_correspondentWmid;
    }

    /**
     * @return float
     */
    public function getBalance()
    {
        return $this->_balance;
    }

    /**
     * @return boolean
     */
    public function getIncomplete()
    {
        return $this->_incomplete;
    }
}
