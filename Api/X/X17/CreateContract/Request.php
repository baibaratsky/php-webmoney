<?php

namespace baibaratsky\WebMoney\Api\X\X17\CreateContract;

use baibaratsky\WebMoney\Api\X;
use baibaratsky\WebMoney\Exception\ApiException;
use baibaratsky\WebMoney\Signer;
use baibaratsky\WebMoney\Request\RequestValidator;

/**
 * Class Request
 *
 * @link http://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X17
 */
class Request extends X\Request
{
    const CONTRACT_TYPE_OPEN_ACCESS = 1;
    const CONTRACT_TYPE_RESTRICTED_ACCESS = 2;

    /** @var string sign_wmid */
    protected $signerWmid;

    /** @var string name */
    protected $contractName;

    /** @var int ctype */
    protected $contractType;

    /** @var string text */
    protected $contractText;

    /** @var array accesslist\wmid */
    protected $accessListWmids;

    public function __construct($authType = self::AUTH_CLASSIC)
    {
        if ($authType !== self::AUTH_CLASSIC && $authType !== self::AUTH_LIGHT) {
            throw new ApiException('This interface doesn\'t support the authentication type given.');
        }

        $this->url = 'https://arbitrage.webmoney.ru/xml/X17_CreateContract.aspx';

        parent::__construct($authType);
    }

    /**
     * @return array
     */
    protected function getValidationRules()
    {
        return array(
            RequestValidator::TYPE_REQUIRED => array('contractName', 'contractType', 'contractText', 'accessListWmids'),
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
        $xml = '<contract.request>';
        $xml .= self::xmlElement('sign_wmid', $this->signerWmid);
        $xml .= self::xmlElement('name', $this->contractName);
        $xml .= self::xmlElement('ctype', $this->contractType);
        $xml .= self::xmlElement('text', $this->contractText);
        $xml .= self::xmlElement('sign', $this->signature);
        $xml .= '<accesslist>';

        foreach ($this->accessListWmids as $wmid) {
            $xml .= self::xmlElement('wmid', $wmid);
        }

        $xml .= '</accesslist>';
        $xml .= '</contract.request>';

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
     *
     */
    public function sign(Signer $requestSigner = null)
    {
        if ($this->authType === self::AUTH_CLASSIC) {
            $this->signature = $requestSigner->sign(
                    $this->signerWmid
                    . mb_strlen($this->contractName, 'UTF-8')
                    . $this->contractType
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
    public function getContractName()
    {
        return $this->contractName;
    }

    /**
     * @param string $contractName
     */
    public function setContractName($contractName)
    {
        $this->contractName = $contractName;
    }

    /**
     * @return int
     */
    public function getContractType()
    {
        return $this->contractType;
    }

    /**
     * @param int $contractType
     */
    public function setContractType($contractType)
    {
        $this->contractType = $contractType;
    }

    /**
     * @return string
     */
    public function getContractText()
    {
        return $this->contractText;
    }

    /**
     * @param string $contractText
     */
    public function setContractText($contractText)
    {
        $this->contractText = $contractText;
    }

    /**
     * @return array
     */
    public function getAccessListWmids()
    {
        return $this->accessListWmids;
    }

    /**
     * @param array $accessListWmids
     */
    public function setAccessListWmids(array $accessListWmids)
    {
        $this->accessListWmids = $accessListWmids;
    }
}
