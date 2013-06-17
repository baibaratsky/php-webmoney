<?php

class WMX19Request extends WMApiRequest
{
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

    protected $_authType;
    protected $_requestNumber;
    protected $_language;
    protected $_signerWmid;
    protected $_operationType;
    protected $_operationDirection;
    protected $_operationPurseType;
    protected $_operationAmount;
    protected $_sign;
    protected $_userWmid;
    protected $_userPassportNum;
    protected $_userLastName;
    protected $_userFirstName;
    protected $_userBankName;
    protected $_userBankAccount;
    protected $_userCardNumber;
    protected $_userEMoneyName;
    protected $_userEMoneyId;
    protected $_userPhone;

    public function __construct($authType = self::AUTH_CLASSIC)
    {
        $this->_authType = $authType;
        $this->_requestNumber = $this->_generateRequestNumber();
    }

    protected function _getValidationRules()
    {
        return array(
            WMApiRequestValidator::TYPE_REQUIRED => array('requestNumber', 'signerWmid', 'operationAmount', 'userWmid', 'operationType', 'operationDirection', 'operationPurseType'),
            WMApiRequestValidator::TYPE_DEPEND_REQUIRED => array(
                'userPassportNum' => array('operationType' => array(self::TYPE_CASH)),
                'userFirstName' => array('operationType' => array(self::TYPE_CASH, self::TYPE_SDP, self::TYPE_BANK, self::TYPE_CARD)),
                'userLastName' => array('operationType' => array(self::TYPE_CASH, self::TYPE_SDP, self::TYPE_BANK, self::TYPE_CARD)),
                'userBankName' => array('operationType' => array(self::TYPE_BANK, self::TYPE_CARD)),
                'userBankAccount' => array('operationType' => array(self::TYPE_BANK)),
                'userCardNumber' => array('operationType' => array(self::TYPE_CARD)),
                'userEMoneyName' => array('operationType' => array(self::TYPE_EMONEY)),
                'userEMoneyId' => array('operationType' => array(self::TYPE_EMONEY)),
                'userPhone' => array('operationType' => array(self::TYPE_SMS, self::TYPE_MOBILE)),
            ),
            WMApiRequestValidator::TYPE_RIGHT_VALUE => array(
                'language' => array(self::LANG_RU, self::LANG_EN),
                'operationType' => array(self::TYPE_CASH, self::TYPE_SDP, self::TYPE_BANK, self::TYPE_CARD, self::TYPE_EMONEY, self::TYPE_SMS, self::TYPE_MOBILE),
                'operationDirection' => array(self::DIRECTION_OUTPUT, self::DIRECTION_INPUT),
                'operationPurseType' => array(self::PURSE_WMZ, self::PURSE_WMR, self::PURSE_WME, self::PURSE_WMU, self::PURSE_WMB, self::PURSE_WMY, self::PURSE_WMG),
                'userEMoneyType' => array(self::EMONEY_RBKM, self::EMONEY_PP, self::EMONEY_SK, self::EMONEY_QW, self::EMONEY_YAM, self::EMONEY_ESP),
            ),
            WMApiRequestValidator::TYPE_CONDITIONAL => array(
                'operationType' => array(
                    array('value' => self::TYPE_SMS, 'conditional' => array('operationDirection' => self::DIRECTION_INPUT)),
                    array('value' => self::TYPE_MOBILE, 'conditional' => array('operationDirection' => self::DIRECTION_OUTPUT))
                ),
            ),
        );
    }

    public function getUrl()
    {
        if ($this->_authType == self::AUTH_CLASSIC) {
            return 'https://apipassport.webmoney.ru/XMLCheckUser.aspx';
        }

        return 'https://apipassport.webmoney.ru/XMLCheckUserCert.aspx';
    }

    public function getXml()
    {
        $this->_xml = '<passport.request>';
        $this->_addElementToXml('reqn', $this->_requestNumber);
        $this->_addElementToXml('lang', $this->_language);
        $this->_addElementToXml('signerwmid', $this->_signerWmid);
        $this->_addElementToXml('sign', $this->_sign);
        $this->_xml .= '<operation>';
        $this->_addElementToXml('type', $this->_operationType);
        $this->_addElementToXml('direction', $this->_operationDirection);
        $this->_addElementToXml('pursetype', $this->_operationPurseType);
        $this->_addElementToXml('amount', $this->_operationAmount);
        $this->_xml .= '</operation>';
        $this->_xml .= '<userinfo>';
        $this->_addElementToXml('wmid', $this->_userWmid);
        $this->_addElementToXml('pnomer', $this->_userPassportNum);
        $this->_addElementToXml('fname', $this->_userLastName);
        $this->_addElementToXml('iname', $this->_userFirstName);
        $this->_addElementToXml('bank_name', $this->_userBankName);
        $this->_addElementToXml('bank_account', $this->_userBankAccount);
        $this->_addElementToXml('card_number', $this->_userCardNumber);
        $this->_addElementToXml('emoney_name', $this->_userEMoneyName);
        $this->_addElementToXml('emoney_id', $this->_userEMoneyId);
        $this->_addElementToXml('phone', $this->_userPhone);
        $this->_xml .= '</userinfo>';
        $this->_xml .= '</passport.request>';

        return $this->_xml;
    }

