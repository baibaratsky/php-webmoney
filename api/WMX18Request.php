<?php

/**
 * Class WMX18Request
 *
 * @link https://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X18
 *
 * @todo: validation rules
 * @todo: lmi_payment_no_type constants
 */
class WMX18Request extends WMApiRequest
{
    /** @var string wmid */
    protected $_signerWmid;

    /** @var string sign */
    protected $_sign;

    /** @var string lmi_payee_purse */
    protected $_payeePurse;

    /** @var string lmi_payment_no */
    protected $_paymentNumber;

    /** @var int lmi_payment_no_type */
    protected $_paymentNumberType;

    /** @var string md5 */
    protected $_md5;

    /** @var string secret_key */
    protected $_secretKey;

    public function __construct($authType = self::AUTH_CLASSIC, $secretKey = null)
    {
        if ($secretKey === null && ($authType === self::AUTH_MD5 || $authType === self::AUTH_SECRET_KEY)) {
            throw new WMException('Secret key is required for this authentication type.');
        }

        $this->_secretKey = $secretKey;

        parent::__construct($authType);
    }

    public function getUrl()
    {
        return 'https://merchant.webmoney.ru/conf/xml/XMLTransGet.asp';
    }

    public function getXml()
    {
        $this->_xml = '<merchant.request>';
        $this->_addElementToXml('wmid', $this->_signerWmid);
        $this->_addElementToXml('lmi_payee_purse', $this->_payeePurse);
        $this->_addElementToXml('lmi_payment_no', $this->_paymentNumber);
        $this->_addElementToXml('lmi_payment_no_type', $this->_paymentNumberType);
        $this->_addElementToXml('sign', $this->_sign);
        $this->_addElementToXml('md5', $this->_md5);

        if ($this->_authType === self::AUTH_SECRET_KEY) {
            $this->_addElementToXml('secret_key', $this->_secretKey);
        }

        $this->_xml .= '</merchant.request>';

        return $this->_xml;
    }

    public function getResponseClassName()
    {
        return 'WMX18Response';
    }

    public function sign(WMRequestSigner $requestSigner)
    {
        if ($this->_authType === self::AUTH_CLASSIC) {
            $this->_sign = $requestSigner->sign($this->_signerWmid . $this->_payeePurse . $this->_paymentNumber);
        } else if ($this->_authType === self::AUTH_MD5) {
            $this->_md5 = md5($this->_signerWmid . $this->_payeePurse . $this->_paymentNumber . $this->_secretKey);
        }
    }

    /**
     * @param string $payeePurse
     */
    public function setPayeePurse($payeePurse)
    {
        $this->_payeePurse = $payeePurse;
    }

    /**
     * @return string
     */
    public function getPayeePurse()
    {
        return $this->_payeePurse;
    }

    /**
     * @param string $paymentNumber
     */
    public function setPaymentNumber($paymentNumber)
    {
        $this->_paymentNumber = $paymentNumber;
    }

    /**
     * @return string
     */
    public function getPaymentNumber()
    {
        return $this->_paymentNumber;
    }

    /**
     * @param int $paymentNumberType
     */
    public function setPaymentNumberType($paymentNumberType)
    {
        $this->_paymentNumberType = $paymentNumberType;
    }

    /**
     * @return int
     */
    public function getPaymentNumberType()
    {
        return $this->_paymentNumberType;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array(
            'authType' => $this->_authType,
            'signerWmid' => $this->_signerWmid,
            'payeePurse' => $this->_payeePurse,
            'paymentNumber' => $this->_paymentNumber,
            'paymentNumberType' => $this->_paymentNumberType,
        );
    }
}
