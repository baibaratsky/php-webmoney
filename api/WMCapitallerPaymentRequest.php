<?php

class WMXmlCapitallerPaymentRequest extends WMApiRequest
{
    /** @var int firm_id */
    protected $_firmId;

    /** @var string sender_wmid */
    protected $_signerWmid;

    /** @var string transn */
    protected $_transactionNumber;

    /** @var string from */
    protected $_senderPurse;

    /** @var string to */
    protected $_recipientPurse;

    /** @var float amount */
    protected $_amount;

    /** @var string purpose */
    protected $_description;

    /** @var int prot_period */
    protected $_protectionPeriod;

    /** @var string prot_code */
    protected $_protectionCode;

    /** @var bool onlyauth */
    protected $_askRecipientsPermission;

    /** @var string signstr */
    protected $_sign;

    public function __construct()
    {
        $this->_url = 'http://www.capitaller.ru/ws/DoPayment.asmx?WSDL';
    }

    /**
     * @return string
     */
    public function getResponseClassName()
    {
        return 'WMXmlCapitallerPaymentResponse';
    }

    /**
     * @param WMRequestSigner $requestSigner
     *
     * @return void
     */
    public function sign(WMRequestSigner $requestSigner)
    {
        $this->_sign = $requestSigner->sign($this->_transactionNumber . $this->_senderPurse . $this->_recipientPurse
            . $this->_amount . $this->_description);
    }
}
