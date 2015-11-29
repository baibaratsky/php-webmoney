<?php

namespace baibaratsky\WebMoney\Api\X\X21\TrustConfirm;

use baibaratsky\WebMoney\Api\X;
use baibaratsky\WebMoney\Exception\ApiException;
use baibaratsky\WebMoney\Request\RequestValidator;
use baibaratsky\WebMoney\Signer;

/**
 * Class Request
 *
 * @link http://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X21
 */
class Request extends X\Request
{
    /** @var int lmi_purseid */
    protected $purseId;

    /** @var string lmi_clientnumber_code */
    protected $confirmationCode = 0;  // default value for SMS_TYPE_USSD

    const LANGUAGE_RU = 'ru-RU';
    const LANGUAGE_EN = 'en-US';

    /** @var string lang */
    protected $language;

    /**
     * @param string $authType
     *
     * @throws ApiException
     */
    public function __construct($authType = self::AUTH_CLASSIC)
    {
        switch ($authType) {
            case self::AUTH_CLASSIC:
                $this->url = 'https://merchant.webmoney.ru/conf/xml/XMLTrustConfirm.asp';
                break;

            case self::AUTH_LIGHT:
                $this->url = 'https://merchant.wmtransfer.com/conf/xml/XMLTrustConfirm.asp';
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
            RequestValidator::TYPE_REQUIRED => array(
                'signerWmid',
                'purseId',
                'confirmationCode'
            ),
            RequestValidator::TYPE_RANGE => array(
                'language' => array(
                    self::LANGUAGE_RU,
                    self::LANGUAGE_EN
                )
            )
        );
    }

    /**
     * @return string
     */
    public function getData()
    {
        $xml = '<merchant.request>';
        $xml .= self::xmlElement('wmid', $this->signerWmid);
        $xml .= self::xmlElement('lmi_purseid', $this->purseId);
        $xml .= self::xmlElement('lmi_clientnumber_code', $this->confirmationCode);
        $xml .= self::xmlElement('sign', $this->signature);
        $xml .= self::xmlElement('lang', $this->language);
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
            $this->signature = $requestSigner->sign(
                $this->signerWmid
                . $this->purseId
                . $this->confirmationCode
            );
        }
    }

    /**
     * @return int lmi_purseid
     */
    public function getPurseId()
    {
        return $this->purseId;
    }

    /**
     * @param int $purseId lmi_purseid
     */
    public function setPurseId($purseId)
    {
        $this->purseId = $purseId;
    }

    /**
     * @return string lmi_clientnumber_code
     */
    public function getConfirmationCode()
    {
        return $this->confirmationCode;
    }

    /**
     * @param string $confirmationCode lmi_clientnumber_code
     */
    public function setConfirmationCode($confirmationCode)
    {
        $this->confirmationCode = $confirmationCode;
    }

    /**
     * @return string lang
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param string $language lang
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }
}
