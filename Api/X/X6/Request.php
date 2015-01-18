<?php

namespace baibaratsky\WebMoney\Api\X\X6;

use baibaratsky\WebMoney\Api\X;
use baibaratsky\WebMoney\Exception\ApiException;
use baibaratsky\WebMoney\Signer;
use baibaratsky\WebMoney\Request\RequestValidator;

/**
 * Class Request
 *
 * @link http://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X6
 */
class Request extends X\Request
{
    /** @var string wmid */
    protected $signerWmid;

    /** @var string message\receiverwmid */
    protected $messageRecipientWmid;

    /** @var string message\msgsubj */
    protected $messageSubject;

    /** @var string message\msgtext */
    protected $messageText;

    /** @var int message\onlyauth */
    protected $messageOnlyAuth;

    /**
     * @param string $authType
     *
     * @throws ApiException
     */
    public function __construct($authType = self::AUTH_CLASSIC)
    {
        if ($authType === self::AUTH_CLASSIC) {
            $this->url = 'https://w3s.wmtransfer.com/asp/XMLSendMsg.asp';
        } elseif ($authType === self::AUTH_LIGHT) {
            $this->url = 'https://w3s.wmtransfer.com/asp/XMLSendMsgCert.asp';
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
            RequestValidator::TYPE_REQUIRED => array(
                'messageRecipientWmid', 'messageSubject', 'messageText',
            ),
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
        $xml .= '<message>';
        $xml .= self::xmlElement('receiverwmid', $this->messageRecipientWmid);
        $xml .= self::xmlElement('msgsubj', $this->messageSubject);
        $xml .= self::xmlElement('msgtext', $this->messageText);
        $xml .= self::xmlElement('onlyauth', $this->messageOnlyAuth);
        $xml .= '</message>';
        $xml .= '</w3s.request>';

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
     * @param Signer $requestSigner
     */
    public function sign(Signer $requestSigner = null)
    {
        if ($this->authType === self::AUTH_CLASSIC) {
            $this->signature = $requestSigner->sign(
                $this->messageRecipientWmid .
                $this->requestNumber .
                mb_convert_encoding($this->messageText, 'Windows-1251', 'UTF-8') .
                mb_convert_encoding($this->messageSubject, 'Windows-1251', 'UTF-8')
            );
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
    public function getMessageRecipientWmid()
    {
        return $this->messageRecipientWmid;
    }

    /**
     * @param string $messageRecipientWmid
     */
    public function setMessageRecipientWmid($messageRecipientWmid)
    {
        $this->messageRecipientWmid = $messageRecipientWmid;
    }

    /**
     * @return string
     */
    public function getMessageSubject()
    {
        return $this->messageSubject;
    }

    /**
     * @param string $messageSubject
     */
    public function setMessageSubject($messageSubject)
    {
        $this->messageSubject = $messageSubject;
    }

    /**
     * @return string
     */
    public function getMessageText()
    {
        return $this->messageText;
    }

    /**
     * @param string $messageText
     */
    public function setMessageText($messageText)
    {
        $this->messageText = $messageText;
    }

    /**
     * @return int
     */
    public function getMessageOnlyAuth()
    {
        return $this->messageOnlyAuth;
    }

    /**
     * @param int $messageOnlyAuth
     */
    public function setMessageOnlyAuth($messageOnlyAuth)
    {
        $this->messageOnlyAuth = $messageOnlyAuth;
    }
}
