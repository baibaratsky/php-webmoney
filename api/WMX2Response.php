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
    protected $_operationTransactionId;

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
    protected $_operationWmInvoiceNumber;

    /** @var int operation/orderid */
    protected $_operationOrderId;

    /** @var string operation/desc */
    protected $_operationDescription;

    /** @var DateTime operation/datecrt */
    protected $_operationCreateDatetime;

    /** @var DateTime operation/dateupd */
    protected $_operationUpdateDatetime;

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
            $this->_operationTransactionId = $operation->tranid;
            $this->_operationSenderPurse = $operation->pursesrc;
            $this->_operationRecipientPurse = $operation->pursedest;
            $this->_operationAmount = $operation->amount;
            $this->_operationFee = $operation->comiss;
            $this->_operationType = $operation->opertype;
            $this->_operationPeriod = $operation->period;
            $this->_operationWmInvoiceNumber = $operation->wminvid;
            $this->_operationOrderId = $operation->orderid;
            $this->_operationDescription = $operation->desc;
            $this->_operationCreateDatetime = self::_createDateTime((string)$operation->datecrt);
            $this->_operationUpdateDatetime = self::_createDateTime((string)$operation->dateupd);
        }
    }
}
