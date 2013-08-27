<?php

/**
 * Class WMX19Request
 *
 * @link https://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X19
 */
class WMX19Request extends WMXApiRequest
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

    /** @var string lang */
    protected $_language;

    /** @var string signerwmid */
    protected $_signerWmid;

    /** @var string sign */
    protected $_sign;

    /** @var int operation/type */
    protected $_operationType;

    /** @var int operation/direction */
    protected $_operationDirection;

    /** @var string operation/pursetype */
    protected $_operationPurseType;

    /** @var float operation/amount */
    protected $_operationAmount;

    /** @var string userinfo/wmid */
    protected $_userWmid;

    /** @var string userinfo/pnomer */
    protected $_userPassportNum;

    /** @var string userinfo/fname */
    protected $_userLastName;

    /** @var string userinfo/iname */
    protected $_userFirstName;

    /** @var string userinfo/bankname */
    protected $_userBankName;

    /** @var string userinfo/bank_account */
    protected $_userBankAccount;

    /** @var string userinfo/card_number */
    protected $_userCardNumber;

    /** @var string userinfo/emoney_name */
    protected $_userEMoneyName;

    /** @var string userinfo/emoney_id */
    protected $_userEMoneyId;

    /** @var string userinfo/phone */
    protected $_userPhone;

    /**
     * @param string $authType
     *
     * @throws WMException
     */
    public function __construct($authType = self::AUTH_CLASSIC)
    {
        if ($authType === self::AUTH_CLASSIC) {
            $this->_url = 'https://apipassport.webmoney.ru/XMLCheckUser.aspx';
        } elseif ($authType === self::AUTH_LIGHT) {
            $this->_url = 'https://apipassport.webmoney.ru/XMLCheckUserCert.aspx';
        } else {
            throw new WMException('This interface doesn\'t support the authentication type given.');
        }

        parent::__construct($authType);
    }

    /**
     * @return array
     */
    protected function _getValidationRules()
    {
        return array(
            WMApiRequestValidator::TYPE_REQUIRED => array('requestNumber', 'operationAmount', 'userWmid', 'operationType', 'operationDirection', 'operationPurseType'),
            WMApiRequestValidator::TYPE_DEPEND_REQUIRED => array(
                'signerWmid' => array('authType' => array(self::AUTH_CLASSIC)),
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
            WMApiRequestValidator::TYPE_RANGE => array(
                'language' => array(self::LANG_RU, self::LANG_EN),
                'operationType' => array(self::TYPE_CASH, self::TYPE_SDP, self::TYPE_BANK, self::TYPE_CARD, self::TYPE_EMONEY, self::TYPE_SMS, self::TYPE_MOBILE),
                'operationDirection' => array(self::DIRECTION_OUTPUT, self::DIRECTION_INPUT),
                'operationPurseType' => array(self::PURSE_WMZ, self::PURSE_WMR, self::PURSE_WME, self::PURSE_WMU, self::PURSE_WMB, self::PURSE_WMY, self::PURSE_WMG),
                'userEMoneyId' => array(self::EMONEY_RBKM, self::EMONEY_PP, self::EMONEY_SK, self::EMONEY_QW, self::EMONEY_YAM, self::EMONEY_ESP),
            ),
            WMApiRequestValidator::TYPE_CONDITIONAL => array(
                'operationType' => array(
                    array('value' => self::TYPE_SMS, 'conditional' => array('operationDirection' => self::DIRECTION_INPUT)),
                    array('value' => self::TYPE_MOBILE, 'conditional' => array('operationDirection' => self::DIRECTION_OUTPUT))
                ),
            ),
        );
    }

    /**
     * @return string
     */
    public function getXml()
    {
        $xml = '<passport.request>';
        $xml .= self::_xmlElement('reqn', $this->_requestNumber);
        $xml .= self::_xmlElement('lang', $this->_language);
        $xml .= self::_xmlElement('signerwmid', $this->_signerWmid);
        $xml .= self::_xmlElement('sign', $this->_sign);
        $xml .= '<operation>';
        $xml .= self::_xmlElement('type', $this->_operationType);
        $xml .= self::_xmlElement('direction', $this->_operationDirection);
        $xml .= self::_xmlElement('pursetype', $this->_operationPurseType);
        $xml .= self::_xmlElement('amount', $this->_operationAmount);
        $xml .= '</operation>';
        $xml .= '<userinfo>';
        $xml .= self::_xmlElement('wmid', $this->_userWmid);
        $xml .= self::_xmlElement('pnomer', $this->_userPassportNum);
        $xml .= self::_xmlElement('fname', $this->_userLastName);
        $xml .= self::_xmlElement('iname', $this->_userFirstName);
        $xml .= self::_xmlElement('bank_name', $this->_userBankName);
        $xml .= self::_xmlElement('bank_account', $this->_userBankAccount);
        $xml .= self::_xmlElement('card_number', $this->_userCardNumber);
        $xml .= self::_xmlElement('emoney_name', $this->_userEMoneyName);
        $xml .= self::_xmlElement('emoney_id', $this->_userEMoneyId);
        $xml .= self::_xmlElement('phone', $this->_userPhone);
        $xml .= '</userinfo>';
        $xml .= '</passport.request>';

        return $xml;
    }

    /**
     * @return string
     */
    public function getResponseClassName()
    {
        return 'WMX19Response';
    }

    /**
     * @param WMRequestSigner $requestSigner
     */
    public function sign(WMRequestSigner $requestSigner)
    {
        if ($this->_authType === self::AUTH_CLASSIC) {
            $this->_sign = $requestSigner->sign($this->_requestNumber . $this->_operationType . $this->_userWmid);
        }
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
     * @return string
     */
    public function getUserPassportNum()
    {
        return $this->_userPassportNum;
    }

    /**
     * @param string $userPassportNum
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
}
