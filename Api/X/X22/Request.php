<?php

namespace baibaratsky\WebMoney\Api\X\X22;

use baibaratsky\WebMoney\Api\X;
use baibaratsky\WebMoney\Exception\ApiException;
use baibaratsky\WebMoney\Signer;
use baibaratsky\WebMoney\Request\RequestValidator;

/**
 * Class Request
 *
 * @link https://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X22
 * @link https://merchant.wmtransfer.com/conf/guide.asp
 */
class Request extends X\Request
{
    /** @var string wmid */
    protected $signerWmid;

    /** @var string validityperiodinhours */
    protected $validityPeriodInHours;

    /** @var string sha256 */
    protected $sha256;

    /** @var string md5 */
    protected $md5;

    /** @var string secret_key */
    protected $secretKey;

    /** @var string lmi_payee_purse */
    protected $payeePurse;

    /** @var float lmi_payment_amount */
    protected $paymentAmount;

    /** @var int lmi_payment_no */
    protected $paymentNumber;

    /** @var string lmi_payment_desc */
    protected $paymentDescription;

    const SIM_MODE_SUCCESS = 0;
    const SIM_MODE_FAILURE = 1;
    const SIM_MODE_80x20 = 2;

    /** @var int lmi_sim_mode */
    protected $simMode;

    /** @var string lmi_result_url */
    protected $resultUrl;

    const URL_METHOD_GET = 'GET';
    const URL_METHOD_POST = 'POST';
    const URL_METHOD_LINK = 'LINK';

    /** @var string lmi_success_url */
    protected $successUrl;

    /** @var string lmi_success_method */
    protected $successMethod;

    /** @var string lmi_fail_url */
    protected $failUrl;

    /** @var string lmi_fail_method */
    protected $failMethod;

    /** @var string lmi_paymer_pinnumberinside */
    protected $paymerPinNumberInside;

    /** @var string lmi_wmnote_pinnumberinside */
    protected $wmNotePinNumberInside;

    /** @var string lmi_paymer_email */
    protected $paymerEmail;

    /** @var string lmi_wmcheck_numberinside */
    protected $wmCheckNumberInside;

    /** @var string lmi_wmcheck_codeinside */
    protected $wmCheckCodeInside;

    const SDP_TYPE_MONEY_TRANSFER = 0;
    const SDP_TYPE_ALFA_CLICK = 3;
    const SDP_TYPE_RU_CARD = 4;
    const SDP_TYPE_RUSSIAN_STANDARD = 5;
    const SDP_TYPE_VTB24 = 6;
    const SDP_TYPE_SBERBANK_THANK_YOU = 7;
    const SDP_TYPE_UA_TERMINALS_AND_BANKS = 8;

    /** @var int lmi_allow_sdp */
    protected $allowSdp;

    /** @var int lmi_fast_phonenumber */
    protected $fastPhoneNumber;

    /** @var int lmi_payment_creditdays */
    protected $paymentCreditDays;

    /** @var int lmi_shop_id */
    protected $shopId;

    /** @var string[] */
    protected $userTags = array();

    const PAYMENT_METHOD_KEEPER_WEB = 'authtype_2';
    const PAYMENT_METHOD_WM_CARD = 'authtype_3';
    const PAYMENT_METHOD_KEEPER_MOBILE = 'authtype_4';
    const PAYMENT_METHOD_E_NUM = 'authtype_5';
    const PAYMENT_METHOD_PAYMER_CHECK = 'authtype_6';
    const PAYMENT_METHOD_TERMINAL = 'authtype_7';
    const PAYMENT_METHOD_KEEPER_WIN = 'authtype_8';
    const PAYMENT_METHOD_KEEPER_STD = 'authtype_9';
    const PAYMENT_METHOD_WM_NOTE = 'authtype_10';
    const PAYMENT_METHOD_RU_POST = 'authtype_11';
    const PAYMENT_METHOD_KEEPER_SOCIAL_NET = 'authtype_12';
    const PAYMENT_METHOD_WM_CHECK = 'authtype_13';
    const PAYMENT_METHOD_RU_MONEY_TRANSFER = 'authtype_14';
    const PAYMENT_METHOD_RU_CARD = 'authtype_16';
    const PAYMENT_METHOD_MOBILE_NUMBER = 'authtype_17';
    const PAYMENT_METHOD_ALPHA_CLICK = 'authtype_18';
    const PAYMENT_METHOD_SBERBANK_THANKYOU = 'authtype_19';

