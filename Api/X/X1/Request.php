<?php

namespace baibaratsky\WebMoney\Api\X\X1;

use baibaratsky\WebMoney\Api\X;
use baibaratsky\WebMoney\Exception\ApiException;
use baibaratsky\WebMoney\Request\RequestValidator;
use baibaratsky\WebMoney\Signer;

/**
 * Class Request
 *
 * @link https://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X1
 */
class Request extends X\Request
{
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

    /** @var int invoice/onlyauth */
    protected $onlyAuth;

    /** @var int invoice/lmi_shop_id */
    protected $shopId;

    public function __construct($authType = self::AUTH_CLASSIC)
    {
        switch ($authType) {
            case self::AUTH_CLASSIC:
                $this->url = 'https://w3s.webmoney.ru/asp/XMLInvoice.asp';
                break;

            case self::AUTH_LIGHT:
                $this->url = 'https://w3s.wmtransfer.com/asp/XMLInvoiceCert.asp';
                break;

            default:
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
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param string $orderId
     */
    public function setOrderId($orderId)
    {
        $this->orderId = (string)$orderId;
    }

    /**
     * @return string
     */
    public function getCustomerWmid()
    {
        return $this->customerWmid;
    }

    /**
     * @param string $customerWmid
     */
    public function setCustomerWmid($customerWmid)
    {
        $this->customerWmid = (string)$customerWmid;
    }

    /**
     * @return string
     */
    public function getPurse()
    {
        return $this->purse;
    }

    /**
     * @param string $purse
     */
    public function setPurse($purse)
    {
        $this->purse = (string)$purse;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount($amount)
    {
        $this->amount = (float)$amount;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = (string)$description;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = (string)$address;
    }

    /**
     * @return int
     */
    public function getProtectionPeriod()
    {
        return $this->protectionPeriod;
    }

    /**
     * @param int $protectionPeriod
     */
    public function setProtectionPeriod($protectionPeriod)
    {
        $this->protectionPeriod = (int)$protectionPeriod;
    }

    /**
     * @return int
     */
    public function getExpiration()
    {
        return $this->expiration;
    }

    /**
     * @param int $expiration
     */
    public function setExpiration($expiration)
    {
        $this->expiration = (int)$expiration;
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
     */
    public function setOnlyAuth($onlyAuth)
    {
        $this->onlyAuth = (int)$onlyAuth;
    }

    /**
     * @return int
     */
    public function getShopId()
    {
        return $this->shopId;
    }

    /**
     * @param int $shopId
     */
    public function setShopId($shopId)
    {
        $this->shopId = (int)$shopId;
    }
}
