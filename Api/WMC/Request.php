<?php

namespace baibaratsky\WebMoney\Api\WMC;

use baibaratsky\WebMoney\Request\XmlRequest;

abstract class Request extends XmlRequest
{
    const AUTH_CLASSIC = 'classic';
    const AUTH_LIGHT = 'light';
    const AUTH_SHA256 = 'sha256';
    const AUTH_MD5 = 'md5';
    const AUTH_SECRET_KEY = 'secret_key';
    const AUTH_SIGN_TYPE_CLASSIC = 1;
    const AUTH_SIGN_TYPE_LIGHT = 2;

    const CURRENCY_EUR = 'EUR';
    const CURRENCY_USD = 'USD';
    const CURRENCY_RUB = 'RUB';

    /** @var string request/@lang */
    protected $lang;

    /** @var string */
    protected $authType;

    /** @var string */
    protected $authTypeNum;

    /** @var string reqn */
    protected $requestNumber;

    /** @var string wmid */
    protected $signerWmid;

    /** @var string Light auth cert file name (PEM) */
    protected $lightCertificate;

    /** @var string Light auth key file name (PEM) */
    protected $lightKey;

    /** @var string Light auth key password */
    protected $lightPassword;

    /**
     * @param string $authType
     * @param string $lang [en|ru]
     */
    public function __construct($authType = self::AUTH_CLASSIC, $lang = 'en')
    {
        $this->authType = $authType;
        $this->requestNumber = $this->generateRequestNumber();

        if (self::AUTH_CLASSIC == $authType) {
            $this->authTypeNum = self::AUTH_SIGN_TYPE_CLASSIC;
        } elseif (self::AUTH_LIGHT == $authType) {
            $this->authTypeNum = self::AUTH_SIGN_TYPE_LIGHT;
        }
        $this->setLang($lang);
    }

    /**
     * @param string $certificate Light auth certificate file name (PEM)
     * @param string $key Light auth key file name (PEM)
     * @param string $keyPassword Light auth key password
     */
    public function lightAuth($certificate, $key, $keyPassword = '')
    {
        $this->lightCertificate = $certificate;
        $this->lightKey = $key;
        $this->lightPassword = $keyPassword;
    }

    /**
     * @param $data
     */
    public function setSignature($data)
    {
        $this->signature = $data;
    }

    /**
     * @return string
     */
    public function getAuthType()
    {
        return $this->authType;
    }

    /**
     * @return string
     */
    public function getLightCertificate()
    {
        return $this->lightCertificate;
    }

    /**
     * @return string
     */
    public function getLightKey()
    {
        return $this->lightKey;
    }

    /**
     * @return string
     */
    public function getLightPassword()
    {
        return $this->lightPassword;
    }

    /**
     * @return int
     */
    public function getRequestNumber()
    {
        return $this->requestNumber;
    }

    /**
     * @param int $requestNumber must be greater than a previous request number
     */
    public function setRequestNumber($requestNumber)
    {
        $this->requestNumber = (int)$requestNumber;
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
        $this->signerWmid = (string)$signerWmid;
    }

    /**
     * @return string
     */
    protected function generateRequestNumber()
    {
        list($msec, $sec) = explode(' ', substr(microtime(), 2));
        return $sec . substr($msec, 0, 5);
    }

    /**
     * @param int $authTypeNum
     */
    public function setAuthTypeNum($authTypeNum)
    {
        $this->authTypeNum = $authTypeNum;
    }

    /**
     * @return int|string
     */
    public function getAuthTypeNum()
    {
        return $this->authTypeNum;
    }

    /**
     * @param string $lang
     */
    public function setLang($lang)
    {
        $this->lang = $lang;
    }

    /**
     * @return string
     */
    public function getLang()
    {
        return $this->lang;
    }
}
