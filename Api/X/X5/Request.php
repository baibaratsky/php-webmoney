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
    protected $transactionId;

    /** @var  string finishprotect\pcode */
    protected $protectionCode;

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
            $this->signature = $requestSigner->sign($this->transactionId . $this->protectionCode . $this->requestNumber);
        }
    }

    /**
     * @return array
     */
    protected function getValidationRules()
    {
        return array(
                RequestValidator::TYPE_REQUIRED => array('transactionId', 'protectionCode'),
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
        $xml .= self::xmlElement('wmtranid', $this->transactionId);
        $xml .= self::xmlElement('pcode', $this->protectionCode);
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
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * @param string $transactionId
     */
    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;
    }

    /**
     * @return string
     */
    public function getProtectionCode()
    {
        return $this->protectionCode;
    }

    /**
     * @param string $protectionCode
     */
    public function setProtectionCode($protectionCode)
    {
        $this->protectionCode = $protectionCode;
    }
}
