<?php

abstract class WMXApiRequest extends WMXmlApiRequest
{
    const AUTH_CLASSIC = 'classic';
    const AUTH_LIGHT = 'light';
    const AUTH_MD5 = 'md5';
    const AUTH_SECRET_KEY = 'secret_key';

    /** @var string */
    protected $_authType;

    /** @var string reqn */
    protected $_requestNumber;

    public function __construct($authType = self::AUTH_CLASSIC)
    {
        $this->_authType = $authType;
        $this->_requestNumber = $this->_generateRequestNumber();
    }

    /**
     * @return string
     */
    public function getAuthType()
    {
        return $this->_authType;
    }

    /**
     * @return int
     */
    public function getRequestNumber()
    {
        return $this->_requestNumber;
    }

    /**
     * @param int $requestNumber
     */
    public function setRequestNumber($requestNumber)
    {
        $this->_requestNumber = $requestNumber;
    }

    /**
     * @return string
     */
    protected function _generateRequestNumber()
    {
        return str_replace('.', '', microtime(true));
    }
}
