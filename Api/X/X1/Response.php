<?php

namespace baibaratsky\WebMoney\Api\X\X1;

use baibaratsky\WebMoney\Request\AbstractResponse;

/**
 * Class Response
 *
 * @link https://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X1
 */
class Response extends AbstractResponse
{
    const STATUS_NOT_PAID = 0;
    const STATUS_PAID_WITH_PROTECTION = 1;
    const STATUS_PAID = 2;
    const STATUS_DECLINED = 3;

    /** @var int reqn */
    protected $requestNumber;

    /** @var int @id */
    protected $invoiceId;

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
    protected $protectionPeriod;

    /** @var int invoice/expiration */
    protected $expiration;

    /** @var int invoice/state */
    protected $status;

    /** @var \DateTime invoice/datecrt */
    protected $createDateTime;

    /** @var \DateTime invoice/dateupd */
    protected $updateDateTime;

    public function __construct($response)
    {
        parent::__construct($response);

        $responseObject = new \SimpleXMLElement($response);
        $this->requestNumber = (int)$responseObject->reqn;
        $this->returnCode = (int)$responseObject->retval;
        $this->returnDescription = (string)$responseObject->retdesc;

        if (isset($responseObject->invoice)) {
            $invoice = $responseObject->invoice;
            $this->invoiceId = (int)$invoice['id'];
            $this->orderId = (string)$invoice->orderid;
            $this->customerWmid = (string)$invoice->customerwmid;
            $this->purse = (string)$invoice->storepurse;
            $this->amount = (float)$invoice->amount;
            $this->description = (string)$invoice->desc;
            $this->address = (string)$invoice->address;
            $this->protectionPeriod = (int)$invoice->period;
            $this->expiration = (int)$invoice->expiration;
            $this->status = (int)$invoice->state;
            $this->createDateTime = self::createDateTime((string)$invoice->datecrt); //wm format Ymd H:i:s
            $this->updateDateTime = self::createDateTime((string)$invoice->dateupd); //wm format Ymd H:i:s
        }
    }

    /**
     * @return int
     */
    public function getRequestNumber()
    {
        return $this->requestNumber;
    }

    /**
     * @return int
     */
    public function getInvoiceId()
    {
        return $this->invoiceId;
    }

    /**
     * @return string
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @return string
     */
    public function getCustomerWmid()
    {
        return $this->customerWmid;
    }

    /**
     * @return string
     */
    public function getPurse()
    {
        return $this->purse;
    }

    /**
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return float
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return float
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getProtectionPeriod()
    {
        return $this->protectionPeriod;
    }

    /**
     * @return int
     */
    public function getExpiration()
    {
        return $this->expiration;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return \DateTime
     */
    public function getCreateDateTime()
    {
        return $this->createDateTime;
    }

    /**
     * @return \DateTime
     */
    public function getUpdateDateTime()
    {
        return $this->updateDateTime;
    }
}
