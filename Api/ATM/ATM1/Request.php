<?php

namespace baibaratsky\WebMoney\Api\ATM\ATM1;

use baibaratsky\WebMoney\Api\ATM;
use baibaratsky\WebMoney\Exception\ApiException;
use baibaratsky\WebMoney\Request\RequestValidator;
use baibaratsky\WebMoney\Signer;

/**
 * Class Request
 *
 * @link http://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_ATM1
 */
class Request extends ATM\Request
{
    /** @var string payment/@currency */
    protected $currency;

    /** @var string payment/@exchange */
    protected $exchange;

    /** @var string payment/purse */
    protected $payeePurse;

    /** @var float payment/price */
    protected $price;

    /**
     * @param string $authType
     *
     * @throws ApiException
     */
    public function __construct($authType = self::AUTH_CLASSIC)
    {
        switch ($authType) {
            case self::AUTH_CLASSIC:
                $this->url = 'https://transfer.gdcert.com/ATM/Xml/PrePayment2.ashx';
                break;
            case self::AUTH_LIGHT:
                $this->url = 'https://transfer.gdcert.com/ATM/Xml/PrePayment2.ashx';
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
                'price', 'payeePurse', 'currency'
            )
        );
    }

    /**
     * @return string
     */
    public function getData()
    {
        $xml = '<w3s.request lang="' . $this->getLang() . '">';
        $xml .= self::xmlElement('wmid', $this->getSignerWmid());
        $xml .= '<sign type="' . $this->getAuthTypeNum() . '">' . $this->signature . '</sign>';
        $xml .= '<payment currency="' . $this->getCurrency() . (!empty($this->getExchange()) ? '" exchange="' . $this->getExchange() : '') . '">';
        $xml .= self::xmlElement('purse', $this->getPayeePurse());
        $xml .= self::xmlElement('price', $this->getPrice());
        $xml .= '</payment>';
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
     * @param string $lightCertificate
     * @param string $lightKey
     */
    public function cert($lightCertificate, $lightKey) {
        if ($this->authType === self::AUTH_LIGHT) {
            $this->signature = base64_encode(
                $this->getSignerWmid() . $this->getCurrency() .
                $this->getPayeePurse() . $this->getPrice());
        }
        parent::cert($lightCertificate, $lightKey);
    }

    /**
     * @param Signer $requestSigner
     */
    public function sign(Signer $requestSigner = null)
    {
        if ($this->authType === self::AUTH_CLASSIC) {
            $this->signature = $requestSigner->sign(
                $this->getSignerWmid() . $this->getCurrency() .
                $this->getPayeePurse() . $this->getPrice()
            );
        }
    }

    /**
     * @return string
     */
    public function getExchange()
    {
        return $this->exchange;
    }

    /**
     * @param string $exchange
     */
    public function setExchange($exchange)
    {
        $this->exchange = (string)$exchange;
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
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = (float)$price;
    }

    /**
     * @return string CURRENCY_EUR|CURRENCY_RUB|CURRENCY_USD
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string $currency CURRENCY_EUR|CURRENCY_RUB|CURRENCY_USD
     */
    public function setCurrency($currency)
    {
        $this->currency = (string)$currency;
    }
}
