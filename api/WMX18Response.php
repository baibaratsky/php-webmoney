<?php

class WMX18Response extends WMApiResponse
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

    /** @var int retval */
    protected $_returnCode;

    /** @var string retdesc */
    protected $_returnDescription;

    /** @var int */
    protected $_paymentType;

    /** @var string operation/@wmtransid */
    protected $_transactionId;

    /** @var string operation/@wminvoiceid */
    protected $_invoiceId;

    /** @var float operation/amount */
    protected $_amount;

    /** @var DateTime operation/operdate */
    protected $_date;

    /** @var string operation/purpose */
    protected $_paymentDescription;

    /** @var string operation/pursefrom */
    protected $_fromPurse;

    /** @var string operation/wmidfrom */
    protected $_fromWmid;

    /** @var bool operation/capitallerflag */
    protected $_isCapitallerPurseUsed;

    /** @var bool operation/enumflag */
    protected $_isAuthorizedViaEnum;

    /** @var string operation/IPAddress */
    protected $_ip;

    /** @var string operation/telepat_phone */
    protected $_telepatPhone;

    /** @var int operation/telepat_paytype */
    protected $_telepatPaymentType;

    /** @var string operation/paymer_number */
    protected $_paymerNumber;

    /** @var string operation/paymer_email */
    protected $_paymerEmail;

    /** @var int operation/paymer_type */
    protected $_paymerPaymentType;

    /** @var string operation/cashier_number */
    protected $_cashierNumber;

    /** @var string operation/cashier_date */
    protected $_cashierDate;

    /** @var float operation/cashier_amount */
    protected $_cashierAmount;

    /** @var int operation/sdp_type */
    protected $_sdpType;

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        $responseObject = new SimpleXMLElement($response);
        $this->_returnCode = (int)$responseObject->retval;
        $this->_returnDescription = (string)$responseObject->retdesc;

        if (isset($responseObject->operation)) {
            $operation = $responseObject->operation;

            $this->_transactionId = (string)$operation['wmtransid'];
            $this->_invoiceId = (string)$operation['wminvoiceid'];
            $this->_amount = (float)$operation->amount;
            $this->_date = self::_createDateTime((string)$operation->operdate);
            $this->_paymentDescription = (string)$operation->purpose;
            $this->_fromPurse = (string)$operation->pursefrom;
            $this->_fromWmid = (string)$operation->wmidfrom;
            $this->_isCapitallerPurseUsed = (bool)$operation->capitallerflag;
            $this->_isAuthorizedViaEnum = (bool)$operation->enumflag;
            $this->_ip = (string)$operation->IPAddress;

            if (!empty($operation->telepat_phone)) {
                $this->_paymentType = self::PAYMENT_TYPE_TELEPAT;
                $this->_telepatPhone = (string)$operation->telepat_phone;
                $this->_telepatPaymentType = (int)$operation->telepat_paytype;
            } elseif (!empty($operation->paymer_number)) {
                $this->_paymentType = self::PAYMENT_TYPE_PAYMER;
                $this->_paymerNumber = (string)$operation->paymer_number;
                $this->_paymerEmail = (string)$operation->paymer_email;
                $this->_paymerPaymentType = (int)$operation->paymer_type;
            } elseif (!empty($operation->cashier_number)) {
                $this->_paymentType = self::PAYMENT_TYPE_CASHIER;
                $this->_cashierNumber = (string)$operation->cashier_number;
                $this->_cashierDate = self::_createDateTime((string)$operation->cashier_date);
                $this->_cashierAmount = (float)$operation->cashier_amount;
            } elseif (isset($operation->sdp_type)) {
                $this->_paymentType = self::PAYMENT_TYPE_SDP;
                $this->_sdpType = (int)$operation->sdp_type;
            } else {
                $this->_paymentType = self::PAYMENT_TYPE_USUAL;
            }
        }
    }

    /**
     * @return int
     */
    public function getReturnCode()
    {
        return $this->_returnCode;
    }

    /**
     * @return string
     */
    public function getReturnDescription()
    {
        return $this->_returnDescription;
    }

    /**
     * @return int
     */
    public function getPaymentType()
    {
        return $this->_paymentType;
    }

    /**
     * @return string
     */
    public function getTransactionId()
    {
        return $this->_transactionId;
    }

    /**
     * @return string
     */
    public function getInvoiceId()
    {
        return $this->_invoiceId;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->_amount;
    }

    /**
     * @return DateTime
     */
    public function getDate()
    {
        return $this->_date;
    }

    /**
     * @return string
     */
    public function getPaymentDescription()
    {
        return $this->_paymentDescription;
    }

    /**
     * @return string
     */
    public function getFromPurse()
    {
        return $this->_fromPurse;
    }

    /**
     * @return string
     */
    public function getFromWmid()
    {
        return $this->_fromWmid;
    }

    /**
     * @return bool
     */
    public function getIsCapitallerPurseUsed()
    {
        return $this->_isCapitallerPurseUsed;
    }

    /**
     * @return bool
     */
    public function getIsAuthorizedViaEnum()
    {
        return $this->_isAuthorizedViaEnum;
    }

    /**
     * @return string
     */
    public function getIp()
    {
        return $this->_ip;
    }

    /**
     * @return string
     */
    public function getTelepatPhone()
    {
        return $this->_telepatPhone;
    }

    /**
     * @return int
     */
    public function getTelepatPaymentType()
    {
        return $this->_telepatPaymentType;
    }

    /**
     * @return string
     */
    public function getPaymerNumber()
    {
        return $this->_paymerNumber;
    }

    /**
     * @return string
     */
    public function getPaymerEmail()
    {
        return $this->_paymerEmail;
    }

    /**
     * @return int
     */
    public function getPaymerPaymentType()
    {
        return $this->_paymerPaymentType;
    }

    /**
     * @return string
     */
    public function getCashierNumber()
    {
        return $this->_cashierNumber;
    }

    /**
     * @return string
     */
    public function getCashierDate()
    {
        return $this->_cashierDate;
    }

    /**
     * @return float
     */
    public function getCashierAmount()
    {
        return $this->_cashierAmount;
    }

    /**
     * @return int
     */
    public function getSdpType()
    {
        return $this->_sdpType;
    }
}
