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

    /** @var string wmid */
    protected $signerWmid;

    /** @var string Light auth cert file name (PEM) */
    protected $lightCertificate;

    /** @var string Light auth key file name (PEM) */
    protected $lightKey;
  
    /** @var string Light auth key password */
    protected $lightPass;

    public function __construct($authType = self::AUTH_CLASSIC)
    {
        $this->authType = $authType;
        $this->requestNumber = $this->generateRequestNumber();
    }
  
    /**
     * @param string $lightCertificate Light auth certificate file name (PEM)
     * @param string $lightKey         Light auth key file name (PEM)
     * @param string $lightPass        Light auth key pass
     */
    public function cert($lightCertificate, $lightKey, $lightPass = '')
    {
      $this->lightCertificate = $lightCertificate;
      $this->lightKey = $lightKey;
      $this->lightPass = $lightPass;
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
    public function getLightPass() {
      return $this->lightPass;
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
}
