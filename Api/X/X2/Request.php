<?php

namespace baibaratsky\WebMoney\Api\X\X2;

use baibaratsky\WebMoney\Api\X;
use baibaratsky\WebMoney\Exception\ApiException;
use baibaratsky\WebMoney\Request\RequestValidator;
use baibaratsky\WebMoney\Signer;

/**
 * Class Request
 *
 * @link http://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X2
 */
class Request extends X\Request
{
    /** @var int trans/tranid */
    protected $transactionExternalId;

    /** @var string trans/pursesrc */
    protected $payerPurse;

    /** @var string trans/pursedest */
    protected $payeePurse;

    /** @var float trans/amount */
    protected $amount;

    /** @var int trans/period */
    protected $protectionPeriod = 0;

    /** @var string trans/pcode */
    protected $protectionCode;

    /** @var string trans/desc */
    protected $description;

    /** @var int trans/wminvid */
    protected $invoiceId = 0;

    /** @var bool trans/onlyauth */
    protected $onlyAuth = true;

    /** @var bool trans/wmb_denomination */
    protected $wmbDenomination = true;

    /**
     * @param string $authType
     *
     * @throws ApiException
     */
    public function __construct($authType = self::AUTH_CLASSIC)
    {
        switch ($authType) {
            case self::AUTH_CLASSIC:
                $this->url = 'https://w3s.webmoney.ru/asp/XMLTrans.asp';
                break;

            case self::AUTH_LIGHT:
                $this->url = 'https://w3s.wmtransfer.com/asp/XMLTransCert.asp';
                break;

            default:
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
                        'invoiceId', 'onlyAuth', 'wmbDenomination'
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
        $xml .= self::xmlElement('onlyauth', (int)$this->onlyAuth);
        $xml .= '</trans>';
	     $xml .= self::xmlElement('wmb_denomination', $this->wmbDenomination);
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
                    $this->protectionCode .
                    mb_convert_encoding($this->description, 'Windows-1251', 'UTF-8') .
                    $this->invoiceId
            );
        }
    }

    /**
     * @return int
     */
    public function getTransactionExternalId()
    {
        return $this->transactionExternalId;
    }

    /**
     * Set ID of the transaction in your system
     *
     * @param int $transactionExternalId should be a positive integer, unique for the WMID that signs the request
     * It’s not allowed to perform two transactions with the same ID.
     * The uniqueness of ID is verified at least for one year.
     */
    public function setTransactionExternalId($transactionExternalId)
    {
        $this->transactionExternalId = (int)$transactionExternalId;
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
        $this->payerPurse = (string)$payerPurse;
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
        $this->payeePurse = (string)$payeePurse;
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
        $this->amount = (float)$amount;
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
        $this->protectionPeriod = (int)$protectionPeriod;
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
        $this->protectionCode = (string)$protectionCode;
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
        $this->description = (string)$description;
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
        $this->invoiceId = (int)$invoiceId;
    }

    /**
     * @return bool
     */
    public function getOnlyAuth()
    {
        return $this->onlyAuth;
    }

    /**
     * @param bool $onlyAuth
     */
    public function setOnlyAuth($onlyAuth)
    {
        $this->onlyAuth = (bool)$onlyAuth;
    }

    /**
     * @return bool
     */
    public function getWmbDenomination()
    {
        return $this->wmbDenomination;
    }

    /**
     * @param bool $wmbDenomination
     */
    public function setWmbDenomination($wmbDenomination)
    {
        $this->wmbDenomination = (bool)$wmbDenomination;
    }
}
