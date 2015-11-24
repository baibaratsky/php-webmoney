<?php

namespace baibaratsky\WebMoney\Api\X\X22;

use baibaratsky\WebMoney\Request\AbstractResponse;
use baibaratsky\WebMoney\Exception\ApiException;

class Response extends AbstractResponse
{
    /** @var string transtoken */
    protected $transToken;

    /** @var int validityperiodinhours */
    protected $validityPeriodInHours;

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $responseObject = new \SimpleXMLElement($response);
        $this->returnCode = (int)$responseObject->retval;
        $this->returnDescription = (string)$responseObject->retdesc;

        if (isset($responseObject->transtoken)) {
            $this->transToken = (string)$responseObject->transtoken;
        }

        if (isset($responseObject->validityperiodinhours)) {
            $this->validityPeriodInHours = (string)$responseObject->validityperiodinhours;
        }
    }

    /**
     * @return string token
     */
    public function getTransToken()
    {
        return $this->transToken;
    }

    /**
     * @return string
     */
    public function getValidityPeriodInHours()
    {
        return $this->validityPeriodInHours;
    }

    const URL_LANG_RU = 'ru';
    const URL_LANG_EN = 'en';

    /**
     * @param string $token
     * @param string $lang
     * @throws ApiException
     * @return string URL
     */
    public static function getUrl($token, $lang = self::URL_LANG_EN)
    {
        switch ($lang) {
            case self::URL_LANG_RU:
                return 'https://merchant.webmoney.ru/lmi/payment.asp?gid=' . $token;
            case self::URL_LANG_EN:
                return 'https://merchant.wmtransfer.com/lmi/payment.asp?gid=' . $token;
            default:
                throw new ApiException('Unknown lang value: ' . $lang);
        }
    }
}
