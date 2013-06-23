<?php

/**
 * Class WMX18Request
 *
 * @link https://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X18
 */
class WMX18Request extends WMXmlApiRequest
{
    const PAYMENT_NUMBER_TYPE_DEFAULT = 0;
    const PAYMENT_NUMBER_TYPE_ORDER = 1;
    const PAYMENT_NUMBER_TYPE_INVOICE = 2;
    const PAYMENT_NUMBER_TYPE_TRANSACTION = 3;

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

    /**
     * @param string $authType
     * @param string $secretKey
     * @throws WMException
     */
    public function __construct($authType = self::AUTH_CLASSIC, $secretKey = null)
    {
        if ($secretKey === null && ($authType === self::AUTH_MD5 || $authType === self::AUTH_SECRET_KEY)) {
            throw new WMException('Secret key is required for this authentication type.');
        }

        $this->_url = 'https://merchant.webmoney.ru/conf/xml/XMLTransGet.asp';
        $this->_secretKey = $secretKey;

        parent::__construct($authType);
    }

    /**
     * @return array
     */
    protected function _getValidationRules()
    {
        return array(
            WMApiRequestValidator::TYPE_REQUIRED => array('signerWmid', 'payeePurse', 'paymentNumber'),
            WMApiRequestValidator::TYPE_RANGE => array(
                self::PAYMENT_NUMBER_TYPE_DEFAULT,
                self::PAYMENT_NUMBER_TYPE_ORDER,
                self::PAYMENT_NUMBER_TYPE_INVOICE,
                self::PAYMENT_NUMBER_TYPE_TRANSACTION,
            ),
        );
    }

    /**
     * @return string
     */
    public function getXml()
    {
        $xml = '<merchant.request>';
        $xml .= self::_xmlElement('wmid', $this->_signerWmid);
        $xml .= self::_xmlElement('lmi_payee_purse', $this->_payeePurse);
        $xml .= self::_xmlElement('lmi_payment_no', $this->_paymentNumber);
        $xml .= self::_xmlElement('lmi_payment_no_type', $this->_paymentNumberType);
        $xml .= self::_xmlElement('sign', $this->_sign);
        $xml .= self::_xmlElement('md5', $this->_md5);

        if ($this->_authType === self::AUTH_SECRET_KEY) {
            $xml .= self::_xmlElement('secret_key', $this->_secretKey);
        }

        $xml .= '</merchant.request>';

        return $xml;
    }

    /**
     * @return string
     */
    public function getResponseClassName()
    {
        return 'WMX18Response';
    }

    /**
     * @param WMRequestSigner $requestSigner
     */
    public function sign(WMRequestSigner $requestSigner)
    {
        if ($this->_authType === self::AUTH_CLASSIC) {
            $this->_sign = $requestSigner->sign($this->_signerWmid . $this->_payeePurse . $this->_paymentNumber);
        } elseif ($this->_authType === self::AUTH_MD5) {
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
}
