<?php

namespace baibaratsky\WebMoney\Api\X;

use baibaratsky\WebMoney\Request\XmlRequest;

abstract class Request extends XmlRequest
{
    /** @var string reqn */
    protected $requestNumber;

    public function __construct($authType = self::AUTH_CLASSIC)
    {
        $this->authType = $authType;
        $this->requestNumber = $this->generateRequestNumber();
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

    /**
     * @param string $cert Light auth cert file name (PEM)
     * @param string $certKey Light auth key file name (PEM)
     */
    public function cert($cert, $certKey)
    {
        $this->cert = $cert;
        $this->certKey = $certKey;
    }
}