    public function getResponseClassName()
    {
        return 'WMX19Response';
    }

    public function sign(WMRequestSigner $requestSigner)
    {
        if ($this->_authType == self::AUTH_CLASSIC) {
            $this->_sign = $requestSigner->sign($this->_requestNumber . $this->_operationType . $this->_userWmid);
        }
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
    public function getLanguage()
    {
        return $this->_language;
    }

    /**
     * @param string $language
     */
    public function setLanguage($language)
    {
        $this->_language = $language;
    }

    /**
     * @return string
     */
    public function getSignerWmid()
    {
        return $this->_signerWmid;
    }

    /**
     * @param string $signerWmid
     */
    public function setSignerWmid($signerWmid)
    {
        $this->_signerWmid = $signerWmid;
    }

    /**
     * @return int
     */
    public function getOperationType()
    {
        return $this->_operationType;
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
    public function getOperationDirection()
    {
        return $this->_operationDirection;
    }

    /**
     * @param int $operationDirection
     */
    public function setOperationDirection($operationDirection)
    {
        $this->_operationDirection = $operationDirection;
    }

    /**
     * @return string
     */
    public function getOperationPurseType()
    {
        return $this->_operationPurseType;
    }

    /**
     * @param string $operationPurseType
     */
    public function setOperationPurseType($operationPurseType)
    {
        $this->_operationPurseType = $operationPurseType;
    }

    /**
     * @return float
     */
    public function getOperationAmount()
    {
        return $this->_operationAmount;
    }

    /**
     * @param float $operationAmount
     */
    public function setOperationAmount($operationAmount)
    {
        $this->_operationAmount = $operationAmount;
    }

    /**
     * @return string
     */
    public function getUserWmid()
    {
        return $this->_userWmid;
    }

    /**
     * @param string $userWmid
     */
    public function setUserWmid($userWmid)
    {
        $this->_userWmid = $userWmid;
    }

    /**
     * @return int
     */
    public function getUserPassportNum()
    {
        return $this->_userPassportNum;
    }

    /**
     * @param int $userPassportNum
     */
    public function setUserPassportNum($userPassportNum)
    {
        $this->_userPassportNum = $userPassportNum;
    }

    /**
     * @return string
     */
    public function getUserLastName()
    {
        return $this->_userLastName;
    }

    /**
     * @param string $userLastName
     */
    public function setUserLastName($userLastName)
    {
        $this->_userLastName = $userLastName;
    }

    /**
     * @return string
     */
    public function getUserFirstName()
    {
        return $this->_userFirstName;
    }

    /**
     * @param string $userFirstName
     */
    public function setUserFirstName($userFirstName)
    {
        $this->_userFirstName = $userFirstName;
    }

    /**
     * @return string
     */
    public function getUserBankName()
    {
        return $this->_userBankName;
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
    public function getUserBankAccount()
    {
        return $this->_userBankAccount;
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
    public function getUserCardNumber()
    {
        return $this->_userCardNumber;
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
    public function getUserEMoneyName()
    {
        return $this->_userEMoneyName;
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
    public function getUserEMoneyId()
    {
        return $this->_userEMoneyId;
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
    public function getUserPhone()
    {
        return $this->_userPhone;
    }

    /**
     * @param string $userPhone
     */
    public function setUserPhone($userPhone)
    {
        $this->_userPhone = $userPhone;
    }

    public function toArray()
    {
        return array(
            'requestNumber' => $this->_requestNumber,
            'language' => $this->_language,
            'signerWmid' => $this->_signerWmid,
            'operationType' => $this->_operationType,
            'operationDirection' => $this->_operationDirection,
            'operationPurseType' => $this->_operationPurseType,
            'operationAmount' => $this->_operationAmount,
            'userWmid' => $this->_userWmid,
            'userPassportNum' => $this->_userPassportNum,
            'userLastName' => $this->_userLastName,
            'userFirstName' => $this->_userFirstName,
            'userBankName' => $this->_userBankName,
            'userBankAccount' => $this->_userBankAccount,
            'userCardNumber' => $this->_userCardNumber,
            'userEMoneyName' => $this->_userEMoneyName,
            'userEMoneyId' => $this->_userEMoneyId,
            'userPhone' => $this->_userPhone,
        );
    }
}
