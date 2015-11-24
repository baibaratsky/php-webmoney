<?php

namespace baibaratsky\WebMoney\Api\MegaStock;

use baibaratsky\WebMoney\Exception\ApiException;
use baibaratsky\WebMoney\Request\XmlRequest;

abstract class Request extends XmlRequest
{
    const LOGIN_TYPE_KEEPER = 1;
    const LOGIN_TYPE_PROCESSING = 2;

    /** @var int login/@type */
    protected $loginType;

    /** @var string */
    protected $salt;

    public function __construct($loginType = self::LOGIN_TYPE_PROCESSING, $salt = null)
    {
        if ($loginType !== self::LOGIN_TYPE_KEEPER && $loginType !== self::LOGIN_TYPE_PROCESSING) {
            throw new ApiException('This interface doesn\'t support the login type given.');
        }

        $this->loginType = $loginType;
        $this->salt = $salt;
    }

    /**
     * @return int
     */
    public function getLoginType()
    {
        return $this->loginType;
    }
}
