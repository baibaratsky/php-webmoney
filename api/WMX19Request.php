<?php


class WMX19Request extends WMApiRequest
{
    protected $_reqn;
    protected $_lang;
    protected $_signerWmid;
    protected $_operationType;
    protected $_operationDirection;
    protected $_operationPurseType;
    protected $_operationAmount;
    protected $_sign;
    protected $_userWmid;
    protected $_userPNomer;
    protected $_userFName;
    protected $_userIName;
    protected $_userBankName;
    protected $_userBankAccount;
    protected $_userCardNumber;
    protected $_userEMoneyName;
    protected $_userEMoneyId;
    protected $_userPhone;

    const LANG_RU = 'ru';
    const LANG_EN = 'en';

    const TYPE_CASH = 1;
    const TYPE_SDP = 2;
    const TYPE_BANK = 3;
    const TYPE_CARD = 4;
    const TYPE_EMONEY = 5;
    const TYPE_SMS = 6;
    const TYPE_MOBILE = 7;

    const DIRECTION_OUTPUT = 1;
    const DIRECTION_INPUT = 2;

    const PURSE_WMZ = 'WMZ';
    const PURSE_WMR = 'WMR';
    const PURSE_WME = 'WME';
    const PURSE_WMU = 'WMU';
    const PURSE_WMB = 'WMB';
    const PURSE_WMY = 'WMY';
    const PURSE_WMG = 'WMG';

    const EMONEY_RBKM = 'rbkmoney.ru';
    const EMONEY_PP = 'paypal.com';
    const EMONEY_SK = 'moneybookers.com';
    const EMONEY_QW = 'qiwi.ru';
    const EMONEY_YAM = 'money.yandex.ru';
    const EMONEY_ESP = 'easypay.by';

    public function validate()
    {

    }

    public function getUrl()
    {
        //@TODO keeper light https://apipassport.webmoney.ru/XMLCheckUserCert.aspx
        return 'https://apipassport.webmoney.ru/XMLCheckUser.aspx';
    }

    public function getXml()
    {
        $xml = '<passport.request>';
        $xml .= '<reqn>' . $this->_reqn . '</reqn>';
        $xml .= '<lang>' . $this->_lang . '</lang>';
        $xml .= '<signerwmid>' . $this->_signerWmid . '</signerwmid>';
        $xml .= '<sign>' . $this->_sign . '</sign>';
        $xml .= '<operation>';
        $xml .= '<type>' . $this->_operationType . '</type>';
        $xml .= '<direction>' . $this->_operationDirection . '</direction>';
        $xml .= '<pursetype>' . $this->_operationPurseType . '</pursetype>';
        $xml .= '<amount>' . $this->_operationAmount . '</amount>';
        $xml .= '</operation>';
        $xml .= '<userinfo>';
        $xml .= '<wmid>' . $this->_userWmid . '</wmid>';
        $xml .= '<pnomer>' . $this->_userPNomer . '</pnomer>';
        $xml .= '<fname>' . $this->_userFName . '</fname>';
        $xml .= '<iname>' . $this->getUserIName() . '</iname>';
        $xml .= '<bank_name>' . $this->_userBankName . '</bank_name>';
        $xml .= '<bank_account>' . $this->_userBankAccount . '</bank_account>';
        $xml .= '<card_number>' . $this->_userCardNumber . '</card_number>';
        $xml .= '<emoney_name>' . $this->_userEMoneyName . '</emoney_name>';
        $xml .= '<emoney_id>' . $this->_userEMoneyId . '</emoney_id>';
        $xml .= '<phone>' . $this->_userPhone . '</phone>';
        $xml .= '</userinfo>';
        $xml .= '</passport.request>';

        return $xml;
    }

    public function getResponseClassName()
    {
        return 'WMX19Response';
    }

    /**
     * @param string $lang
     */
    public function setLang($lang)
    {
        $this->_lang = $lang;
    }

    /**
     * @return string
     */
    public function getLang()
    {
        return $this->_lang;
    }

    /**
     * @param int $operationType
     */
    public function setOperationType($operationType)
    {
        $this->_operationType = $operationType;
    }

    /**
     * @return int
     */
    public function getOperationType()
    {
        return $this->_operationType;
    }

