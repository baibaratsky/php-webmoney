<?php

abstract class WMMSApiRequest extends WMXmlApiRequest
{
    const LOGIN_TYPE_KEEPER = 1;
    const LOGIN_TYPE_PROCESSING = 2;

    /** @var int login@type */
    protected $_loginType;

    /** @var string */
    protected $_salt;

    public function __construct($loginType = self::LOGIN_TYPE_PROCESSING, $salt = null)
    {
        if ($loginType !== self::LOGIN_TYPE_KEEPER && $loginType !== self::LOGIN_TYPE_PROCESSING) {
            throw new WMException('This interface doesn\'t support the login type given.');
        }

        $this->_loginType = $loginType;
        $this->_salt = $salt;
    }

    /**
     * @return int
     */
    public function getLoginType()
    {
        return $this->_loginType;
    }
}
