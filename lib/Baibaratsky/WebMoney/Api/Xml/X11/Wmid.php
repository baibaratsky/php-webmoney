<?php
namespace Baibaratsky\WebMoney\Api\Xml\X11;

class Wmid
{
    /** @var string wmid */
    private $_wmid;

    /** @var string info */
    private $_information;

    /** @var string nickname */
    private $_nickname;

    /** @var string datereg */
    private $_registrationDt;

    /** @var int yearreg */
    private $_registrationYear;

    /** @var int monthreg */
    private $_registrationMonth;

    /** @var int dayreg */
    private $_registrationDay;

    /** @var string timereg */
    private $_registrationTime;

    /** @var int ctype */
    private $_passportType;

    /** @var string companyname */
    private $_companyName;

    /** @var int companyid */
    private $_companyId;

    /** @var string phone */
    private $_phone;

    /** @var string email */
    private $_email;

    /** @var string phone-check-lock */
    private $_phoneCheckLock;

    /** @var string email-check-lock */
    private $_emailCheckLock;

    /**
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->_wmid = $params['wmid'];
        $this->_information = $params['info'];
        $this->_nickname = $params['nickname'];
        $this->_registrationDt = $params['datereg'];
        if (isset($params['yearreg'])) {
            $this->_registrationYear = (int)$params['yearreg'];
        }
        if (isset($params['monthreg'])) {
            $this->_registrationMonth = (int)$params['monthreg'];
        }
        if (isset($params['dayreg'])) {
            $this->_registrationDay = (int)$params['dayreg'];
        }
        if (isset($params['timereg'])) {
            $this->_registrationTime = $params['timereg'];
        }
        $this->_passportType = (int)$params['ctype'];
        $this->_companyName = $params['companyname'];
        $this->_companyId = (int)$params['companyid'];
        if (isset($params['phone'])) {
            $this->_phone = $params['phone'];
        }
        if (isset($params['email'])) {
            $this->_email = $params['email'];
        }
        if (isset($params['phone-check-lock'])) {
            $this->_phoneCheckLock = $params['phone-check-lock'];
        }
        if (isset($params['phone-check-lock'])) {
            $this->_emailCheckLock = $params['email-check-lock'];
        }
    }

    /**
     * @return string
     */
    public function getWmid()
    {
        return $this->_wmid;
    }

    /**
     * @return string
     */
    public function getInformation()
    {
        return $this->_information;
    }

    /**
     * @return string
     */
    public function getNickname()
    {
        return $this->_nickname;
    }

    /**
     * @return string
     */
    public function getRegistrationDt()
    {
        return $this->_registrationDt;
    }

    /**
     * @return int
     */
    public function getRegistrationYear()
    {
        return $this->_registrationYear;
    }

    /**
     * @return int
     */
    public function getRegistrationMonth()
    {
        return $this->_registrationMonth;
    }

    /**
     * @return int
     */
    public function getRegistrationDay()
    {
        return $this->_registrationDay;
    }

    /**
     * @return string
     */
    public function getRegistrationTime()
    {
        return $this->_registrationTime;
    }

    /**
     * @return int
     */
    public function getPassportType()
    {
        return $this->_passportType;
    }

    /**
     * @return string
     */
    public function getCompanyName()
    {
        return $this->_companyName;
    }

    /**
     * @return int
     */
    public function getCompanyId()
    {
        return $this->_companyId;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->_phone;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * @return string
     */
    public function getPhoneCheckLock()
    {
        return $this->_phoneCheckLock;
    }

    /**
     * @return string
     */
    public function getEmailCheckLock()
    {
        return $this->_emailCheckLock;
    }
}
