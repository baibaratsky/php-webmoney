<?php

namespace baibaratsky\WebMoney\Api\X\X1;

use baibaratsky\WebMoney\Api\X;
use baibaratsky\WebMoney\Signer;
use baibaratsky\WebMoney\Request\RequestValidator;
use baibaratsky\WebMoney\Exception\ApiException;

/**
 * Class Request
 *
 * @link https://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X1
 */
class Request extends X\Request
{
    /** @var string wmid */
    protected $signerWmid;
    /** @var string getpurses/wmid */
    protected $requestedWmid;
    /** @var int invoice/orderid */
    protected $orderid;
    /** @var int invoice/customerwmid */
    protected $customerwmid;
    /** @var string invoice/storepurse */
    protected $storepurse;
    /** @var float invoice/amount */
    protected $amount;
    /** @var string invoice/desc */
    protected $desc;
    /** @var string invoice/address */
    protected $address;
    /** @var int invoice/period */
    protected $period;
    /** @var int invoice/expiration */
    protected $expiration;
    /** @var int invoice/onlyauth */
    protected $onlyauth;
    /** @var int invoice/lmi_shop_id */
    protected $lmiShopId;

    public function __construct($authType = self::AUTH_CLASSIC)
    {
        if ($authType === self::AUTH_CLASSIC) {
            $this->url = 'https://w3s.webmoney.ru/asp/XMLInvoice.asp';
        } else {
            throw new ApiException('This interface doesn\'t support the authentication type given.');
        }

        parent::__construct($authType);
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
     *
     */
    public function sign(Signer $requestSigner = null)
    {
        if ($this->authType === self::AUTH_CLASSIC) {
            $this->signature = $requestSigner->sign(
                $this->orderid .
                $this->customerwmid .
                $this->storepurse .
                $this->amount .
                mb_convert_encoding($this->desc, 'Windows-1251', 'UTF-8') .
                $this->address .
                $this->period .
                $this->expiration .
                $this->requestNumber);
        }
    }

    /**
     * @return array
     */
    protected function getValidationRules()
    {
        return array(
            RequestValidator::TYPE_DEPEND_REQUIRED => array(
                'signerWmid' => array('authType' => array(self::AUTH_CLASSIC)),
            ),
        );
    }

    /**
     * @return string
     */
    public function getData()
    {
        $xml = '<w3s.request>';
        $xml .= self::xmlElement('reqn', $this->requestNumber);
        $xml .= self::xmlElement('wmid', $this->signerWmid);
        $xml .= self::xmlElement('sign', $this->signature);
        $xml .= '<invoice>';
        $xml .= self::xmlElement('orderid', $this->orderid);
        $xml .= self::xmlElement('customerwmid', $this->customerwmid);
        $xml .= self::xmlElement('storepurse', $this->storepurse);
        $xml .= self::xmlElement('amount', $this->amount);
        $xml .= self::xmlElement('desc', $this->desc);
        $xml .= self::xmlElement('address', $this->address);
        $xml .= self::xmlElement('period', $this->period);
        $xml .= self::xmlElement('expiration', $this->expiration);
        $xml .= self::xmlElement('onlyauth', $this->onlyauth);
        $xml .= self::xmlElement('lmi_shop_id', $this->lmiShopId);
        $xml .= '</invoice>';
        $xml .= '</w3s.request>';

        return $xml;
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
     * @return string
     */
    public function getRequestedWmid()
    {
        return $this->requestedWmid;
    }

    /**
     * @param string $requestedWmid
     */
    public function setRequestedWmid($requestedWmid)
    {
        $this->requestedWmid = $requestedWmid;
    }

    /**
     * @return string
     */
    public function getOrderid()
    {
        return $this->orderid;
    }

    /**
     * @param $orderid
     *
     * @return string
     */
    public function setOrderid($orderid)
    {
        $this->orderid = $orderid;
    }

    /**
     * @return string
     */
    public function getCustomerwmid()
    {
        return $this->customerwmid;
    }

    /**
     * @param $customerwwmid
     *
     * @return string
     */
    public function setCustomerwmid($customerwwmid)
    {
        $this->customerwmid = $customerwwmid;
    }

    /**
     * @return string
     */
    public function getStorepurse()
    {
        return $this->storepurse;
    }

    /**
     * @param $storepurse
     *
     * @return string
     */
    public function setStorepurse($storepurse)
    {
        $this->storepurse = $storepurse;
    }

    /**
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param $amount
     *
     * @return string
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return float
     */
    public function getDesc()
    {
        return $this->desc;
    }

    /**
     * @param $desc
     *
     * @return float
     */
    public function setDesc($desc)
    {
        $this->desc = $desc;
    }

    /**
     * @return float
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param $address
     *
     * @return float
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getPeriod()
    {
        return $this->period;
    }

    /**
     * @param $period
     *
     * @return string
     */
    public function setPeriod($period)
    {
        $this->period = $period;
    }

    /**
     * @return int
     */
    public function getExpiration()
    {
        return $this->expiration;
    }

    /**
     * @param $expiration
     *
     * @return int
     */
    public function setExpiration($expiration)
    {
        $this->expiration = $expiration;
    }

    /**
     * @return int
     */
    public function getOnlyauth()
    {
        return $this->onlyauth;
    }

    /**
     * @param $onlyauth
     *
     * @return int
     */
    public function setOnlyauth($onlyauth)
    {
        $this->onlyauth = $onlyauth;
    }

    /**
     * @return int
     */
    public function getLmiShopId()
    {
        return $this->lmiShopId;
    }

    /**
     * @param $lmiShopId
     *
     * @return int
     */
    public function setLmiShopId($lmiShopId)
    {
        $this->lmiShopId = $lmiShopId;
    }
}
