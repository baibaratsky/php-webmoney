<?php

namespace baibaratsky\WebMoney\Api\WMC\WMC1;

use baibaratsky\WebMoney\Api\WMC;
use baibaratsky\WebMoney\Exception\ApiException;
use baibaratsky\WebMoney\Request\RequestValidator;
use baibaratsky\WebMoney\Signer;

/**
 * Class Request
 *
 * @link http://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_WMC1
 */
class Request extends WMC\Request
{
    const TRANSACTION_TYPE_REAL = 0;
    const TRANSACTION_TYPE_TEST = 1;

    /** @var int payment/@id */
    protected $transactionId;

    /** @var string payment/@currency */
    protected $currency;

    /** @var int payment/@test */
    protected $test;

    /** @var string payment/purse */
    protected $payeePurse;

    /** @var int payment/phone */
    protected $phone = 0;

    /** @var float payment/price */
    protected $price;

    /** @var string payment/date */
    protected $date;

    /** @var int payment/point */
    protected $point;

    /**
     * @param string $authType
     *
     * @throws ApiException
     */
    public function __construct($authType = self::AUTH_CLASSIC)
    {
        switch ($authType) {
            case self::AUTH_CLASSIC:
                $this->url = 'https://transfer.gdcert.com/ATM/Xml/Payment1.ashx';
                break;

            case self::AUTH_LIGHT:
                $this->url = 'https://transfer.gdcert.com/ATM/Xml/Payment1.ashx';
                $this->signature = base64_encode(
                    $this->getSignerWmid() . $this->getTransactionId() .
                    $this->getCurrency() . $this->getTest() .
                    $this->getPayeePurse() . $this->getPhone() .
                    $this->getPrice() . $this->getDate() .
                    $this->getPoint()
                );

                break;

            default:
                throw new ApiException('This interface doesn\'t support the authentication type given.');
        }

        $this->setTest(self::TRANSACTION_TYPE_REAL);

        parent::__construct($authType);
    }

    /**
     * @return array
     */
    protected function getValidationRules()
    {
        return array(
            RequestValidator::TYPE_REQUIRED => array(
                'price', 'currency'
            )
        );
    }

    /**
     * @return string
     */
    public function getData()
    {
        $xml = '<w3s.request lang="' . $this->getLang() . '">';
        $xml .= self::xmlElement('wmid', $this->getSignerWmid());
        $xml .= '<sign type="' . $this->getAuthTypeNum() . '">' . $this->signature . '</sign>';
        $xml .= '<payment id="' . $this->getTransactionId() . '" currency="' . $this->getCurrency() . '" test="' . $this->getTest() . '">';
        $xml .= self::xmlElement('purse', $this->getPayeePurse());
        $xml .= self::xmlElement('phone', $this->getPhone());
        $xml .= self::xmlElement('price', $this->getPrice());
        $xml .= self::xmlElement('date', $this->getDate());
        $xml .= self::xmlElement('point', $this->getPoint());
        $xml .= '</payment>';
        $xml .= '</w3s.request>';

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
                $this->getSignerWmid() . $this->getTransactionId() .
                $this->getCurrency() . $this->getTest() .
                $this->getPayeePurse() . $this->getPhone() .
                $this->getPrice() . $this->getDate() .
                $this->getPoint()
            );
        }
    }

    /**
     * @return int
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * @param int
     */
    public function setTransactionId($id)
    {
        $this->transactionId = (int)$id;
    }

    /**
     * @return string
     */
    public function getPayeePurse()
    {
        return $this->payeePurse;
    }

    /**
     * @param string $payeePurse
     */
    public function setPayeePurse($payeePurse)
    {
        $this->payeePurse = (string)$payeePurse;
    }

    /**
     * @return float
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param $phone
     */
    public function setPhone($phone)
    {
        $this->phone = (string)$phone;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param $price
     */
    public function setPrice($price)
    {
        $this->price = (float)$price;
    }

    /**
     * @return int
     */
    public function getTest()
    {
        return $this->test;
    }

    /**
     * @param $test
     */
    public function setTest($test)
    {
        $this->test = (int)$test;
    }

    /**
     * @return string "USD"|"EUR"
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param $currency "USD"|"EUR"
     */
    public function setCurrency($currency)
    {
        $this->currency = (string)$currency;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param string YYYYMMDD HH:mm:ss
     */
    public function setDate($date)
    {
        $this->date = (string)$date;
    }

    /**
     * @return int
     */
    public function getPoint()
    {
        return $this->point;
    }

    /**
     * @param int
     */
    public function setPoint($point)
    {
        $this->point = (int)$point;
    }
}
