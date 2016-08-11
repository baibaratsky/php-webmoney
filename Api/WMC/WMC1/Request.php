<?php

namespace baibaratsky\WebMoney\Api\WMC\WMC1;

use baibaratsky\WebMoney\Api\WMC;
use baibaratsky\WebMoney\Exception\ApiException;
use baibaratsky\WebMoney\Request\RequestValidator;
use baibaratsky\WebMoney\Signer;

/**
 * Class Request
 *
 * @link http://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_WMC1
 */
class Request extends WMC\Request
{

    /** @var string payment/purse */
    protected $payeePurse;

    /** @var string payment/@currency */
    protected $currency;

    /** @var float payment/price */
    protected $price;

    /** @var int payment/phone */
    protected $phone;

    /**
     * @param string $authType
     *
     * @throws ApiException
     */
    public function __construct($authType = self::AUTH_CLASSIC)
    {
        switch ($authType) {
            case self::AUTH_CLASSIC:
                $this->url = 'https://transfer.gdcert.com/ATM/Xml/PrePayment1.ashx';
                break;
            case self::AUTH_LIGHT:
                $this->url = 'https://transfer.gdcert.com/ATM/Xml/PrePayment1.ashx';
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
                RequestValidator::TYPE_REQUIRED => array('price', 'currency'),
        );
    }

    /**
     * @return string
     */
    public function getData()
    {
        $xml = '<w3s.request lang="' . $this->getLang() . '">';
        $xml .= self::xmlElement('wmid', $this->getSignerWmid());
        $xml .= '<sign type="' . $this->getAuthTypeNum() . '">' . $this->getSignature() . '</sign>';
        $xml .= '<payment currency="' . $this->getCurrency() . '">';
        $xml .= self::xmlElement('purse', $this->getPayeePurse());
        $phone = $this->getPhone();
        if (empty($phone)) {
            $xml .= self::xmlElement('phone', $phone);
        }
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
     * @inheritdoc
     */
    public function lightAuth($certificate, $key, $keyPassword = '')
    {
        if ($this->authType === self::AUTH_LIGHT) {
            $this->setSignature(
                    $this->signLight(
                            $this->getSignerWmid() . $this->getCurrency() . $this->getPayeePurse() . $this->getPhone()
                            . $this->getPrice(),
                            $key,
                            $keyPassword
                    )
            );
        }

        parent::lightAuth($certificate, $key, $keyPassword);
    }

    /**
     * @param Signer $requestSigner
     */
    public function sign(Signer $requestSigner = null)
    {
        if ($this->authType === self::AUTH_CLASSIC) {
            $this->setSignature($requestSigner->sign(
                    $this->getSignerWmid() . $this->getCurrency() .
                    $this->getPayeePurse() . $this->getPhone() .
                    $this->getPrice()
            ));
        }
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
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = (string)$phone;
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
