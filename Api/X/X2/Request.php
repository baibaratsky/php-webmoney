<?php

namespace baibaratsky\WebMoney\Api\X\X2;

use baibaratsky\WebMoney\Api\X;
use baibaratsky\WebMoney\Exception\ApiException;
use baibaratsky\WebMoney\Signer;
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
    protected $transactionExternalId;

    /** @var string trans/pursesrc */
    protected $payerPurse;

    /** @var string trans/pursedest */
    protected $payeePurse;

    /** @var float trans/amount */
    protected $amount;

    /** @var int trans/period */
    protected $protectionPeriod;

    /** @var string trans/pcode */
    protected $protectionCode;

    /** @var string trans/desc */
    protected $description;

    /** @var int trans/wminvid */
    protected $invoiceId;

    /** @var string trans/onlyauth */
    protected $onlyAuth = 1;

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
                'transactionExternalId', 'payerPurse', 'payeePurse', 'amount',
                'description', 'invoiceId', 'onlyAuth',
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
        $xml .= self::xmlElement('tranid', $this->transactionExternalId);
        $xml .= self::xmlElement('pursesrc', $this->payerPurse);
        $xml .= self::xmlElement('pursedest', $this->payeePurse);
        $xml .= self::xmlElement('amount', $this->amount);
        $xml .= self::xmlElement('period', $this->protectionPeriod);
        $xml .= self::xmlElement('pcode', $this->protectionCode);
        $xml .= self::xmlElement('desc', $this->description);
        $xml .= self::xmlElement('wminvid', $this->invoiceId);
        $xml .= self::xmlElement('onlyauth', $this->onlyAuth);
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
     * @param Signer $requestSigner
     */
    public function sign(Signer $requestSigner = null)
    {
        if ($this->authType === self::AUTH_CLASSIC) {
            $this->signature = $requestSigner->sign(
                $this->requestNumber . $this->transactionExternalId .
                $this->payerPurse . $this->payeePurse .
                $this->amount . $this->protectionPeriod .
                $this->protectionCode . $this->description .
                $this->invoiceId
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
    public function getTransactionExternalId()
    {
        return $this->transactionExternalId;
    }

    /**
     * @param int $transactionExternalId
     */
    public function setTransactionExternalId($transactionExternalId)
    {
        $this->transactionExternalId = $transactionExternalId;
    }

    /**
     * @return string
     */
    public function getPayerPurse()
    {
        return $this->payerPurse;
    }

    /**
     * @param string $payerPurse
     */
    public function setPayerPurse($payerPurse)
    {
        $this->payerPurse = $payerPurse;
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
     * @deprecated Use setPayerPurse($payerPurse) instead
     * @param string $senderPurse
     */
    public function setSenderPurse($senderPurse)
    {
        $this->setPayerPurse($senderPurse);
    }

    /**
     * @return string
     */
    public function getPayeePurse()
    {
        return $this->payeePurse;
    }

    /**
     * @param string $payeePurse
     */
    public function setPayeePurse($payeePurse)
    {
        $this->payeePurse = $payeePurse;
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
     * @deprecated Use setPayeePurse($payeePurse) instead
     * @param string $recipientPurse
     */
    public function setRecipientPurse($recipientPurse)
    {
        $this->setPayeePurse($recipientPurse);
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return int
     */
    public function getProtectionPeriod()
    {
        return $this->protectionPeriod;
    }

    /**
     * @param int $protectionPeriod
     */
    public function setProtectionPeriod($protectionPeriod)
    {
        $this->protectionPeriod = $protectionPeriod;
    }

    /**
     * @return string
     */
    public function getProtectionCode()
    {
        return $this->protectionCode;
    }

    /**
     * @param string $protectionCode
     */
    public function setProtectionCode($protectionCode)
    {
        $this->protectionCode = $protectionCode;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getInvoiceId()
    {
        return $this->invoiceId;
    }

    /**
     * @param int $invoiceId
     */
    public function setInvoiceId($invoiceId)
    {
        $this->invoiceId = $invoiceId;
    }

    /**
     * @return boolean
     */
    public function getOnlyAuth()
    {
        return $this->onlyAuth;
    }

    /**
     * @param boolean $onlyAuth
     */
    public function setOnlyAuth($onlyAuth)
    {
        $this->onlyAuth = $onlyAuth;
    }
}
