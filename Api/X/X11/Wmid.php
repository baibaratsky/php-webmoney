<?php
namespace baibaratsky\WebMoney\Api\X\X11;

class Wmid
{
    /** @var string wmid */
    private $wmid;

    /** @var string info */
    private $information;

    /** @var string nickname */
    private $nickname;

    /** @var string datereg */
    private $registrationDt;

    /** @var int yearreg */
    private $registrationYear;

    /** @var int monthreg */
    private $registrationMonth;

    /** @var int dayreg */
    private $registrationDay;

    /** @var string timereg */
    private $registrationTime;

    /** @var int ctype */
    private $passportType;

    /** @var string companyname */
    private $companyName;

    /** @var int companyid */
    private $companyId;

    /** @var string phone */
    private $phone;

    /** @var string email */
    private $email;

    /** @var string phone-check-lock */
    private $phoneCheckLock;

    /** @var string email-check-lock */
    private $emailCheckLock;

    /**
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->wmid = $params['wmid'];
        $this->information = $params['info'];
        $this->nickname = $params['nickname'];
        $this->registrationDt = $params['datereg'];
        if (isset($params['yearreg'])) {
            $this->registrationYear = (int)$params['yearreg'];
        }
        if (isset($params['monthreg'])) {
            $this->registrationMonth = (int)$params['monthreg'];
        }
        if (isset($params['dayreg'])) {
            $this->registrationDay = (int)$params['dayreg'];
        }
        if (isset($params['timereg'])) {
            $this->registrationTime = $params['timereg'];
        }
        $this->passportType = (int)$params['ctype'];
        $this->companyName = $params['companyname'];
        $this->companyId = (int)$params['companyid'];
        if (isset($params['phone'])) {
            $this->phone = $params['phone'];
        }
        if (isset($params['email'])) {
            $this->email = $params['email'];
        }
        if (isset($params['phone-check-lock'])) {
            $this->phoneCheckLock = $params['phone-check-lock'];
        }
        if (isset($params['phone-check-lock'])) {
            $this->emailCheckLock = $params['email-check-lock'];
        }
    }

    /**
     * @return string
     */
    public function getWmid()
    {
        return $this->wmid;
    }

    /**
     * @return string
     */
    public function getInformation()
    {
        return $this->information;
    }

    /**
     * @return string
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * @return string
     */
    public function getRegistrationDt()
    {
        return $this->registrationDt;
    }

    /**
     * @return int
     */
    public function getRegistrationYear()
    {
        return $this->registrationYear;
    }

    /**
     * @return int
     */
    public function getRegistrationMonth()
    {
        return $this->registrationMonth;
    }

    /**
     * @return int
     */
    public function getRegistrationDay()
    {
        return $this->registrationDay;
    }

    /**
     * @return string
     */
    public function getRegistrationTime()
    {
        return $this->registrationTime;
    }

    /**
     * @return int
     */
    public function getPassportType()
    {
        return $this->passportType;
    }

    /**
     * @return string
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * @return int
     */
    public function getCompanyId()
    {
        return $this->companyId;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPhoneCheckLock()
    {
        return $this->phoneCheckLock;
    }

    /**
     * @return string
     */
    public function getEmailCheckLock()
    {
        return $this->emailCheckLock;
    }
}
