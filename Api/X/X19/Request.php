<?php

namespace baibaratsky\WebMoney\Api\X\X19;

use baibaratsky\WebMoney\Api\X;
use baibaratsky\WebMoney\Exception\ApiException;
use baibaratsky\WebMoney\Request\RequestValidator;
use baibaratsky\WebMoney\Signer;

/**
 * Class Request
 *
 * @link https://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X19
 */
class Request extends X\Request
{
    const LANG_RU = 'ru';
    const LANG_EN = 'en';

    const TYPE_CASH = 1;
    const TYPE_TRANSFER = 2;
    const TYPE_BANK = 3;
    const TYPE_CARD = 4;
    const TYPE_EMONEY = 5;
    const TYPE_SMS = 6;
    const TYPE_MOBILE = 7;

    /** @deprecated Use const TYPE_TRANSFER instead */
    const TYPE_SDP = self::TYPE_TRANSFER;

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
    protected $language;

    /** @var int operation/type */
    protected $operationType;

    /** @var int operation/direction */
    protected $operationDirection;

    /** @var string operation/pursetype */
    protected $operationPurseType;

    /** @var float operation/amount */
    protected $operationAmount;

    /** @var int operation/id */
    protected $orderId;

    /** @var string userinfo/wmid */
    protected $userWmid;

    /** @var string userinfo/pnomer */
    protected $userPassportNum;

    /** @var string userinfo/fname */
    protected $userLastName;

    /** @var string userinfo/iname */
    protected $userFirstName;

    /** @var string userinfo/bankname */
    protected $userBankName;

    /** @var string userinfo/bank_account */
    protected $userBankAccount;

    /** @var string userinfo/card_number */
    protected $userCardNumber;

    /** @var string userinfo/emoney_name */
    protected $userEMoneyName;

    /** @var string userinfo/emoney_id */
    protected $userEMoneyId;

    /** @var string userinfo/phone */
    protected $userPhone;

    /**
     * @param string $authType
     *
     * @throws ApiException
     */
    public function __construct($authType = self::AUTH_CLASSIC)
    {
        switch ($authType) {
            case self::AUTH_CLASSIC:
                $this->url = 'https://apipassport.webmoney.ru/XMLCheckUser.aspx';
                break;

            case self::AUTH_LIGHT:
                $this->url = 'https://apipassport.webmoney.ru/XMLCheckUserCert.aspx';
                break;

            default:
                throw new ApiException('This interface doesn\'t support the authentication type given.');
        }

        parent::__construct($authType);
    }

    /**
     * @return array
     */
    protected function getValidationRules()
    {
        return array(
                RequestValidator::TYPE_REQUIRED => array('requestNumber', 'operationAmount', 'userWmid',
                                                         'operationType', 'operationDirection', 'operationPurseType'),
                RequestValidator::TYPE_DEPEND_REQUIRED => array(
                        'signerWmid' => array('authType' => array(self::AUTH_CLASSIC)),
                        'userPassportNum' => array('operationType' => array(self::TYPE_CASH)),
                        'userFirstName' => array('operationType' => array(self::TYPE_CASH, self::TYPE_TRANSFER,
                                                                          self::TYPE_BANK, self::TYPE_CARD)),
                        'userLastName' => array('operationType' => array(self::TYPE_CASH, self::TYPE_TRANSFER,
                                                                         self::TYPE_BANK, self::TYPE_CARD)),
                        'userBankName' => array('operationType' => array(self::TYPE_BANK, self::TYPE_CARD)),
                        'userBankAccount' => array('operationType' => array(self::TYPE_BANK)),
                        'userCardNumber' => array('operationType' => array(self::TYPE_CARD)),
                        'userEMoneyName' => array('operationType' => array(self::TYPE_EMONEY)),
                        'userEMoneyId' => array('operationType' => array(self::TYPE_EMONEY)),
                        'userPhone' => array('operationType' => array(self::TYPE_SMS, self::TYPE_MOBILE)),
                ),
                RequestValidator::TYPE_RANGE => array(
                        'language' => array(self::LANG_RU, self::LANG_EN),
                        'operationType' => array(self::TYPE_CASH, self::TYPE_TRANSFER, self::TYPE_BANK, self::TYPE_CARD,
                                                 self::TYPE_EMONEY, self::TYPE_SMS, self::TYPE_MOBILE),
                        'operationDirection' => array(self::DIRECTION_OUTPUT, self::DIRECTION_INPUT),
                        'operationPurseType' => array(self::PURSE_WMZ, self::PURSE_WMR, self::PURSE_WME,
                                                      self::PURSE_WMU, self::PURSE_WMB, self::PURSE_WMY,
                                                      self::PURSE_WMG),
                        'userEMoneyName' => array(self::EMONEY_RBKM, self::EMONEY_PP, self::EMONEY_SK, self::EMONEY_QW,
                                                  self::EMONEY_YAM, self::EMONEY_ESP),
                ),
                RequestValidator::TYPE_CONDITIONAL => array(
                        'operationType' => array(
                                array('value' => self::TYPE_SMS,
                                      'conditional' => array('operationDirection' => self::DIRECTION_INPUT)),
                                array('value' => self::TYPE_MOBILE,
                                      'conditional' => array('operationDirection' => self::DIRECTION_OUTPUT))
                        ),
                ),
        );
    }

