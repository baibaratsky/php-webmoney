<?php
namespace Baibaratsky\WebMoney\Api\Capitaller;

use Baibaratsky\WebMoney\Api\ApiRequest;
use Baibaratsky\WebMoney\Signer\RequestSigner;
use Baibaratsky\WebMoney\Validator\RequestValidator;

class PaymentRequest extends ApiRequest
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
    protected $_protectionPeriod = 0;

    /** @var string prot_code */
    protected $_protectionCode;

    /** @var bool onlyauth */
    protected $_askRecipientsPermission = false;

    public function __construct()
    {
        $this->_url = 'http://www.capitaller.ru/ws/DoPayment.asmx?WSDL';
    }

    /**
     * @return array
     */
    protected function _getValidationRules()
    {
        return array(
            RequestValidator::TYPE_REQUIRED => array('firmId', 'signerWmid', 'transactionNumber', 'senderPurse',
                'recipientPurse', 'amount', 'protectionPeriod', 'askRecipientsPermission'),
        );
    }

    /**
     * SOAP function name for SoapApiRequestPerformer
     * @return string
     */
    public function getFunctionName()
    {
        return 'SendWMOA';
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return array(
            'firm_id' => $this->_firmId,
            'sender_wmid' => $this->_signerWmid,
            'transn' => $this->_transactionNumber,
            'from' => $this->_senderPurse,
            'to' => $this->_recipientPurse,
            'amount' => $this->_amount,
            'purpose' => $this->_description,
            'prot_period' => $this->_protectionPeriod,
            'prot_code' => $this->_protectionCode,
            'onlyauth' => (int)$this->_askRecipientsPermission,
            'paymentid' => 0,
        );
    }

    /**
     * @return string
     */
    public function getResponseClassName()
    {
        return 'Baibaratsky\WebMoney\Api\MegaStock\PaymentResponse';
    }

    /**
     * @param RequestSigner $requestSigner
     *
     * @return void
     */
    public function sign(RequestSigner $requestSigner = null)
    {
        $this->_signature = $requestSigner->sign($this->_transactionNumber . $this->_senderPurse . $this->_recipientPurse
            . $this->_amount . $this->_description);
    }

    /**
     * @param int $firmId
     */
    public function setFirmId($firmId)
    {
        $this->_firmId = $firmId;
    }

    /**
     * @return int
     */
    public function getFirmId()
    {
        return $this->_firmId;
    }

    /**
     * @param string $signerWmid
     */
    public function setSignerWmid($signerWmid)
    {
        $this->_signerWmid = $signerWmid;
    }

    /**
     * @return string
     */
    public function getSignerWmid()
    {
        return $this->_signerWmid;
    }

    /**
     * @param string $transactionNumber
     */
    public function setTransactionNumber($transactionNumber)
    {
        $this->_transactionNumber = $transactionNumber;
    }

    /**
     * @return string
     */
    public function getTransactionNumber()
    {
        return $this->_transactionNumber;
    }

    /**
     * @param string $senderPurse
     */
    public function setSenderPurse($senderPurse)
    {
        $this->_senderPurse = $senderPurse;
    }

    /**
     * @return string
     */
    public function getSenderPurse()
    {
        return $this->_senderPurse;
    }

    /**
     * @param string $recipientPurse
     */
    public function setRecipientPurse($recipientPurse)
    {
        $this->_recipientPurse = $recipientPurse;
    }

    /**
     * @return string
     */
    public function getRecipientPurse()
    {
        return $this->_recipientPurse;
    }

    /**
     * @param float $amount
     */
    public function setAmount($amount)
    {
        $this->_amount = $amount;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->_amount;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->_description = $description;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->_description;
    }

    /**
     * @param int $protectionPeriod
     */
    public function setProtectionPeriod($protectionPeriod)
    {
        $this->_protectionPeriod = $protectionPeriod;
    }

    /**
     * @return int
     */
    public function getProtectionPeriod()
    {
        return $this->_protectionPeriod;
    }

    /**
     * @param string $protectionCode
     */
    public function setProtectionCode($protectionCode)
    {
        $this->_protectionCode = $protectionCode;
    }

    /**
     * @return string
     */
    public function getProtectionCode()
    {
        return $this->_protectionCode;
    }

    /**
     * @param bool $askRecipientsPermission
     */
    public function setAskRecipientsPermission($askRecipientsPermission)
    {
        $this->_askRecipientsPermission = $askRecipientsPermission;
    }

    /**
     * @return bool
     */
    public function getAskRecipientsPermission()
    {
        return $this->_askRecipientsPermission;
    }
}
