<?php

/**
 * Class WMX9Request
 *
 * @link https://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X9
 */
class WMX9Request extends WMXApiRequest
{
    /** @var string wmid */
    protected $_signerWmid;

    /** @var array getpurses */
    protected $_requestedWmid;

    public function __construct($authType = self::AUTH_CLASSIC)
    {
        if ($authType === self::AUTH_CLASSIC) {
            $this->_url = 'https://w3s.webmoney.ru/asp/XMLPurses.asp';
        } elseif ($authType === self::AUTH_LIGHT) {
            $this->_url = 'https://w3s.wmtransfer.com/asp/XMLPursesCert.asp';
        } else {
            throw new WMException('This interface doesn\'t support the authentication type given.');
        }

        $this->_authType = $authType;
    }

    /**
     * @return array
     */
    protected function _getValidationRules()
    {
        return array(
            WMApiRequestValidator::TYPE_REQUIRED => array('requestedWmid'),
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
        $xml = '<w3s.response>';
        $xml .= self::_xmlElement('reqn', $this->_requestNumber);
        $xml .= self::_xmlElement('wmid', $this->_signerWmid);
        $xml .= self::_xmlElement('sign', $this->_signature);
        $xml .= '<getpurses>';
        $xml .= self::_xmlElement('wmid', $this->_requestedWmid);
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
    public function sign(WMRequestSigner $requestSigner = null)
    {
        if ($this->_authType === self::AUTH_CLASSIC) {
            $this->_signature = $requestSigner->sign($this->_requestedWmid . $this->_requestNumber);
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
    public function getRequestedWmid()
    {
        return $this->_requestedWmid;
    }

    /**
     * @param string $requestedWmid
     */
    public function setRequestedWmid($requestedWmid)
    {
        $this->_requestedWmid = $requestedWmid;
    }
}