    /**
     * @return string
     */
    public function getData()
    {
        $xml = '<passport.request>';
        $xml .= self::xmlElement('reqn', $this->requestNumber);
        $xml .= self::xmlElement('lang', $this->language);
        $xml .= self::xmlElement('signerwmid', $this->signerWmid);
        $xml .= self::xmlElement('sign', $this->signature);
        $xml .= '<operation>';
        $xml .= self::xmlElement('type', $this->operationType);
        $xml .= self::xmlElement('direction', $this->operationDirection);
        $xml .= self::xmlElement('pursetype', $this->operationPurseType);
        $xml .= self::xmlElement('amount', $this->operationAmount);
        $xml .= self::xmlElement('id', $this->orderId);
        $xml .= '</operation>';
        $xml .= '<userinfo>';
        $xml .= self::xmlElement('wmid', $this->userWmid);
        $xml .= self::xmlElement('pnomer', $this->userPassportNum);
        $xml .= self::xmlElement('iname', $this->userLastName);
        $xml .= self::xmlElement('fname', $this->userFirstName);
        $xml .= self::xmlElement('bank_name', $this->userBankName);
        $xml .= self::xmlElement('bank_account', $this->userBankAccount);
        $xml .= self::xmlElement('card_number', $this->userCardNumber);
        $xml .= self::xmlElement('emoney_name', $this->userEMoneyName);
        $xml .= self::xmlElement('emoney_id', $this->userEMoneyId);
        $xml .= self::xmlElement('phone', $this->userPhone);
        $xml .= '</userinfo>';
        $xml .= '</passport.request>';

        return $xml;
    }

    /**
     * @return string
     */
    public function getResponseClassName()
    {
        return Response::className();
    }

    /**
     * @param Signer $requestSigner
     */
    public function sign(Signer $requestSigner = null)
    {
        if ($this->authType === self::AUTH_CLASSIC) {
            $this->signature = $requestSigner->sign($this->requestNumber . $this->operationType . $this->userWmid);
        }
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param string $language
     */
    public function setLanguage($language)
    {
        $this->language = (string)$language;
    }

    /**
     * @return string
     */
    public function getOperationType()
    {
        return $this->operationType;
    }

    /**
     * @param int $operationType
     */
    public function setOperationType($operationType)
    {
        $this->operationType = (int)$operationType;
    }

    /**
     * @return int
     */
    public function getOperationDirection()
    {
        return $this->operationDirection;
    }

    /**
     * @param int $operationDirection
     */
    public function setOperationDirection($operationDirection)
    {
        $this->operationDirection = (int)$operationDirection;
    }

    /**
     * @return string
     */
    public function getOperationPurseType()
    {
        return $this->operationPurseType;
    }

    /**
     * @param string $operationPurseType
     */
    public function setOperationPurseType($operationPurseType)
    {
        $this->operationPurseType = (string)$operationPurseType;
    }

    /**
     * @return float
     */
    public function getOperationAmount()
    {
        return $this->operationAmount;
    }

    /**
     * @param float $operationAmount
     */
    public function setOperationAmount($operationAmount)
    {
        $this->operationAmount = (float)$operationAmount;
    }

    /**
     * @return int
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param int $orderId
     */
    public function setOrderId($orderId)
    {
        $this->orderId = (int)$orderId;
    }

    /**
     * @return string
     */
    public function getUserWmid()
    {
        return $this->userWmid;
    }

    /**
     * @param string $userWmid
     */
    public function setUserWmid($userWmid)
    {
        $this->userWmid = (string)$userWmid;
    }

    /**
     * @return string
     */
    public function getUserPassportNum()
    {
        return $this->userPassportNum;
    }

    /**
     * @param string $userPassportNum
     */
    public function setUserPassportNum($userPassportNum)
    {
        $this->userPassportNum = (string)$userPassportNum;
    }

    /**
     * @return string
     */
    public function getUserLastName()
    {
        return $this->userLastName;
    }

    /**
     * @param string $userLastName
     */
    public function setUserLastName($userLastName)
    {
        $this->userLastName = (string)$userLastName;
    }

    /**
     * @return string
     */
    public function getUserFirstName()
    {
        return $this->userFirstName;
    }

    /**
     * @param string $userFirstName
     */
    public function setUserFirstName($userFirstName)
    {
        $this->userFirstName = (string)$userFirstName;
    }

    /**
     * @return string
     */
    public function getUserBankName()
    {
        return $this->userBankName;
    }

    /**
     * @param string $userBankName
     */
    public function setUserBankName($userBankName)
    {
        $this->userBankName = (string)$userBankName;
    }

    /**
     * @return string
     */
    public function getUserBankAccount()
    {
        return $this->userBankAccount;
    }

    /**
     * @param string $userBankAccount
     */
    public function setUserBankAccount($userBankAccount)
    {
        $this->userBankAccount = (string)$userBankAccount;
    }

    /**
     * @return string
     */
    public function getUserCardNumber()
    {
        return $this->userCardNumber;
    }

    /**
     * @param string $userCardNumber
     */
    public function setUserCardNumber($userCardNumber)
    {
        $this->userCardNumber = (string)$userCardNumber;
    }

    /**
     * @return string
     */
    public function getUserEMoneyName()
    {
        return $this->userEMoneyName;
    }

    /**
     * @param string $userEMoneyName
     */
    public function setUserEMoneyName($userEMoneyName)
    {
        $this->userEMoneyName = (string)$userEMoneyName;
    }

    /**
     * @return string
     */
    public function getUserEMoneyId()
    {
        return $this->userEMoneyId;
    }

    /**
     * @param string $userEMoneyId
     */
    public function setUserEMoneyId($userEMoneyId)
    {
        $this->userEMoneyId = (string)$userEMoneyId;
    }

    /**
     * @return string
     */
    public function getUserPhone()
    {
        return $this->userPhone;
    }

    /**
     * @param string $userPhone
     */
    public function setUserPhone($userPhone)
    {
        $this->userPhone = (string)$userPhone;
    }
}
