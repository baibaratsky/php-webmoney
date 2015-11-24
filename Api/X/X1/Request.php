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

    /** @var int invoice/orderid */
    protected $orderId;

    /** @var int invoice/customerwmid */
    protected $customerWmid;

    /** @var string invoice/storepurse */
    protected $purse;

    /** @var float invoice/amount */
    protected $amount;

    /** @var string invoice/desc */
    protected $description;

    /** @var string invoice/address */
    protected $address;

    /** @var int invoice/period */
    protected $protectionPeriod = 0;

    /** @var int invoice/expiration */
    protected $expiration = 0;

    /** @var bool invoice/onlyauth */
    protected $onlyAuth;

    /** @var int invoice/lmi_shop_id */
    protected $shopId;

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
                    $this->orderId .
                    $this->customerWmid .
                    $this->purse .
                    $this->amount .
                    mb_convert_encoding($this->description, 'Windows-1251', 'UTF-8') .
                    $this->address .
                    $this->protectionPeriod .
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
                RequestValidator::TYPE_REQUIRED => array('customerWmid', 'purse', 'amount', 'protectionPeriod',
                                                         'expiration'),
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
        $xml .= self::xmlElement('orderid', $this->orderId);
        $xml .= self::xmlElement('customerwmid', $this->customerWmid);
        $xml .= self::xmlElement('storepurse', $this->purse);
        $xml .= self::xmlElement('amount', $this->amount);
        $xml .= self::xmlElement('desc', $this->description);
        $xml .= self::xmlElement('address', $this->address);
        $xml .= self::xmlElement('period', $this->protectionPeriod);
        $xml .= self::xmlElement('expiration', $this->expiration);
        $xml .= self::xmlElement('onlyauth', (int)$this->onlyAuth);
        $xml .= self::xmlElement('lmi_shop_id', $this->shopId);
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
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param $orderId
     *
     * @return string
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * @return string
     */
    public function getCustomerWmid()
    {
        return $this->customerWmid;
    }

    /**
     * @param $customerWmid
     *
     * @return string
     */
    public function setCustomerWmid($customerWmid)
    {
        $this->customerWmid = $customerWmid;
    }

    /**
     * @return string
     */
    public function getPurse()
    {
        return $this->purse;
    }

    /**
     * @param $purse
     *
     * @return string
     */
    public function setPurse($purse)
    {
        $this->purse = $purse;
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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param $description
     *
     * @return float
     */
    public function setDescription($description)
    {
        $this->description = $description;
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
    public function getProtectionPeriod()
    {
        return $this->protectionPeriod;
    }

    /**
     * @param $protectionPeriod
     *
     * @return string
     */
    public function setProtectionPeriod($protectionPeriod)
    {
        $this->protectionPeriod = $protectionPeriod;
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
     * @return bool
     */
    public function getOnlyAuth()
    {
        return $this->onlyAuth;
    }

    /**
     * @param bool $onlyAuth
     *
     * @return bool
     */
    public function setOnlyAuth($onlyAuth)
    {
        $this->onlyAuth = $onlyAuth;
    }

    /**
     * @return int
     */
    public function getShopId()
    {
        return $this->shopId;
    }

    /**
     * @param $shopId
     *
     * @return int
     */
    public function setShopId($shopId)
    {
        $this->shopId = $shopId;
    }
}
