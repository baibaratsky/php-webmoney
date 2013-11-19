<?php

/**
 * Class WMX2Request
 *
 * @link http://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X2
 */
class WMX2Request extends WMXApiRequest
{
    /** @var string wmid */
    protected $_signerWmid;

    /** @var int trans/tranid */
    protected $_transactionId;

    /** @var string trans/pursesrc */
    protected $_transactionSenderPurse;

    /** @var string trans/pursedest */
    protected $_transactionRecipientPurse;

    /** @var float trans/amount */
    protected $_transactionAmount;

    /** @var int trans/period */
    protected $_transactionProtectionPeriod;

    /** @var string trans/pcode */
    protected $_transactionProtectionCode;

    /** @var string trans/desc */
    protected $_transactionDescription;

    /** @var int trans/wminvid */
    protected $_transactionWmInvoiceNumber;

    /** @var boolean trans/onlyauth */
    protected $_transactionOnlyAuth;

    /**
     * @param string $authType
     *
     * @throws WMException
     */
    public function __construct($authType = self::AUTH_CLASSIC)
    {
        if ($authType === self::AUTH_CLASSIC) {
            $this->_url = 'https://w3s.webmoney.ru/asp/XMLTrans.asp';
        } elseif ($authType === self::AUTH_LIGHT) {
            $this->_url = 'https://w3s.wmtransfer.com/asp/XMLTransCert.asp';
        } else {
            throw new WMException('This interface doesn\'t support the authentication type given.');
        }

        parent::__construct($authType);
    }

    /**
     * @return array
     */
    protected function _getValidationRules()
    {
        return array(
            WMApiRequestValidator::TYPE_REQUIRED => array(
                'transactionId', 'transactionSenderPurse', 'transactionRecipientPurse', 'transactionAmount',
                'transactionProtectionPeriod', 'transactionProtectionCode', 'transactionDescription',
                'transactionWmInvoiceNumber', 'transactionOnlyAuth', 'transactionOnlyAuth',
            ),
            WMApiRequestValidator::TYPE_DEPEND_REQUIRED => array(
                'signerWmid' => array('authType' => array(self::AUTH_CLASSIC)),
            ),
        );
    }

    /**
     * @return string
     */
    public function getXml()
    {
        $xml = '<w3s.request>';
        $xml .= self::_xmlElement('reqn', $this->_requestNumber);
        $xml .= self::_xmlElement('wmid', $this->_signerWmid);
        $xml .= self::_xmlElement('sign', $this->_signature);
        $xml .= '<trans>';
        $xml .= self::_xmlElement('tranid', $this->_transactionId);
        $xml .= self::_xmlElement('pursesrc', $this->_transactionSenderPurse);
        $xml .= self::_xmlElement('pursedest', $this->_transactionRecipientPurse);
        $xml .= self::_xmlElement('amount', $this->_transactionAmount);
        $xml .= self::_xmlElement('period', $this->_transactionProtectionPeriod);
        $xml .= self::_xmlElement('pcode', $this->_transactionProtectionCode);
        $xml .= self::_xmlElement('desc', $this->_transactionDescription);
        $xml .= self::_xmlElement('wminvid', $this->_transactionWmInvoiceNumber);
        $xml .= self::_xmlElement('onlyauth', $this->_transactionOnlyAuth);
        $xml .= '</trans>';
        $xml .= '</w3s.request>';

        return $xml;
    }

    /**
     * @return string
     */
    public function getResponseClassName()
    {
        return 'WMX2Response';
    }

    /**
     * @param WMRequestSigner $requestSigner
     */
    public function sign(WMRequestSigner $requestSigner = null)
    {
        if ($this->_authType === self::AUTH_CLASSIC) {
            $this->_signature = $requestSigner->sign($this->_requestNumber . $this->_transactionId .
                                                $this->_transactionSenderPurse . $this->_transactionRecipientPurse .
                                                $this->_transactionAmount . $this->_transactionProtectionPeriod .
                                                $this->_transactionProtectionCode . $this->_transactionDescription .
                                                $this->_transactionWmInvoiceNumber);
        }
    }

    /**
     * @return string
     */
    public function getSignerWmid()
    {
        return $this->_signerWmid;
    }

    /**
     * @param string $signerWmid
     */
    public function setSignerWmid($signerWmid)
    {
        $this->_signerWmid = $signerWmid;
    }

    /**
     * @return int
     */
    public function getTransactionId()
    {
        return $this->_transactionId;
    }

    /**
     * @param int $transactionId
     */
    public function setTransactionId($transactionId)
    {
        $this->_transactionId = $transactionId;
    }

    /**
     * @return string
     */
    public function getTransactionSenderPurse()
    {
        return $this->_transactionSenderPurse;
    }

    /**
     * @param string $transactionSenderPurse
     */
    public function setTransactionSenderPurse($transactionSenderPurse)
    {
        $this->_transactionSenderPurse = $transactionSenderPurse;
    }

    /**
     * @return string
     */
    public function getTransactionRecipientPurse()
    {
        return $this->_transactionRecipientPurse;
    }

    /**
     * @param string $transactionRecipientPurse
     */
    public function setTransactionRecipientPurse($transactionRecipientPurse)
    {
        $this->_transactionRecipientPurse = $transactionRecipientPurse;
    }

    /**
     * @return float
     */
    public function getTransactionAmount()
    {
        return $this->_transactionAmount;
    }

    /**
     * @param float $transactionAmount
     */
    public function setTransactionAmount($transactionAmount)
    {
        $this->_transactionAmount = $transactionAmount;
    }

    /**
     * @return int
     */
    public function getTransactionProtectionPeriod()
    {
        return $this->_transactionProtectionPeriod;
    }

    /**
     * @param int $transactionProtectionPeriod
     */
    public function setTransactionProtectionPeriod($transactionProtectionPeriod)
    {
        $this->_transactionProtectionPeriod = $transactionProtectionPeriod;
    }

    /**
     * @return string
     */
    public function getTransactionProtectionCode()
    {
        return $this->_transactionProtectionCode;
    }

    /**
     * @param string $transactionProtectionCode
     */
    public function setTransactionProtectionCode($transactionProtectionCode)
    {
        $this->_transactionProtectionCode = $transactionProtectionCode;
    }

    /**
     * @return string
     */
    public function getTransactionDescription()
    {
        return $this->_transactionDescription;
    }

    /**
     * @param string $transactionDescription
     */
    public function setTransactionDescription($transactionDescription)
    {
        $this->_transactionDescription = $transactionDescription;
    }

    /**
     * @return int
     */
    public function getTransactionInvoiceNumber()
    {
        return $this->_transactionWmInvoiceNumber;
    }

    /**
     * @param int $transactionWmInvoiceNumber
     */
    public function setTransactionInvoiceNumber($transactionWmInvoiceNumber)
    {
        $this->_transactionWmInvoiceNumber = $transactionWmInvoiceNumber;
    }

    /**
     * @return boolean
     */
    public function getTransactionOnlyAuth()
    {
        return $this->_transactionOnlyAuth;
    }

    /**
     * @param boolean $transactionOnlyAuth
     */
    public function setTransactionOnlyAuth($transactionOnlyAuth)
    {
        $this->_transactionOnlyAuth = $transactionOnlyAuth;
    }
}
