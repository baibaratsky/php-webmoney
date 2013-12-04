<?php
namespace Baibaratsky\WebMoney\Api\Xml\X17\CreateContract;

use Baibaratsky\WebMoney\Api\Xml\Request as ApiXmlRequest;
use Baibaratsky\WebMoney\Exception\ApiException;
use Baibaratsky\WebMoney\Signer\RequestSigner;
use Baibaratsky\WebMoney\Validator\RequestValidator;

/**
 * Class Request
 *
 * @link http://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X17
 */
class Request extends ApiXmlRequest
{
    const TYPE_ACCEPT_DATE = 'acceptdate';

    /** @var string wmid */
    protected $_signerWmid;

    /** @var int contractid */
    protected $_contractId;

    /** @var string mode */
    protected $_type;

    public function __construct($authType = self::AUTH_CLASSIC)
    {
        if ($authType !== self::AUTH_CLASSIC && $authType !== self::AUTH_LIGHT) {
            throw new ApiException('This interface doesn\'t support the authentication type given.');
        }

        $this->_url = 'https://arbitrage.webmoney.ru/xml/X17_GetContractInfo.aspx';
        $this->_type = self::TYPE_ACCEPT_DATE;

        parent::__construct($authType);
    }

    /**
     * @return array
     */
    protected function _getValidationRules()
    {
        return array(
            RequestValidator::TYPE_REQUIRED => array('contractId'),
            RequestValidator::TYPE_DEPEND_REQUIRED => array(
                'signerWmid' => array('authType' => array(self::AUTH_CLASSIC)),
            ),
            RequestValidator::TYPE_RANGE => array(
                'type' => array(self::TYPE_ACCEPT_DATE),
            ),
        );
    }

    /**
     * @return string
     */
    public function getData()
    {
        $xml = '<contract.request>';
        $xml .= self::_xmlElement('wmid', $this->_signerWmid);
        $xml .= self::_xmlElement('contractid', $this->_contractId);
        $xml .= self::_xmlElement('mode', $this->_type);
        $xml .= self::_xmlElement('sign', $this->_signature);
        $xml .= '</contract.request>';

        return $xml;
    }

    /**
     * @return string
     */
    public function getResponseClassName()
    {
        return 'Baibaratsky\WebMoney\Api\Xml\X17\ContractInfo\Response';
    }

    /**
     * @param RequestSigner $requestSigner
     *
     * @return void
     */
    public function sign(RequestSigner $requestSigner = null)
    {
        if ($this->_authType === self::AUTH_CLASSIC) {
            $this->_signature = $requestSigner->sign($this->_contractId . $this->_type);
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
    public function getContractId()
    {
        return $this->_contractId;
    }

    /**
     * @param int $contractId
     */
    public function setContractId($contractId)
    {
        $this->_contractId = $contractId;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->_type = $type;
    }
}
