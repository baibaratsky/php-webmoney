<?php

/**
 * Class WMX17InformationRequest
 *
 * @link http://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X17
 */
class WMX17ContractInfoRequest extends WMXmlApiRequest
{
    const TYPE_ACCEPT_DATE = 'acceptdate';

    /** @var string wmid */
    protected $_signerWmid;

    /** @var int contractid */
    protected $_contractId;

    /** @var string mode */
    protected $_type;

    /** @var string sign */
    protected $_sign;

    public function __construct($authType = self::AUTH_CLASSIC)
    {
        if ($authType !== self::AUTH_CLASSIC && $authType !== self::AUTH_LIGHT) {
            throw new WMException('This interface doesn\'t support the authentication type given.');
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
            WMApiRequestValidator::TYPE_REQUIRED => array('contractId'),
            WMApiRequestValidator::TYPE_DEPEND_REQUIRED => array(
                'signerWmid' => array('authType' => array(self::AUTH_CLASSIC)),
            ),
            WMApiRequestValidator::TYPE_RANGE => array(
                'type' => array(self::TYPE_ACCEPT_DATE),
            ),
        );
    }

    /**
     * @return string
     */
    public function getXml()
    {
        $xml = '<contract.request>';
        $xml .= self::_xmlElement('wmid', $this->_signerWmid);
        $xml .= self::_xmlElement('contractid', $this->_contractId);
        $xml .= self::_xmlElement('mode', $this->_type);
        $xml .= self::_xmlElement('sign', $this->_sign);
        $xml .= '</contract.request>';

        return $xml;
    }

    /**
     * @return string
     */
    public function getResponseClassName()
    {
        return 'WMX17InformationResponse';
    }

    /**
     * @param WMRequestSigner $requestSigner
     *
     * @return void
     */
    public function sign(WMRequestSigner $requestSigner)
    {
        if ($this->_authType === self::AUTH_CLASSIC) {
            $this->_sign = $requestSigner->sign($this->_contractId . $this->_type);
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
