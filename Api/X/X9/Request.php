<?php

namespace baibaratsky\WebMoney\Api\X\X9;

use baibaratsky\WebMoney\Api\X;
use baibaratsky\WebMoney\Exception\ApiException;
use baibaratsky\WebMoney\Request\RequestSigner;
use baibaratsky\WebMoney\Request\RequestValidator;

/**
 * Class Request
 *
 * @link https://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X9
 */
class Request extends X\Request
{
    /** @var string wmid */
    protected $signerWmid;

    /** @var string getpurses/wmid */
    protected $requestedWmid;

    public function __construct($authType = self::AUTH_CLASSIC)
    {
        if ($authType === self::AUTH_CLASSIC) {
            $this->url = 'https://w3s.webmoney.ru/asp/XMLPurses.asp';
        } elseif ($authType === self::AUTH_LIGHT) {
            $this->url = 'https://w3s.wmtransfer.com/asp/XMLPursesCert.asp';
        } else {
            throw new ApiException('This interface doesn\'t support the authentication type given.');
        }

        parent::__construct($authType);
    }

    /**
     * @return array
     */
    protected function getValidationRules()
    {
        return array(
            RequestValidator::TYPE_REQUIRED => array('requestedWmid'),
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
        $xml .= '<getpurses>';
        $xml .= self::xmlElement('wmid', $this->requestedWmid);
        $xml .= '</getpurses>';
        $xml .= '</w3s.request>';

        return $xml;
    }

    /**
     * @return string
     */
    public function getResponseClassName()
    {
        return 'baibaratsky\WebMoney\Api\X\X9\Response';
    }

    /**
     * @param RequestSigner $requestSigner
     *
     * @return void
     */
    public function sign(RequestSigner $requestSigner = null)
    {
        if ($this->authType === self::AUTH_CLASSIC) {
            $this->signature = $requestSigner->sign($this->requestedWmid . $this->requestNumber);
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
    public function getRequestedWmid()
    {
        return $this->requestedWmid;
    }

    /**
     * @param string $requestedWmid
     */
    public function setRequestedWmid($requestedWmid)
    {
        $this->requestedWmid = $requestedWmid;
    }
}
