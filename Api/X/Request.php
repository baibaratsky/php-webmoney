<?php

namespace baibaratsky\WebMoney\Api\X;

use baibaratsky\WebMoney\Request\XmlRequest;

abstract class Request extends XmlRequest
{
    const AUTH_CLASSIC = 'classic';
    const AUTH_LIGHT = 'light';
    const AUTH_SHA256 = 'sha256';
    const AUTH_MD5 = 'md5';
    const AUTH_SECRET_KEY = 'secret_key';

    /** @var string */
    protected $authType;

    /** @var string reqn */
    protected $requestNumber;

    /** @var string Light auth cert file name (PEM) */
    protected $lightCert;

    /** @var string Light auth key file name (PEM) */
    protected $lightKey;

    public function __construct($authType = self::AUTH_CLASSIC)
    {
        $this->authType = $authType;
        $this->requestNumber = $this->generateRequestNumber();
    }

    /**
     * @param string $lightCert Light auth cert file name (PEM)
     * @param string $lightKey Light auth key file name (PEM)
     */
    public function cert($lightCert, $lightKey)
    {
        $this->lightCert = $lightCert;
        $this->lightKey = $lightKey;
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
    public function getLightCert()
    {
        return $this->lightCert;
    }

    /**
     * @return string
     */
    public function getLightKey()
    {
        return $this->lightKey;
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
        $this->requestNumber = $requestNumber;
    }

    /**
     * @return string
     */
    protected function generateRequestNumber()
    {
        list($msec, $sec) = explode(' ', substr(microtime(), 2));
        return $sec . substr($msec, 0, 5);
    }
}
