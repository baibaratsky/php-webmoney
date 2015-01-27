<?php

namespace baibaratsky\WebMoney\Api\X\X14;

use baibaratsky\WebMoney\Request\AbstractResponse;

/**
 * Class Response
 *
 * @link https://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X14
 */
class Response extends AbstractResponse
{
    /** @var int reqn */
    protected $requestNumber;

    /** @var int operation\@id */
    protected $refundTransactionId;

    /** @var int operation\@ts */
    protected $refundTransactionInternalId;

    /** @var int operation\inwmtranid */
    protected $transactionId;

    /** @var string operation/pursesrc */
    protected $payerPurse;

    /** @var string operation/pursedest */
    protected $payeePurse;

    /** @var float operation\amount */
    protected $amount;

    /** @var float operation\comiss */
    protected $fee;

    /** @var float operation\desc */
    protected $description;

    /** @var \DateTime operation/datecrt */
    protected $createDateTime;

    /** @var \DateTime operation/dateupd */
    protected $updateDateTime;

    public function __construct($response)
    {
        $responseObject = new \SimpleXMLElement($response);
        $this->requestNumber = (int)$responseObject->reqn;
        $this->returnCode = (int)$responseObject->retval;
        $this->returnDescription = (string)$responseObject->retdesc;
        if (isset($responseObject->operation)) {
            $operation = $responseObject->operation;
            $this->refundTransactionId = (int)$operation['id'];
            $this->refundTransactionInternalId = (int)$operation['ts'];
            $this->transactionId = (int)$operation->inwmtranid;
            $this->payerPurse = (string)$operation->pursesrc;
            $this->payeePurse = (string)$operation->pursdest;
            $this->amount = (float)$operation->amount;
            $this->fee = (float)$operation->comiss;
            $this->description = (string)$operation->desc;
            $this->createDateTime = self::createDateTime((string)$operation->datecrt);
            $this->updateDateTime = self::createDateTime((string)$operation->dateupd);
        }
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return \DateTime
     */
    public function getCreateDateTime()
    {
        return $this->createDateTime;
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
    public function getFee()
    {
        return $this->fee;
    }

    /**
     * @return string
     */
    public function getPayeePurse()
    {
        return $this->payeePurse;
    }

    /**
     * @deprecated
     * @return string
     */
    public function getRecipientPurse()
    {
        return $this->getPayeePurse();
    }

    /**
     * @return int
     */
    public function getRefundTransactionId()
    {
        return $this->refundTransactionId;
    }

    /**
     * @return int
     */
    public function getRefundTransactionInternalId()
    {
        return $this->refundTransactionInternalId;
    }

    /**
     * @return int
     */
    public function getRequestNumber()
    {
        return $this->requestNumber;
    }

    /**
     * @return string
     */
    public function getPayerPurse()
    {
        return $this->payerPurse;
    }

    /**
     * @deprecated
     * @return string
     */
    public function getSenderPurse()
    {
        return $this->getPayerPurse();
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
    public function getUpdateDateTime()
    {
        return $this->updateDateTime;
    }
}