    /** @var string at */
    protected $paymentMethod;

    /**
     * @param string $authType
     * @param string $secretKey
     * @throws ApiException
     */
    public function __construct($authType = self::AUTH_CLASSIC, $secretKey = null)
    {
        if (
                $secretKey === null
                && in_array($authType, array(self::AUTH_SHA256, self::AUTH_MD5, self::AUTH_SECRET_KEY))
        ) {
            throw new ApiException('Secret key is required for this authentication type.');
        }

        $this->url = 'https://merchant.webmoney.ru/conf/xml/XMLTransSave.asp';
        $this->secretKey = $secretKey;

        parent::__construct($authType);
    }

    /**
     * @return array
     */
    protected function getValidationRules()
    {
        return array(
                RequestValidator::TYPE_REQUIRED => array('signerWmid', 'validityPeriodInHours', 'payeePurse',
                                                         'paymentAmount', 'paymentDescription'),
                RequestValidator::TYPE_RANGE => array(
                        'simMode' => array(
                                self::SIM_MODE_SUCCESS,
                                self::SIM_MODE_FAILURE,
                                self::SIM_MODE_80x20,
                        ),
                        'successMethod' => array(
                                self::URL_METHOD_GET,
                                self::URL_METHOD_POST,
                                self::URL_METHOD_LINK,
                        ),
                        'failMethod' => array(
                                self::URL_METHOD_GET,
                                self::URL_METHOD_POST,
                                self::URL_METHOD_LINK,
                        ),
                ),
        );
    }

