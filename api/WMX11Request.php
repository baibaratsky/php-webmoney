<?php

/**
 * Class WMX11Request
 *
 * @link https://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X11
 */
class WMX11Request extends WMXApiRequest
{
    const DICT_SHOW = 1;
    const DICT_NOT_SHOW = 0;

    const INFO_SHOW = 1;
    const INFO_NOT_SHOW = 0;

    const MODE_CHECK = 1;
    const MODE_NOT_CHECK = 0;

    /** @var string wmid */
    protected $_signerWmid;

    /** @var string passportwmid */
    protected $_passportWmid;

    /** @var string sign */
    protected $_sign;

    /** @var int params/dict */
    protected $_paramDict;

    /** @var int params/info */
    protected $_paramInfo;

    /** @var int params/mode */
    protected $_paramMode;

    public function __construct($authType = self::AUTH_CLASSIC)
    {
        if ($authType !== self::AUTH_CLASSIC && $authType !== self::AUTH_LIGHT) {
            throw new WMException('This interface doesn\'t support the authentication type given.');
        }

        $this->_url = 'https://passport.webmoney.ru/asp/XMLGetWMPassport.asp';

        $this->_paramDict = self::DICT_SHOW;
        $this->_paramInfo = self::INFO_SHOW;
        $this->_paramMode = self::MODE_CHECK;

        parent::__construct($authType);
    }

    /**
     * @return array
     */
    public function _getValidationRules()
    {
        return array(
            WMApiRequestValidator::TYPE_REQUIRED => array('passportWmid', 'paramDict', 'paramInfo', 'paramMode'),
            WMApiRequestValidator::TYPE_DEPEND_REQUIRED => array(
                'signerWmid' => array('authType' => array(self::AUTH_CLASSIC)),
            ),
            WMApiRequestValidator::TYPE_RANGE => array(
                'paramDict' => array(self::DICT_SHOW, self::DICT_NOT_SHOW),
                'paramInfo' => array(self::INFO_SHOW, self::INFO_NOT_SHOW),
                'paramMode' => array(self::MODE_CHECK, self::MODE_NOT_CHECK),
            ),
        );
    }

    /**
     * @return string
     */
    public function getXml()
    {
        $xml = '<request>';
        $xml .= self::_xmlElement('wmid', $this->_signerWmid);
        $xml .= self::_xmlElement('passportwmid', $this->_passportWmid);
        $xml .= self::_xmlElement('sign', $this->_sign);
        if (!empty($this->_paramDict) || !empty($this->_paramInfo) || !empty($this->_paramMode)) {
            $xml .= '<params>';
            $xml .= self::_xmlElement('dict', $this->_paramDict);
            $xml .= self::_xmlElement('info', $this->_paramInfo);
            $xml .= self::_xmlElement('mode', $this->_paramMode);
            $xml .= '</params>';
        }
        $xml .= '</request>';

        return $xml;
    }

    /**
     * @return string
     */
    public function getResponseClassName()
    {
        return 'WMX11Response';
    }

    /**
     * @param WMRequestSigner $requestSigner
     *
     * @return void
     */
    public function sign(WMRequestSigner $requestSigner)
    {
        if ($this->_authType === self::AUTH_CLASSIC) {
            $this->_sign = $requestSigner->sign($this->_signerWmid . $this->_passportWmid);
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
    public function getPassportWmid()
    {
        return $this->_passportWmid;
    }

    /**
     * @param string $passportWmid
     */
    public function setPassportWmid($passportWmid)
    {
        $this->_passportWmid = $passportWmid;
    }

    /**
     * @return int
     */
    public function getParamDict()
    {
        return $this->_paramDict;
    }

    /**
     * @param int $paramDict
     */
    public function setParamDict($paramDict)
    {
        $this->_paramDict = $paramDict;
    }

    /**
     * @return int
     */
    public function getParamInfo()
    {
        return $this->_paramInfo;
    }

    /**
     * @param int $paramInfo
     */
    public function setParamInfo($paramInfo)
    {
        $this->_paramInfo = $paramInfo;
    }

    /**
     * @return int
     */
    public function getParamMode()
    {
        return $this->_paramMode;
    }

    /**
     * @param int $paramMode
     */
    public function setParamMode($paramMode)
    {
        $this->_paramMode = $paramMode;
    }
}