    /**
     * @param int $operationDirection
     */
    public function setOperationDirection($operationDirection)
    {
        $this->_operationDirection = $operationDirection;
    }

    /**
     * @param float $operationAmount
     */
    public function setOperationAmount($operationAmount)
    {
        $this->_operationAmount = $operationAmount;
    }

    /**
     * @return float
     */
    public function getOperationAmount()
    {
        return $this->_operationAmount;
    }

    /**
     * @return int
     */
    public function getOperationDirection()
    {
        return $this->_operationDirection;
    }

    /**
     * @param string $operationPurseType
     */
    public function setOperationPurseType($operationPurseType)
    {
        $this->_operationPurseType = $operationPurseType;
    }

    /**
     * @return string
     */
    public function getOperationPurseType()
    {
        return $this->_operationPurseType;
    }

    /**
     * @param int $reqn
     */
    public function setReqn($reqn)
    {
        $this->_reqn = $reqn;
    }

    /**
     * @return int
     */
    public function getReqn()
    {
        return $this->_reqn;
    }

    /**
     * @param string $sign
     */
    public function setSign($sign)
    {
        $this->_sign = $sign;
    }

    /**
     * @return string
     */
    public function getSign()
    {
        return $this->_sign;
    }

    /**
     * @param string $signerWmid
     */
    public function setSignerWmid($signerWmid)
    {
        $this->_signerWmid = $signerWmid;
    }

    /**
     * @return string
     */
    public function getSignerWmid()
    {
        return $this->_signerWmid;
    }

    /**
     * @param string $userWmid
     */
    public function setUserWmid($userWmid)
    {
        $this->_userWmid = $userWmid;
    }

    /**
     * @return string
     */
    public function getUserWmid()
    {
        return $this->_userWmid;
    }

    /**
     * @param int $userPNomer
     */
    public function setUserPNomer($userPNomer)
    {
        $this->_userPNomer = $userPNomer;
    }

    /**
     * @return int
     */
    public function getUserPNomer()
    {
        return $this->_userPNomer;
    }

    /**
     * @return string
     */
    public function getUserFName()
    {
        return $this->_userFName;
    }

    /**
     * @param string $userFName
     */
    public function setUserFName($userFName)
    {
        $this->_userFName = $userFName;
    }

    /**
     * @return string
     */
    public function getUserIName()
    {
        return $this->_userIName;
    }

    /**
     * @param string $userIName
     */
    public function setUserIName($userIName)
    {
        $this->_userIName = $userIName;
    }

    /**
     * @param string $userBankName
     */
    public function setUserBankName($userBankName)
    {
        $this->_userBankName = $userBankName;
    }

    /**
     * @return string
     */
    public function getUserBankName()
    {
        return $this->_userBankName;
    }

    /**
     * @param string $userBankAccount
     */
    public function setUserBankAccount($userBankAccount)
    {
        $this->_userBankAccount = $userBankAccount;
    }

    /**
     * @return string
     */
    public function getUserBankAccount()
    {
        return $this->_userBankAccount;
    }

    /**
     * @param string $userCardNumber
     */
    public function setUserCardNumber($userCardNumber)
    {
        $this->_userCardNumber = $userCardNumber;
    }

    /**
     * @return string
     */
    public function getUserCardNumber()
    {
        return $this->_userCardNumber;
    }

    /**
     * @param string $userEMoneyName
     */
    public function setUserEMoneyName($userEMoneyName)
    {
        $this->_userEMoneyName = $userEMoneyName;
    }

    /**
     * @return string
     */
    public function getUserEMoneyName()
    {
        return $this->_userEMoneyName;
    }

    /**
     * @param string $userEMoneyId
     */
    public function setUserEMoneyId($userEMoneyId)
    {
        $this->_userEMoneyId = $userEMoneyId;
    }

    /**
     * @return string
     */
    public function getUserEMoneyId()
    {
        return $this->_userEMoneyId;
    }

    /**
     * @param string $userPhone
     */
    public function setUserPhone($userPhone)
    {
        $this->_userPhone = $userPhone;
    }

    /**
     * @return string
     */
    public function getUserPhone()
    {
        return $this->_userPhone;
    }
}
