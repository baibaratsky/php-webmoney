<?php

namespace baibaratsky\WebMoney\Api\X\X2;

use baibaratsky\WebMoney\Api\X;
use baibaratsky\WebMoney\Exception\ApiException;
use baibaratsky\WebMoney\Request\RequestSigner;
use baibaratsky\WebMoney\Request\RequestValidator;

/**
 * Class Request
 *
 * @link http://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X2
 */
class Request extends X\Request
{
    /** @var string wmid */
    protected $signerWmid;

    /** @var int trans/tranid */
    protected $transactionId;

    /** @var string trans/pursesrc */
    protected $transactionSenderPurse;

    /** @var string trans/pursedest */
    protected $transactionRecipientPurse;

    /** @var float trans/amount */
    protected $transactionAmount;

    /** @var int trans/period */
    protected $transactionProtectionPeriod;

    /** @var string trans/pcode */
    protected $transactionProtectionCode;

    /** @var string trans/desc */
    protected $transactionDescription;

    /** @var int trans/wminvid */
    protected $transactionWmInvoiceNumber;

    /** @var string trans/onlyauth */
    protected $transactionOnlyAuth;

    /**
     * @param string $authType
     *
     * @throws ApiException
     */
    public function __construct($authType = self::AUTH_CLASSIC)
    {
        if ($authType === self::AUTH_CLASSIC) {
            $this->url = 'https://w3s.webmoney.ru/asp/XMLTrans.asp';
        } elseif ($authType === self::AUTH_LIGHT) {
            $this->url = 'https://w3s.wmtransfer.com/asp/XMLTransCert.asp';
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
            RequestValidator::TYPE_REQUIRED => array(
                'transactionId', 'transactionSenderPurse', 'transactionRecipientPurse', 'transactionAmount',
                'transactionDescription', 'transactionWmInvoiceNumber', 'transactionOnlyAuth',
            ),
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
        $xml .= '<trans>';
        $xml .= self::xmlElement('tranid', $this->transactionId);
        $xml .= self::xmlElement('pursesrc', $this->transactionSenderPurse);
        $xml .= self::xmlElement('pursedest', $this->transactionRecipientPurse);
        $xml .= self::xmlElement('amount', $this->transactionAmount);
        $xml .= self::xmlElement('period', $this->transactionProtectionPeriod);
        $xml .= self::xmlElement('pcode', $this->transactionProtectionCode);
        $xml .= self::xmlElement('desc', $this->transactionDescription);
        $xml .= self::xmlElement('wminvid', $this->transactionWmInvoiceNumber);
        $xml .= self::xmlElement('onlyauth', $this->transactionOnlyAuth);
        $xml .= '</trans>';
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
     * @param RequestSigner $requestSigner
     */
    public function sign(RequestSigner $requestSigner = null)
    {
        if ($this->authType === self::AUTH_CLASSIC) {
            $this->signature = $requestSigner->sign(
                $this->requestNumber . $this->transactionId .
                $this->transactionSenderPurse . $this->transactionRecipientPurse .
                $this->transactionAmount . $this->transactionProtectionPeriod .
                $this->transactionProtectionCode . $this->transactionDescription .
                $this->transactionWmInvoiceNumber
            );
        }
    }

    /**
     * @return string
     */
    public function getSignerWmid()
    {
        return $this->signerWmid;
    }

    /**
     * @param string $signerWmid
     */
    public function setSignerWmid($signerWmid)
    {
        $this->signerWmid = $signerWmid;
    }

    /**
     * @return int
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * @param int $transactionId
     */
    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;
    }

    /**
     * @return string
     */
    public function getTransactionSenderPurse()
    {
        return $this->transactionSenderPurse;
    }

    /**
     * @param string $transactionSenderPurse
     */
    public function setTransactionSenderPurse($transactionSenderPurse)
    {
        $this->transactionSenderPurse = $transactionSenderPurse;
    }

    /**
     * @return string
     */
    public function getTransactionRecipientPurse()
    {
        return $this->transactionRecipientPurse;
    }

    /**
     * @param string $transactionRecipientPurse
     */
    public function setTransactionRecipientPurse($transactionRecipientPurse)
    {
        $this->transactionRecipientPurse = $transactionRecipientPurse;
    }

    /**
     * @return float
     */
    public function getTransactionAmount()
    {
        return $this->transactionAmount;
    }

    /**
     * @param float $transactionAmount
     */
    public function setTransactionAmount($transactionAmount)
    {
        $this->transactionAmount = $transactionAmount;
    }

    /**
     * @return int
     */
    public function getTransactionProtectionPeriod()
    {
        return $this->transactionProtectionPeriod;
    }

    /**
     * @param int $transactionProtectionPeriod
     */
    public function setTransactionProtectionPeriod($transactionProtectionPeriod)
    {
        $this->transactionProtectionPeriod = $transactionProtectionPeriod;
    }

    /**
     * @return string
     */
    public function getTransactionProtectionCode()
    {
        return $this->transactionProtectionCode;
    }

    /**
     * @param string $transactionProtectionCode
     */
    public function setTransactionProtectionCode($transactionProtectionCode)
    {
        $this->transactionProtectionCode = $transactionProtectionCode;
    }

    /**
     * @return string
     */
    public function getTransactionDescription()
    {
        return $this->transactionDescription;
    }

    /**
     * @param string $transactionDescription
     */
    public function setTransactionDescription($transactionDescription)
    {
        $this->transactionDescription = $transactionDescription;
    }

    /**
     * @return int
     */
    public function getTransactionWmInvoiceNumber()
    {
        return $this->transactionWmInvoiceNumber;
    }

    /**
     * @param int $transactionWmInvoiceNumber
     */
    public function setTransactionWmInvoiceNumber($transactionWmInvoiceNumber)
    {
        $this->transactionWmInvoiceNumber = $transactionWmInvoiceNumber;
    }

    /**
     * @return boolean
     */
    public function getTransactionOnlyAuth()
    {
        return $this->transactionOnlyAuth;
    }

    /**
     * @param boolean $transactionOnlyAuth
     */
    public function setTransactionOnlyAuth($transactionOnlyAuth)
    {
        $this->transactionOnlyAuth = $transactionOnlyAuth;
    }
}
