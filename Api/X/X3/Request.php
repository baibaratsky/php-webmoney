<?php

namespace baibaratsky\WebMoney\Api\X\X3;

use baibaratsky\WebMoney\Api\X;
use baibaratsky\WebMoney\Exception\ApiException;
use baibaratsky\WebMoney\Request\RequestValidator;
use baibaratsky\WebMoney\Signer;

/**
 * Class Request
 *
 * @link https://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X3
 */
class Request extends X\Request
{
    /** @var string getoperations\purse */
    protected $purse;

    /** @var int getoperations\wmtranid */
    protected $transactionId;

    /** @var int getoperations\tranid */
    protected $transactionExternalId;

    /** @var int getoperations\wminvid */
    protected $invoiceId;

    /** @var int getoperations\orderid */
    protected $orderId;

    /** @var \DateTime getoperations\datestart */
    protected $startDateTime;

    /** @var \DateTime getoperations\datefinish */
    protected $endDateTime;

    public function __construct($authType = self::AUTH_CLASSIC)
    {
        if ($authType === self::AUTH_CLASSIC) {
            $this->url = 'https://w3s.webmoney.ru/asp/XMLOperations.asp';
        } elseif ($authType === self::AUTH_LIGHT) {
            $this->url = 'https://w3s.wmtransfer.com/asp/XMLOperationsCert.asp';
        } else {
            throw new ApiException('This interface doesn\'t support the authentication type given.');
        }

        parent::__construct($authType);
    }

    /**
     * @return array
     */
    protected function getValidationRules()
    {
        return array(
            RequestValidator::TYPE_REQUIRED => array('purse', 'startDateTime', 'endDateTime'),
            RequestValidator::TYPE_DEPEND_REQUIRED => array(
                'signerWmid' => array('authType' => array(self::AUTH_CLASSIC)),
            ),
        );
    }

    /**
     * @return string
     */
    public function getData()
    {
        $xml = '<w3s.request>';
        $xml .= self::xmlElement('reqn', $this->requestNumber);
        $xml .= self::xmlElement('wmid', $this->signerWmid);
        $xml .= self::xmlElement('sign', $this->signature);
        $xml .= '<getoperations>';
        $xml .= self::xmlElement('purse', $this->purse);
        $xml .= self::xmlElement('wmtranid', $this->transactionId);
        $xml .= self::xmlElement('tranid', $this->transactionExternalId);
        $xml .= self::xmlElement('wminvid', $this->invoiceId);
        $xml .= self::xmlElement('orderid', $this->orderId);
        $xml .= self::xmlElement('datestart', $this->startDateTime->format('Ymd H:i:s'));
        $xml .= self::xmlElement('datefinish', $this->endDateTime->format('Ymd H:i:s'));
        $xml .= '</getoperations>';
        $xml .= '</w3s.request>';

        return $xml;
    }

    /**
     * @return string
     */
    public function getResponseClassName()
    {
        return Response::className();
    }

    /**
     * @param Signer $requestSigner
     *
     */
    public function sign(Signer $requestSigner = null)
    {
        if ($this->authType === self::AUTH_CLASSIC) {
            $this->signature = $requestSigner->sign($this->purse . $this->requestNumber);
        }
    }

    /**
     * @param string $purse
     */
    public function setPurse($purse)
    {
        $this->purse = $purse;
    }

    /**
     * @return string
     */
    public function getPurse()
    {
        return $this->purse;
    }

    /**
     * @param int $transactionId
     */
    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;
    }

    /**
     * @return int
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * @param int $transactionExternalId
     */
    public function setTransactionExternalId($transactionExternalId)
    {
        $this->transactionExternalId = $transactionExternalId;
    }

    /**
     * @return int
     */
    public function getTransactionExternalId()
    {
        return $this->transactionExternalId;
    }

    /**
     * @param int $orderId
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * @return int
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @deprecated Use setOrderId() instead
     * @param int $externalInvoiceId
     */
    public function setExternalInvoiceId($externalInvoiceId)
    {
        $this->setOrderId($externalInvoiceId);
    }

    /**
     * @deprecated Use getOrderId() instead
     * @return int
     */
    public function getExternalInvoiceId()
    {
        return $this->getOrderId();
    }

    /**
     * @param int $invoiceId
     */
    public function setInvoiceId($invoiceId)
    {
        $this->invoiceId = $invoiceId;
    }

    /**
     * @return int
     */
    public function getInvoiceId()
    {
        return $this->invoiceId;
    }

    /**
     * @param \DateTime $startDateTime
     */
    public function setStartDateTime($startDateTime)
    {
        $this->startDateTime = $startDateTime;
    }

    /**
     * @return \DateTime
     */
    public function getStartDateTime()
    {
        return $this->startDateTime;
    }

    /**
     * @param \DateTime $endDateTime
     */
    public function setEndDateTime($endDateTime)
    {
        $this->endDateTime = $endDateTime;
    }

    /**
     * @return \DateTime
     */
    public function getEndDateTime()
    {
        return $this->endDateTime;
    }
}
