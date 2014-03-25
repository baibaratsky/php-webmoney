<?php

namespace baibaratsky\WebMoney\Api\X\X11;

use baibaratsky\WebMoney\Api\X;
use baibaratsky\WebMoney\Exception\ApiException;
use baibaratsky\WebMoney\Request\RequestSigner;
use baibaratsky\WebMoney\Request\RequestValidator;

/**
 * Class Request
 *
 * @link https://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X11
 */
class Request extends X\Request
{
    const DICT_SHOW = 1;
    const DICT_NOT_SHOW = 0;

    const INFO_SHOW = 1;
    const INFO_NOT_SHOW = 0;

    const MODE_CHECK = 1;
    const MODE_NOT_CHECK = 0;

    /** @var string wmid */
    protected $signerWmid;

    /** @var string passportwmid */
    protected $passportWmid;

    /** @var int params/dict */
    protected $paramDict;

    /** @var int params/info */
    protected $paramInfo;

    /** @var int params/mode */
    protected $paramMode;

    public function __construct($authType = self::AUTH_CLASSIC)
    {
        if ($authType !== self::AUTH_CLASSIC && $authType !== self::AUTH_LIGHT) {
            throw new ApiException('This interface doesn\'t support the authentication type given.');
        }

        $this->url = 'https://passport.webmoney.ru/asp/XMLGetWMPassport.asp';

        $this->paramDict = self::DICT_SHOW;
        $this->paramInfo = self::INFO_SHOW;
        $this->paramMode = self::MODE_CHECK;

        parent::__construct($authType);
    }

    /**
     * @return array
     */
    public function getValidationRules()
    {
        return array(
            RequestValidator::TYPE_REQUIRED => array('passportWmid', 'paramDict', 'paramInfo', 'paramMode'),
            RequestValidator::TYPE_DEPEND_REQUIRED => array(
                'signerWmid' => array('authType' => array(self::AUTH_CLASSIC)),
            ),
            RequestValidator::TYPE_RANGE => array(
                'paramDict' => array(self::DICT_SHOW, self::DICT_NOT_SHOW),
                'paramInfo' => array(self::INFO_SHOW, self::INFO_NOT_SHOW),
                'paramMode' => array(self::MODE_CHECK, self::MODE_NOT_CHECK),
            ),
        );
    }

    /**
     * @return string
     */
    public function getData()
    {
        $xml = '<request>';
        $xml .= self::xmlElement('wmid', $this->signerWmid);
        $xml .= self::xmlElement('passportwmid', $this->passportWmid);
        $xml .= self::xmlElement('sign', $this->signature);
        if (!empty($this->paramDict) || !empty($this->paramInfo) || !empty($this->paramMode)) {
            $xml .= '<params>';
            $xml .= self::xmlElement('dict', $this->paramDict);
            $xml .= self::xmlElement('info', $this->paramInfo);
            $xml .= self::xmlElement('mode', $this->paramMode);
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
        return Response::className();
    }

    /**
     * @param RequestSigner $requestSigner
     *
     * @return void
     */
    public function sign(RequestSigner $requestSigner = null)
    {
        if ($this->authType === self::AUTH_CLASSIC) {
            $this->signature = $requestSigner->sign($this->signerWmid . $this->passportWmid);
        }
    }

    /**
     * @return string
     */
    public function getSignerWmid()
    {
        return $this->signerWmid;
    }

    /**
     * @param string $signerWmid
     */
    public function setSignerWmid($signerWmid)
    {
        $this->signerWmid = $signerWmid;
    }

    /**
     * @return string
     */
    public function getPassportWmid()
    {
        return $this->passportWmid;
    }

    /**
     * @param string $passportWmid
     */
    public function setPassportWmid($passportWmid)
    {
        $this->passportWmid = $passportWmid;
    }

    /**
     * @return int
     */
    public function getParamDict()
    {
        return $this->paramDict;
    }

    /**
     * @param int $paramDict
     */
    public function setParamDict($paramDict)
    {
        $this->paramDict = $paramDict;
    }

    /**
     * @return int
     */
    public function getParamInfo()
    {
        return $this->paramInfo;
    }

    /**
     * @param int $paramInfo
     */
    public function setParamInfo($paramInfo)
    {
        $this->paramInfo = $paramInfo;
    }

    /**
     * @return int
     */
    public function getParamMode()
    {
        return $this->paramMode;
    }

    /**
     * @param int $paramMode
     */
    public function setParamMode($paramMode)
    {
        $this->paramMode = $paramMode;
    }
}