    /**
     * @return string
     */
    public function getData()
    {
        $xml = '<merchant.request>';

        $xml .= '<signtags>';
        $xml .= self::xmlElement('wmid', $this->signerWmid);
        $xml .= self::xmlElement('validityperiodinhours', $this->validityPeriodInHours);
        $xml .= self::xmlElement('sign', $this->signature);
        $xml .= self::xmlElement('sha256', $this->sha256);
        $xml .= self::xmlElement('md5', $this->md5);
        if ($this->authType === self::AUTH_SECRET_KEY) {
            $xml .= self::xmlElement('secret_key', $this->secretKey);
        }
        $xml .= '</signtags>';

        $xml .= '<paymenttags>';
        $xml .= self::xmlElement('lmi_payee_purse', $this->payeePurse);
        $xml .= self::xmlElement('lmi_payment_amount', $this->paymentAmount);
        $xml .= self::xmlElement('lmi_payment_no', $this->paymentNumber);
        if (preg_match('/[\x80-\xFF]/', $this->paymentDescription)) {  // utf8 ?
            $xml .= self::xmlElement('lmi_payment_desc_base64', base64_encode($this->paymentDescription));
        } else {
            $xml .= self::xmlElement('lmi_payment_desc', $this->paymentDescription);
        }
        $xml .= self::xmlElement('lmi_sim_mode', $this->simMode);
        $xml .= self::xmlElement('lmi_result_url', $this->resultUrl);
        $xml .= self::xmlElement('lmi_success_url', $this->successUrl);
        $xml .= self::xmlElement('lmi_success_method', $this->successMethod);
        $xml .= self::xmlElement('lmi_fail_url', $this->failUrl);
        $xml .= self::xmlElement('lmi_fail_method', $this->failMethod);
        $xml .= self::xmlElement('lmi_paymer_pinnumberinside', $this->paymerPinNumberInside);
        $xml .= self::xmlElement('lmi_wmnote_pinnumberinside', $this->wmNotePinNumberInside);
        $xml .= self::xmlElement('lmi_paymer_email', $this->paymerEmail);
        $xml .= self::xmlElement('lmi_wmcheck_numberinside', $this->wmCheckNumberInside);
        $xml .= self::xmlElement('lmi_wmcheck_codeinside', $this->wmCheckCodeInside);
        $xml .= self::xmlElement('lmi_allow_sdp', $this->allowSdp);
        $xml .= self::xmlElement('lmi_fast_phonenumber', $this->fastPhoneNumber);
        $xml .= self::xmlElement('lmi_payment_creditdays', $this->paymentCreditDays);
        $xml .= self::xmlElement('lmi_shop_id', $this->shopId);
        $xml .= self::xmlElement('at', $this->paymentMethod);
        foreach ($this->userTags as $tagName => $tagValue) {
            $xml .= self::xmlElement($tagName, $tagValue);
        }
        $xml .= '</paymenttags>';

        $xml .= '</merchant.request>';

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
            $this->signature = $requestSigner->sign($this->signerWmid . $this->payeePurse . $this->paymentNumber . $this->validityPeriodInHours);
        } elseif ($this->authType === self::AUTH_SHA256) {
            $this->sha256 = hash(
                    'sha256',
                    $this->signerWmid . $this->payeePurse . $this->paymentNumber . $this->validityPeriodInHours . $this->secretKey
            );
        } elseif ($this->authType === self::AUTH_MD5) {
            $this->md5 = md5($this->signerWmid . $this->payeePurse . $this->paymentNumber . $this->validityPeriodInHours . $this->secretKey);
        }
    }

    /**
     * @return string
     */
    public function getSignerWmid()
    {
        return $this->signerWmid;
    }

    /**
     * @param string $signerWmid
     */
    public function setSignerWmid($signerWmid)
    {
        $this->signerWmid = $signerWmid;
    }

    /**
     * @return int validityperiodinhours
     */
    public function getValidityPeriodInHours()
    {
        return $this->validityPeriodInHours;
    }

    /**
     * @param int $validityPeriodInHours validityperiodinhours
     */
    public function setValidityPeriodInHours($validityPeriodInHours)
    {
        $this->validityPeriodInHours = $validityPeriodInHours;
    }

    /**
     * @return string lmi_payee_purse
     */
    public function getPayeePurse()
    {
        return $this->payeePurse;
    }

    /**
     * @param string $payeePurse lmi_payee_purse
     */
    public function setPayeePurse($payeePurse)
    {
        $this->payeePurse = $payeePurse;
    }

    /**
     * @return float lmi_payment_amount
     */
    public function getPaymentAmount()
    {
        return $this->paymentAmount;
    }

    /**
     * @param float $paymentAmount lmi_payment_amount
     */
    public function setPaymentAmount($paymentAmount)
    {
        $this->paymentAmount = $paymentAmount;
    }

    /**
     * @return int lmi_payment_no
     */
    public function getPaymentNumber()
    {
        return $this->paymentNumber;
    }

    /**
     * @param int $paymentNumber lmi_payment_no
     */
    public function setPaymentNumber($paymentNumber)
    {
        $this->paymentNumber = $paymentNumber;
    }

    /**
     * @return string lmi_payment_desc
     */
    public function getPaymentDescription()
    {
        return $this->paymentDescription;
    }

    /**
     * @param string $paymentDescription lmi_payment_desc
     */
    public function setPaymentDescription($paymentDescription)
    {
        $this->paymentDescription = $paymentDescription;
    }

    /**
     * @return int lmi_sim_mode
     */
    public function getSimMode()
    {
        return $this->simMode;
    }

    /**
     * @param int $simMode lmi_sim_mode
     */
    public function setSimMode($simMode)
    {
        $this->simMode = $simMode;
    }

    /**
     * @return string lmi_result_url
     */
    public function getResultUrl()
    {
        return $this->resultUrl;
    }

    /**
     * @param string $resultUrl lmi_result_url
     */
    public function setResultUrl($resultUrl)
    {
        $this->resultUrl = $resultUrl;
    }

    /**
     * @return string lmi_success_url
     */
    public function getSuccessUrl()
    {
        return $this->successUrl;
    }

    /**
     * @param string $successUrl lmi_success_url
     */
    public function setSuccessUrl($successUrl)
    {
        $this->successUrl = $successUrl;
    }

    /**
     * @return string lmi_success_method
     */
    public function getSuccessMethod()
    {
        return $this->successMethod;
    }

    /**
     * @param string $successMethod lmi_success_method
     */
    public function setSuccessMethod($successMethod)
    {
        $this->successMethod = $successMethod;
    }

    /**
     * @return string lmi_fail_url
     */
    public function getFailUrl()
    {
        return $this->failUrl;
    }

    /**
     * @param string $failUrl lmi_fail_url
     */
    public function setFailUrl($failUrl)
    {
        $this->failUrl = $failUrl;
    }

    /**
     * @return string lmi_fail_method
     */
    public function getFailMethod()
    {
        return $this->failMethod;
    }

    /**
     * @param string $failMethod lmi_fail_method
     */
    public function setFailMethod($failMethod)
    {
        $this->failMethod = $failMethod;
    }

    /**
     * @return string lmi_paymer_pinnumberinside
     */
    public function getPaymerPinNumberInside()
    {
        return $this->paymerPinNumberInside;
    }

    /**
     * @param string $paymerPinNumberInside lmi_paymer_pinnumberinside
     */
    public function setPaymerPinNumberInside($paymerPinNumberInside)
    {
        $this->paymerPinNumberInside = $paymerPinNumberInside;
    }

    /**
     * @return string lmi_wmnote_pinnumberinside
     */
    public function getWmNotePinNumberInside()
    {
        return $this->wmNotePinNumberInside;
    }

    /**
     * @param string $wmNotePinNumberInside lmi_wmnote_pinnumberinside
     */
    public function setWmNotePinNumberInside($wmNotePinNumberInside)
    {
        $this->wmNotePinNumberInside = $wmNotePinNumberInside;
    }

    /**
     * @return string lmi_paymer_email
     */
    public function getPaymerEmail()
    {
        return $this->paymerEmail;
    }

    /**
     * @param string $paymerEmail lmi_paymer_email
     */
    public function setPaymerEmail($paymerEmail)
    {
        $this->paymerEmail = $paymerEmail;
    }

    /**
     * @return string lmi_wmcheck_numberinside
     */
    public function getWmCheckNumberInside()
    {
        return $this->wmCheckNumberInside;
    }

    /**
     * @param string $wmCheckNumberInside lmi_wmcheck_numberinside
     */
    public function setWmCheckNumberInside($wmCheckNumberInside)
    {
        $this->wmCheckNumberInside = $wmCheckNumberInside;
    }

    /**
     * @return string lmi_wmcheck_codeinside
     */
    public function getWmCheckCodeInside()
    {
        return $this->wmCheckCodeInside;
    }

    /**
     * @param string $wmCheckCodeInside lmi_wmcheck_codeinside
     */
    public function setWmCheckCodeInside($wmCheckCodeInside)
    {
        $this->wmCheckCodeInside = $wmCheckCodeInside;
    }

    /**
     * @return int lmi_allow_sdp
     */
    public function getAllowSdp()
    {
        return $this->allowSdp;
    }

    /**
     * @param int $allowSdp lmi_allow_sdp
     */
    public function setAllowSdp($allowSdp)
    {
        $this->allowSdp = $allowSdp;
    }

    /**
     * @return int lmi_fast_phonenumber
     */
    public function getFastPhoneNumber()
    {
        return $this->fastPhoneNumber;
    }

    /**
     * @param int $fastPhoneNumber lmi_fast_phonenumber
     */
    public function setFastPhoneNumber($fastPhoneNumber)
    {
        $this->fastPhoneNumber = $fastPhoneNumber;
    }

    /**
     * @return int lmi_payment_creditdays
     */
    public function getPaymentCreditDays()
    {
        return $this->paymentCreditDays;
    }

    /**
     * @param int $paymentCreditDays lmi_payment_creditdays
     */
    public function setPaymentCreditDays($paymentCreditDays)
    {
        $this->paymentCreditDays = $paymentCreditDays;
    }

    /**
     * @return int lmi_shop_id
     */
    public function getShopId()
    {
        return $this->shopId;
    }

    /**
     * @param int $shopId lmi_shop_id
     */
    public function setShopId($shopId)
    {
        $this->shopId = $shopId;
    }

    /**
     * @param string $tagName
     * @return string
     */
    public function getUserTag($tagName)
    {
        return isset($this->userTags[$tagName]) ? $this->userTags[$tagName] : null;
    }

    /**
     * @param string $tagName
     * @param string $tagValue
     * @throws ApiException
     */
    public function setUserTag($tagName, $tagValue)
    {
        $tagName = trim($tagName);
        if (empty($tagName)) {
            return;
        }
        if (preg_match('/^lmi_/i', $tagName)) {
            throw new ApiException('"LMI_" prefix for user tags is forbidden.');
        }
        if (preg_match('/^__/i', $tagName)) {
            throw new ApiException('"__" prefix for user tags is forbidden.');
        }
        if ($tagName == 'at') {
            throw new ApiException('Use setPaymentMethod() instead.');
        }
        $this->userTags[$tagName] = $tagValue;
    }

    /**
     * @return string
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * @param string $paymentMethod
     */
    public function setPaymentMethod($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
    }
}
