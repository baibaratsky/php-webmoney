<?php

namespace baibaratsky\WebMoney\Api\X\X18;

use baibaratsky\WebMoney\Request\AbstractResponse;

class Response extends AbstractResponse
{
    const PAYMENT_TYPE_USUAL = 0;
    const PAYMENT_TYPE_TELEPAT = 1;
    const PAYMENT_TYPE_PAYMER = 2;
    const PAYMENT_TYPE_CASHIER = 3;
    const PAYMENT_TYPE_SDP = 4;

    const TELEPAT_PAYMENT_TYPE_KEEPER_MOBILE = 0;
    const TELEPAT_PAYMENT_TYPE_SMS = 1;
    const TELEPAT_PAYMENT_TYPE_MOBILE_PAYMENT = 2;

    const PAYMER_PAYMENT_TYPE_CHECK_OR_WM_CARD = 0;
    const PAYMER_PAYMENT_TYPE_WM_NOTE = 1;
    const PAYMER_PAYMENT_TYPE_WEBMONEY_CHECK = 2;

    const SDP_TYPE_MONEY_TRANSFER = 0;
    const SDP_TYPE_ALFA_CLICK = 3;
    const SDP_TYPE_RU_CARD = 4;
    const SDP_TYPE_RUSSIAN_STANDARD = 5;
    const SDP_TYPE_VTB24 = 6;
    const SDP_TYPE_SBERBANK_THANK_YOU = 7;
    const SDP_TYPE_UA_TERMINALS_AND_BANKS = 8;

    /** @var int */
    protected $paymentType;

    /** @var string operation/@wmtransid */
    protected $transactionId;

    /** @var string operation/@wminvoiceid */
    protected $invoiceId;

    /** @var float operation/amount */
    protected $amount;

    /** @var \DateTime operation/operdate */
    protected $date;

    /** @var string operation/purpose */
    protected $paymentDescription;

    /** @var string operation/pursefrom */
    protected $fromPurse;

    /** @var string operation/wmidfrom */
    protected $fromWmid;

    /** @var bool operation/capitallerflag */
    protected $isCapitallerPurseUsed;

    /** @var bool operation/enumflag */
    protected $isAuthorizedViaEnum;

    /** @var string operation/IPAddress */
    protected $ip;

    /** @var string operation/telepat_phone */
    protected $telepatPhone;

    /** @var int operation/telepat_paytype */
    protected $telepatPaymentType;

    /** @var string operation/paymer_number */
    protected $paymerNumber;

    /** @var string operation/paymer_email */
    protected $paymerEmail;

    /** @var int operation/paymer_type */
    protected $paymerPaymentType;

    /** @var string operation/cashier_number */
    protected $cashierNumber;

    /** @var string operation/cashier_date */
    protected $cashierDate;

    /** @var float operation/cashier_amount */
    protected $cashierAmount;

    /** @var int operation/sdp_type */
    protected $sdpType;

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        $responseObject = new \SimpleXMLElement($response);
        $this->returnCode = (int)$responseObject->retval;
        $this->returnDescription = (string)$responseObject->retdesc;

        if (isset($responseObject->operation)) {
            $operation = $responseObject->operation;

            $this->transactionId = (string)$operation['wmtransid'];
            $this->invoiceId = (string)$operation['wminvoiceid'];
            $this->amount = (float)$operation->amount;
            $this->date = self::createDateTime((string)$operation->operdate);
            $this->paymentDescription = (string)$operation->purpose;
            $this->fromPurse = (string)$operation->pursefrom;
            $this->fromWmid = (string)$operation->wmidfrom;
            $this->isCapitallerPurseUsed = (bool)$operation->capitallerflag;
            $this->isAuthorizedViaEnum = (bool)$operation->enumflag;
            $this->ip = (string)$operation->IPAddress;

            if (!empty($operation->telepat_phone)) {
                $this->paymentType = self::PAYMENT_TYPE_TELEPAT;
                $this->telepatPhone = (string)$operation->telepat_phone;
                $this->telepatPaymentType = (int)$operation->telepat_paytype;
            } elseif (!empty($operation->paymer_number)) {
                $this->paymentType = self::PAYMENT_TYPE_PAYMER;
                $this->paymerNumber = (string)$operation->paymer_number;
                $this->paymerEmail = (string)$operation->paymer_email;
                $this->paymerPaymentType = (int)$operation->paymer_type;
            } elseif (!empty($operation->cashier_number)) {
                $this->paymentType = self::PAYMENT_TYPE_CASHIER;
                $this->cashierNumber = (string)$operation->cashier_number;
                $this->cashierDate = self::createDateTime((string)$operation->cashier_date);
                $this->cashierAmount = (float)$operation->cashier_amount;
            } elseif (isset($operation->sdp_type)) {
                $this->paymentType = self::PAYMENT_TYPE_SDP;
                $this->sdpType = (int)$operation->sdp_type;
            } else {
                $this->paymentType = self::PAYMENT_TYPE_USUAL;
            }
        }
    }

    /**
     * @return int
     */
    public function getPaymentType()
    {
        return $this->paymentType;
    }

    /**
     * @return string
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * @return string
     */
    public function getInvoiceId()
    {
        return $this->invoiceId;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getPaymentDescription()
    {
        return $this->paymentDescription;
    }

    /**
     * @return string
     */
    public function getFromPurse()
    {
        return $this->fromPurse;
    }

    /**
     * @return string
     */
    public function getFromWmid()
    {
        return $this->fromWmid;
    }

    /**
     * @return bool
     */
    public function getIsCapitallerPurseUsed()
    {
        return $this->isCapitallerPurseUsed;
    }

    /**
     * @return bool
     */
    public function getIsAuthorizedViaEnum()
    {
        return $this->isAuthorizedViaEnum;
    }

    /**
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @return string
     */
    public function getTelepatPhone()
    {
        return $this->telepatPhone;
    }

    /**
     * @return int
     */
    public function getTelepatPaymentType()
    {
        return $this->telepatPaymentType;
    }

    /**
     * @return string
     */
    public function getPaymerNumber()
    {
        return $this->paymerNumber;
    }

    /**
     * @return string
     */
    public function getPaymerEmail()
    {
        return $this->paymerEmail;
    }

    /**
     * @return int
     */
    public function getPaymerPaymentType()
    {
        return $this->paymerPaymentType;
    }

    /**
     * @return string
     */
    public function getCashierNumber()
    {
        return $this->cashierNumber;
    }

    /**
     * @return string
     */
    public function getCashierDate()
    {
        return $this->cashierDate;
    }

    /**
     * @return float
     */
    public function getCashierAmount()
    {
        return $this->cashierAmount;
    }

    /**
     * @return int
     */
    public function getSdpType()
    {
        return $this->sdpType;
    }
}
