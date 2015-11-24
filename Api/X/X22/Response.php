<?php

namespace baibaratsky\WebMoney\Api\X\X22;

use baibaratsky\WebMoney\Request\AbstractResponse;
use baibaratsky\WebMoney\Exception\ApiException;

class Response extends AbstractResponse
{
    /** @var string transtoken */
    protected $transactionToken;

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
            $this->transactionToken = (string)$responseObject->transtoken;
        }

        if (isset($responseObject->validityperiodinhours)) {
            $this->validityPeriodInHours = (string)$responseObject->validityperiodinhours;
        }
    }

    /**
     * @return string token
     */
    public function getTransactionToken()
    {
        return $this->transactionToken;
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
     * @param string $lang
     * @throws ApiException
     * @return string URL
     */
    public function getUrl($lang = self::URL_LANG_EN)
    {
        switch ($lang) {
            case self::URL_LANG_RU:
                return 'https://merchant.webmoney.ru/lmi/payment.asp?gid=' . $this->transactionToken;
            case self::URL_LANG_EN:
                return 'https://merchant.wmtransfer.com/lmi/payment.asp?gid=' . $this->transactionToken;
            default:
                throw new ApiException('Unknown lang value: ' . $lang);
        }
    }
}
