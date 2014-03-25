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
    protected $operationId;

    /** @var int operation[@ts] */
    protected $operationInternalId;

    /** @var int operation/tranid */
    protected $operationExternalId;

    /** @var string operation/pursesrc */
    protected $operationSenderPurse;

    /** @var string operation/pursedest */
    protected $operationRecipientPurse;

    /** @var float operation/pursesrc */
    protected $operationAmount;

    /** @var float operation/comiss */
    protected $operationFee;

    /** @var int operation/opertype */
    protected $operationType;

    /** @var int operation/period */
    protected $operationPeriod;

    /** @var int operation/wminvid */
    protected $operationInvoiceId;

    /** @var int operation/orderid */
    protected $operationExternalInvoiceId;

    /** @var string operation/desc */
    protected $operationDescription;

    /** @var \DateTime operation/datecrt */
    protected $operationCreateDateTime;

    /** @var \DateTime operation/dateupd */
    protected $operationUpdateDateTime;

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
            $this->operationId = (int)$operation['id'];
            $this->operationInternalId = (int)$operation['ts'];
            $this->operationExternalId = (string)$operation->tranid;
            $this->operationSenderPurse = (string)$operation->pursesrc;
            $this->operationRecipientPurse = (string)$operation->pursedest;
            $this->operationAmount = (float)$operation->amount;
            $this->operationFee = (float)$operation->comiss;
            $this->operationType = (int)$operation->opertype;
            $this->operationPeriod = (int)$operation->period;
            $this->operationInvoiceId = (int)$operation->wminvid;
            $this->operationExternalInvoiceId = (int)$operation->orderid;
            $this->operationDescription = (string)$operation->desc;
            $this->operationCreateDateTime = self::createDateTime((string)$operation->datecrt);
            $this->operationUpdateDateTime = self::createDateTime((string)$operation->dateupd);
        }
    }

    /**
     * @return int
     */
    public function getOperationId()
    {
        return $this->operationId;
    }

    /**
     * @return int
     */
    public function getOperationInternalId()
    {
        return $this->operationInternalId;
    }

    /**
     * @return int
     */
    public function getOperationExternalId()
    {
        return $this->operationExternalId;
    }

    /**
     * @return string
     */
    public function getOperationSenderPurse()
    {
        return $this->operationSenderPurse;
    }

    /**
     * @return string
     */
    public function getOperationRecipientPurse()
    {
        return $this->operationRecipientPurse;
    }

    /**
     * @return float
     */
    public function getOperationAmount()
    {
        return $this->operationAmount;
    }

    /**
     * @return float
     */
    public function getOperationFee()
    {
        return $this->operationFee;
    }

    /**
     * @return int
     */
    public function getOperationType()
    {
        return $this->operationType;
    }

    /**
     * @return int
     */
    public function getOperationPeriod()
    {
        return $this->operationPeriod;
    }

    /**
     * @return int
     */
    public function getOperationInvoiceId()
    {
        return $this->operationInvoiceId;
    }

    /**
     * @return int
     */
    public function getOperationExternalInvoiceId()
    {
        return $this->operationExternalInvoiceId;
    }

    /**
     * @return string
     */
    public function getOperationDescription()
    {
        return $this->operationDescription;
    }

    /**
     * @return \DateTime
     */
    public function getOperationCreateDateTime()
    {
        return $this->operationCreateDateTime;
    }

    /**
     * @return \DateTime
     */
    public function getOperationUpdateDateTime()
    {
        return $this->operationUpdateDateTime;
    }
}
