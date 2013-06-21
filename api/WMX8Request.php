<?php

/**
 * Class WMX8Request
 *
 * @link https://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X8
 */
class WMX8Request extends WMApiRequest
{
    /** @var string wmid */
    protected $_signerWmid;

    /** @var string sign */
    protected $_sign;

    /** @var string testwmpurse/wmid */
    protected $_wmid;

    /** @var string testwmpurse/purse */
    protected $_purse;

    protected function _getValidationRules()
    {
        return array(
            WMApiRequestValidator::TYPE_REQUIRED => array('requestNumber', 'signerWmid'),
        );
    }

    public function getUrl()
    {
        if ($this->_authType == self::AUTH_CLASSIC) {
            return 'https://w3s.webmoney.ru/asp/XMLFindWMPurseNew.asp';
        }

        return 'https://w3s.wmtransfer.com/asp/XMLFindWMPurseCertNew.asp';
    }

    public function getXml()
    {
        $xml = '<w3s.request>';
        $xml .= self::_xmlElement('reqn', $this->_requestNumber);
        $xml .= self::_xmlElement('wmid', $this->_signerWmid);
        $xml .= self::_xmlElement('sign', $this->_sign);
        $xml .= '<testwmpurse>';
        $xml .= self::_xmlElement('wmid', $this->_wmid);
        $xml .= self::_xmlElement('purse', $this->_purse);
        $xml .= '</testwmpurse>';
        $xml .= '</w3s.request>';

        return $xml;
    }

    public function getResponseClassName()
    {
        return 'WMX8Response';
    }

    public function sign(WMRequestSigner $requestSigner)
    {
        if ($this->_authType == self::AUTH_CLASSIC) {
            $this->_sign = $requestSigner->sign($this->_wmid . $this->_purse);
        }
    }

    /**
     * @param string $testWmid
     */
    public function setWmid($testWmid)
    {
        $this->_wmid = $testWmid;
    }

    /**
     * @return string
     */
    public function getWmid()
    {
        return $this->_wmid;
    }

    /**
     * @param string $testPurse
     */
    public function setPurse($testPurse)
    {
        $this->_purse = $testPurse;
    }

    /**
     * @return string
     */
    public function getPurse()
    {
        return $this->_purse;
    }

    public function toArray()
    {
        return array(
            'requestNumber' => $this->_requestNumber,
            'signerWmid' => $this->_signerWmid,
            'wmid' => $this->_wmid,
            'purse' => $this->_purse,
        );
    }
}
