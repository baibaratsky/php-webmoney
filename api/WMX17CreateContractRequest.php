<?php

/**
 * Class WMX17CreateContractRequest
 *
 * @link http://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X17
 */
class WMX17CreateContractRequest extends WMXApiRequest
{
    const CONTRACT_TYPE_OPEN_ACCESS = 1;
    const CONTRACT_TYPE_RESTRICTED_ACCESS = 1;

    /** @var string sign_wmid */
    protected $_signerWmid;

    /** @var string name */
    protected $_contractName;

    /** @var int ctype */
    protected $_contractType;

    /** @var string text */
    protected $_contractText;

    /** @var string sign */
    protected $_sign;

    /** @var array accesslist\wmid */
    protected $_accessListWmids;

    public function __construct($authType = self::AUTH_CLASSIC)
    {
        if ($authType !== self::AUTH_CLASSIC && $authType !== self::AUTH_LIGHT) {
            throw new WMException('This interface doesn\'t support the authentication type given.');
        }

        $this->_url = 'https://arbitrage.webmoney.ru/xml/X17_CreateContract.aspx';

        parent::__construct($authType);
    }

    /**
     * @return array
     */
    protected function _getValidationRules()
    {
        return array(
            WMApiRequestValidator::TYPE_REQUIRED => array('contractName', 'contractType', 'contractText', 'accessListWmids'),
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
        $xml = '<contract.request>';
        $xml .= self::_xmlElement('sign_wmid', $this->_signerWmid);
        $xml .= self::_xmlElement('name', $this->_contractName);
        $xml .= self::_xmlElement('ctype', $this->_contractType);
        $xml .= self::_xmlElement('text', $this->_contractText);
        $xml .= self::_xmlElement('sign', $this->_sign);
        $xml .= '<accesslist>';

        foreach ($this->_accessListWmids as $wmid) {
            $xml .= self::_xmlElement('wmid', $wmid);
        }

        $xml .= '</accesslist>';
        $xml .= '</contract.request>';

        return $xml;
    }

    /**
     * @return string
     */
    public function getResponseClassName()
    {
        return 'WMX17CreateResponse';
    }

    /**
     * @param WMRequestSigner $requestSigner
     *
     * @return void
     */
    public function sign(WMRequestSigner $requestSigner)
    {
        if ($this->_authType === self::AUTH_CLASSIC) {
            $this->_sign = $requestSigner->sign($this->_signerWmid . mb_strlen($this->_contractName) . $this->_contractType);
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
     * @return string
     */
    public function getContractName()
    {
        return $this->_contractName;
    }

    /**
     * @param string $contractName
     */
    public function setContractName($contractName)
    {
        $this->_contractName = $contractName;
    }

    /**
     * @return int
     */
    public function getContractType()
    {
        return $this->_contractType;
    }

    /**
     * @param int $contractType
     */
    public function setContractType($contractType)
    {
        $this->_contractType = $contractType;
    }

    /**
     * @return string
     */
    public function getContractText()
    {
        return $this->_contractText;
    }

    /**
     * @param string $contractText
     */
    public function setContractText($contractText)
    {
        $this->_contractText = $contractText;
    }

    /**
     * @return array
     */
    public function getAccessListWmids()
    {
        return $this->_accessListWmids;
    }

    /**
     * @param array $accessListWmids
     */
    public function setAccessListWmids(array $accessListWmids)
    {
        $this->_accessListWmids = $accessListWmids;
    }
}
