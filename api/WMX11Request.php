<?php

/**
 * Class WMX11Request
 *
 * @link https://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X11
 */
class WMX11Request extends WMApiRequest
{
    const DICT_SHOW = 1;
    const DICT_NOT_SHOW = 0;

    const INFO_SHOW = 1;
    const INFO_NOT_SHOW = 0;

    const MODE_CHECK = 1;
    const MODE_NOT_CHECK = 0;

    /**@var string */
    protected $_authType;

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
        $this->_authType = $authType;
        $this->_paramDict = self::DICT_SHOW;
        $this->_paramInfo = self::INFO_SHOW;
        $this->_paramMode = self::MODE_CHECK;
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
            WMApiRequestValidator::TYPE_RIGHT_VALUE => array(
                'paramDict' => array(self::DICT_SHOW, self::DICT_NOT_SHOW),
                'paramInfo' => array(self::INFO_SHOW, self::INFO_NOT_SHOW),
                'paramMode' => array(self::MODE_CHECK, self::MODE_NOT_CHECK),
            ),
        );
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return 'https://passport.webmoney.ru/asp/XMLGetWMPassport.asp';
    }

    /**
     * @return string
     */
    public function getXml()
    {
        $this->_xml = '<request>';
        $this->_addElementToXml('wmid', $this->_signerWmid);
        $this->_addElementToXml('passportwmid', $this->_passportWmid);
        $this->_addElementToXml('sign', $this->_sign);
        if (!empty($this->_paramDict) || !empty($this->_paramInfo) || !empty($this->_paramMode)) {
            $this->_xml .= '<params>';
            $this->_addElementToXml('dict', $this->_paramDict);
            $this->_addElementToXml('info', $this->_paramInfo);
            $this->_addElementToXml('mode', $this->_paramMode);
            $this->_xml .= '</params>';
        }
        $this->_xml .= '</request>';

        return $this->_xml;
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
        if ($this->_authType == self::AUTH_CLASSIC) {
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

    /**
     * @return array
     */
    public function toArray()
    {
        return array(
            'authType' => $this->_authType,
            'signerWmid' => $this->_signerWmid,
            'passportWmid' => $this->_passportWmid,
            'paramDict' => $this->_paramDict,
            'paramInfo' => $this->_paramInfo,
            'paramMode' => $this->_paramMode,
        );
    }
}
