<?php
namespace Baibaratsky\WebMoney\Api\X\X3;

use Baibaratsky\WebMoney\Api\X;
use Baibaratsky\WebMoney\Exception\ApiException;
use Baibaratsky\WebMoney\Request\RequestSigner;
use Baibaratsky\WebMoney\Request\RequestValidator;

/**
 * Class Request
 *
 * @link https://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X3
 */
class Request extends X\Request
{
    /** @var string wmid */
    protected $_signerWmid;

    /** @var string getoperations\purse */
    protected $_parameterPurse;

    /** @var int getoperations\wmtranid */
    protected $_parameterWmTransactionId;

    /** @var int getoperations\tranid */
    protected $_parameterTransactionId;

    /** @var int getoperations\wminvid */
    protected $_parameterWmInvoiceNumber;

    /** @var int getoperations\orderid */
    protected $_parameterExternalInvoiceId;

    /** @var \DateTime getoperations\datestart */
    protected $_parameterStartDate;

    /** @var \DateTime getoperations\datefinish */
    protected $_parameterEndDate;

    public function __construct($authType = self::AUTH_CLASSIC)
    {
        if ($authType === self::AUTH_CLASSIC) {
            $this->_url = 'https://w3s.webmoney.ru/asp/XMLOperations.asp';
        } elseif ($authType === self::AUTH_LIGHT) {
            $this->_url = 'https://w3s.wmtransfer.com/asp/XMLOperationsCert.asp';
        } else {
            throw new ApiException('This interface doesn\'t support the authentication type given.');
        }

        parent::__construct($authType);
    }

    /**
     * @return array
     */
    protected function _getValidationRules()
    {
        return array(
            RequestValidator::TYPE_REQUIRED => array('parameterPurse', 'parameterStartDate', 'parameterEndDate'),
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
        $xml .= self::_xmlElement('reqn', $this->_requestNumber);
        $xml .= self::_xmlElement('wmid', $this->_signerWmid);
        $xml .= self::_xmlElement('sign', $this->_signature);
        $xml .= '<getoperations>';
        $xml .= self::_xmlElement('purse', $this->_parameterPurse);
        $xml .= self::_xmlElement('wmtranid', $this->_parameterWmTransactionId);
        $xml .= self::_xmlElement('tranid', $this->_parameterTransactionId);
        $xml .= self::_xmlElement('wminvid', $this->_parameterWmInvoiceNumber);
        $xml .= self::_xmlElement('orderid', $this->_parameterExternalInvoiceId);
        $xml .= self::_xmlElement('datestart', $this->_parameterStartDate->format('Ymd H:i:s'));
        $xml .= self::_xmlElement('datefinish', $this->_parameterEndDate->format('Ymd H:i:s'));
        $xml .= '</getoperations>';
        $xml .= '</w3s.request>';

        return $xml;
    }

    /**
     * @return string
     */
    public function getResponseClassName()
    {
        return 'Baibaratsky\WebMoney\Api\X\X3\Response';
    }

    /**
     * @param RequestSigner $requestSigner
     *
     * @return void
     */
    public function sign(RequestSigner $requestSigner = null)
    {
        if ($this->_authType === self::AUTH_CLASSIC) {
            $this->_signature = $requestSigner->sign($this->_parameterPurse . $this->_requestNumber);
        }
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
     * @param string $parameterPurse
     */
    public function setParameterPurse($parameterPurse)
    {
        $this->_parameterPurse = $parameterPurse;
    }

    /**
     * @return string
     */
    public function getParameterPurse()
    {
        return $this->_parameterPurse;
    }

    /**
     * @param int $parameterWmTransactionId
     */
    public function setParameterWmTransactionId($parameterWmTransactionId)
    {
        $this->_parameterWmTransactionId = $parameterWmTransactionId;
    }

    /**
     * @return int
     */
    public function getParameterWmTransactionId()
    {
        return $this->_parameterWmTransactionId;
    }

    /**
     * @param int $parameterTransactionId
     */
    public function setParameterTransactionId($parameterTransactionId)
    {
        $this->_parameterTransactionId = $parameterTransactionId;
    }

    /**
     * @return int
     */
    public function getParameterTransactionId()
    {
        return $this->_parameterTransactionId;
    }

    /**
     * @param int $parameterExternalInvoiceId
     */
    public function setParameterExternalInvoiceId($parameterExternalInvoiceId)
    {
        $this->_parameterExternalInvoiceId = $parameterExternalInvoiceId;
    }

    /**
     * @return int
     */
    public function getParameterExternalInvoiceId()
    {
        return $this->_parameterExternalInvoiceId;
    }

    /**
     * @param int $parameterWmInvoiceNumber
     */
    public function setParameterWmInvoiceNumber($parameterWmInvoiceNumber)
    {
        $this->_parameterWmInvoiceNumber = $parameterWmInvoiceNumber;
    }

    /**
     * @return int
     */
    public function getParameterWmInvoiceNumber()
    {
        return $this->_parameterWmInvoiceNumber;
    }

    /**
     * @param \DateTime $parameterStartDate
     */
    public function setParameterStartDate($parameterStartDate)
    {
        $this->_parameterStartDate = $parameterStartDate;
    }

    /**
     * @return \DateTime
     */
    public function getParameterStartDate()
    {
        return $this->_parameterStartDate;
    }

    /**
     * @param \DateTime $parameterEndDate
     */
    public function setParameterEndDate($parameterEndDate)
    {
        $this->_parameterEndDate = $parameterEndDate;
    }

    /**
     * @return \DateTime
     */
    public function getParameterEndDate()
    {
        return $this->_parameterEndDate;
    }
}
