<?php

namespace baibaratsky\WebMoney\Api\X\X2;

use baibaratsky\WebMoney\Request\AbstractResponse;

/**
 * Class Response
 *
 * @link http://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X2
 */
class Response extends AbstractResponse
{
    /** @var int operation[@id] */
    protected $transactionId;

    /** @var int operation/tranid */
    protected $transactionExternalId;

    /** @var string operation/pursesrc */
    protected $payerPurse;

    /** @var string operation/pursedest */
    protected $payeePurse;

    /** @var float operation/pursesrc */
    protected $amount;

    /** @var float operation/comiss */
    protected $fee;

    /** @var int operation/opertype */
    protected $type;

    /** @var int operation/period */
    protected $period;

    /** @var int operation/wminvid */
    protected $invoiceId;

    /** @var int operation/orderid */
    protected $orderId;

    /** @var string operation/desc */
    protected $description;

    /** @var \DateTime operation/datecrt */
    protected $createDateTime;

    /** @var \DateTime operation/dateupd */
    protected $updateDateTime;

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        $responseObject = new \SimpleXMLElement($response);
        $this->returnCode = (int)$responseObject->retval;
        $this->returnDescription = (string)$responseObject->retdesc;

        if (isset($responseObject->operation)) {
            $operation = $responseObject->operation;
            $this->transactionId = (int)$operation['id'];
            $this->transactionExternalId = (string)$operation->tranid;
            $this->payerPurse = (string)$operation->pursesrc;
            $this->payeePurse = (string)$operation->pursedest;
            $this->amount = (float)$operation->amount;
            $this->fee = (float)$operation->comiss;
            $this->type = (int)$operation->opertype;
            $this->period = (int)$operation->period;
            $this->invoiceId = (int)$operation->wminvid;
            $this->orderId = (int)$operation->orderid;
            $this->description = (string)$operation->desc;
            $this->createDateTime = self::createDateTime((string)$operation->datecrt);
            $this->updateDateTime = self::createDateTime((string)$operation->dateupd);
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
     * @return int
     */
    public function getTransactionExternalId()
    {
        return $this->transactionExternalId;
    }

    /**
     * @return string
     */
    public function getPayerPurse()
    {
        return $this->payerPurse;
    }

    /**
     * @deprecated Use getPayerPurse() instead
     * @return string
     */
    public function getSenderPurse()
    {
        return $this->getPayerPurse();
    }

    /**
     * @return string
     */
    public function getPayeePurse()
    {
        return $this->payeePurse;
    }

    /**
     * @deprecated Use getPayeePurse() instead
     * @return string
     */
    public function getRecipientPurse()
    {
        return $this->getPayeePurse();
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
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getPeriod()
    {
        return $this->period;
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
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
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
}
