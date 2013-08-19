<?php

/**
 * Class WMX9Request
 *
 * @link https://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X9
 */
class WMX9Request extends WMXmlApiRequest
{
    /** @var string wmid */
    protected $_signerWmid;

    /** @var string sign */
    protected $_sign;

    /** @var array getpurses */
    protected $_requestedWmids;

    public function __construct($authType = self::AUTH_CLASSIC)
    {
        if ($authType === self::AUTH_CLASSIC) {
            $this->_url = 'https://w3s.webmoney.ru/asp/XMLPurses.asp';
        } elseif ($authType === self::AUTH_LIGHT) {
            $this->_url = 'https://w3s.wmtransfer.com/asp/XMLPursesCert.asp';
        } else {
            throw new WMException('This interface doesn\'t support the authentication type given.');
        }
    }

    /**
     * @return array
     */
    protected function _getValidationRules()
    {
        return array(
            WMApiRequestValidator::TYPE_DEPEND_REQUIRED => array(
                'signerWmid' => array('authType' => array(self::AUTH_CLASSIC)),
            ),
            WMApiRequestValidator::TYPE_REQUIRED => array('purses'),
        );
    }

    /**
     * @return string
     */
    public function getXml()
    {
        $xml = '<w3s.response>';
        $xml .= self::_xmlElement('reqn', $this->_requestNumber);
        $xml .= self::_xmlElement('wmid', $this->_signerWmid);
        $xml .= self::_xmlElement('sign', $this->_sign);
        $xml .= '<getpurses>';
        foreach ($this->_requestedWmids as $wmid) {
            $xml .= self::_xmlElement('wmid', $wmid);
        }
        $xml .= '</getpurses>';
        $xml .= '</w3s.response>';

        return $xml;
    }

    /**
     * @return string
     */
    public function getResponseClassName()
    {
        return 'WMX9Response';
    }

    /**
     * @param WMRequestSigner $requestSigner
     *
     * @return void
     */
    public function sign(WMRequestSigner $requestSigner)
    {
        if ($this->_authType === self::AUTH_CLASSIC) {
            $this->_sign = $requestSigner->sign($this->_signerWmid . $this->_requestNumber);
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
     * @return array
     */
    public function getRequestedWmids()
    {
        return $this->_requestedWmids;
    }

    /**
     * @param array $requestedWmids
     */
    public function setRequestedWmids($requestedWmids)
    {
        $this->_requestedWmids = $requestedWmids;
    }
}
