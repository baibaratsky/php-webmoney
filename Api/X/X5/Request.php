<?php

namespace baibaratsky\WebMoney\Api\X\X5;

use baibaratsky\WebMoney\Api\X;
use baibaratsky\WebMoney\Signer;
use baibaratsky\WebMoney\Request\RequestValidator;
use baibaratsky\WebMoney\Exception\ApiException;

/**
 * Class Request
 *
 * @link https://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X5
 */
class Request extends X\Request
{
    /** @var string wmid */
    protected $signerWmid;

    /** @var string finishprotect\wmtranid */
    protected $wmtranid;

    /** @var  string finishprotect\pcode */
    protected $pcode;

    public function __construct($authType = self::AUTH_CLASSIC)
    {
        if ($authType === self::AUTH_CLASSIC) {
            $this->url = 'https://w3s.webmoney.ru/asp/XMLFinishProtect.asp';
        } else {
            throw new ApiException('This interface doesn\'t support the authentication type given.');
        }

        parent::__construct($authType);
    }

    /**
     * @return string
     */
    public function getResponseClassName()
    {
        return Response::className();
    }

    /**
     * @param Signer $requestSigner
     *
     */
    public function sign(Signer $requestSigner = null)
    {
        if ($this->authType === self::AUTH_CLASSIC) {
            $this->signature = $requestSigner->sign($this->wmtranid . $this->pcode . $this->requestNumber);
        }
    }

    /**
     * @return array
     */
    protected function getValidationRules()
    {
        return array(
            RequestValidator::TYPE_REQUIRED => array('wmtranid', 'pcode'),
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
        $xml .= self::xmlElement('reqn', $this->requestNumber);
        $xml .= self::xmlElement('wmid', $this->signerWmid);
        $xml .= self::xmlElement('sign', $this->signature);
        $xml .= '<finishprotect>';
        $xml .= self::xmlElement('wmtranid', $this->wmtranid);
        $xml .= self::xmlElement('pcode', $this->pcode);
        $xml .= '</finishprotect>';
        $xml .= '</w3s.request>';

        return $xml;
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
    public function getWmtranid()
    {
        return $this->wmtranid;
    }

    /**
     * @param string $wmtranid
     */
    public function setWmtranid($wmtranid)
    {
        $this->wmtranid = $wmtranid;
    }

    /**
     * @return string
     */
    public function getPcode()
    {
        return $this->pcode;
    }

    /**
     * @param string $pcode
     */
    public function setPcode($pcode)
    {
        $this->pcode = $pcode;
    }
}
