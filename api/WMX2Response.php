<?php

/**
 * Class WMX2Response
 *
 * @link http://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X2
 */
class WMX2Response extends WMApiResponse
{
    /** @var string retdesc */
    protected $_returnDescription;

    /** @var int operation[@id] */
    protected $_operationId;

    /** @var int operation[@ts] */
    protected $_operationInternalId;

    /** @var int operation/tranid */
    protected $_operationExternalId;

    /** @var string operation/pursesrc */
    protected $_operationSenderPurse;

    /** @var string operation/pursedest */
    protected $_operationRecipientPurse;

    /** @var float operation/pursesrc */
    protected $_operationAmount;

    /** @var float operation/comiss */
    protected $_operationFee;

    /** @var int operation/opertype */
    protected $_operationType;

    /** @var int operation/period */
    protected $_operationPeriod;

    /** @var int operation/wminvid */
    protected $_operationInvoiceId;

    /** @var int operation/orderid */
    protected $_operationExternalInvoiceId;

    /** @var string operation/desc */
    protected $_operationDescription;

    /** @var DateTime operation/datecrt */
    protected $_operationCreateDateTime;

    /** @var DateTime operation/dateupd */
    protected $_operationUpdateDateTime;

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        $responseObject = new SimpleXMLElement($response);
        $this->_returnCode = (int)$responseObject->retval;
        $this->_returnDescription = (string)$responseObject->retdesc;

        if (isset($responseObject->operation)) {
            $operation = $responseObject->operation;
            $this->_operationId = $operation['id'];
            $this->_operationInternalId = $operation['ts'];
            $this->_operationExternalId = $operation->tranid;
            $this->_operationSenderPurse = $operation->pursesrc;
            $this->_operationRecipientPurse = $operation->pursedest;
            $this->_operationAmount = $operation->amount;
            $this->_operationFee = $operation->comiss;
            $this->_operationType = $operation->opertype;
            $this->_operationPeriod = $operation->period;
            $this->_operationInvoiceId = $operation->wminvid;
            $this->_operationExternalInvoiceId = $operation->orderid;
            $this->_operationDescription = $operation->desc;
            $this->_operationCreateDateTime = self::_createDateTime((string)$operation->datecrt);
            $this->_operationUpdateDateTime = self::_createDateTime((string)$operation->dateupd);
        }
    }

    /**
     * @return string
     */
    public function getReturnDescription()
    {
        return $this->_returnDescription;
    }

    /**
     * @return int
     */
    public function getOperationId()
    {
        return $this->_operationId;
    }

    /**
     * @return int
     */
    public function getOperationInternalId()
    {
        return $this->_operationInternalId;
    }

    /**
     * @return int
     */
    public function getOperationExternalId()
    {
        return $this->_operationExternalId;
    }

    /**
     * @return string
     */
    public function getOperationSenderPurse()
    {
        return $this->_operationSenderPurse;
    }

    /**
     * @return string
     */
    public function getOperationRecipientPurse()
    {
        return $this->_operationRecipientPurse;
    }

    /**
     * @return float
     */
    public function getOperationAmount()
    {
        return $this->_operationAmount;
    }

    /**
     * @return float
     */
    public function getOperationFee()
    {
        return $this->_operationFee;
    }

    /**
     * @return int
     */
    public function getOperationType()
    {
        return $this->_operationType;
    }

    /**
     * @return int
     */
    public function getOperationPeriod()
    {
        return $this->_operationPeriod;
    }

    /**
     * @return int
     */
    public function getOperationInvoiceId()
    {
        return $this->_operationInvoiceId;
    }

    /**
     * @return int
     */
    public function getOperationExternalInvoiceId()
    {
        return $this->_operationExternalInvoiceId;
    }

    /**
     * @return string
     */
    public function getOperationDescription()
    {
        return $this->_operationDescription;
    }

    /**
     * @return \DateTime
     */
    public function getOperationCreateDateTime()
    {
        return $this->_operationCreateDateTime;
    }

    /**
     * @return \DateTime
     */
    public function getOperationUpdateDateTime()
    {
        return $this->_operationUpdateDateTime;
    }
}
