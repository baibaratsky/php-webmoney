<?php

namespace baibaratsky\WebMoney\Api\X\X17\ContractInfo;

use baibaratsky\WebMoney\Api\X;
use baibaratsky\WebMoney\Exception\ApiException;
use baibaratsky\WebMoney\Request\RequestValidator;
use baibaratsky\WebMoney\Signer;

/**
 * Class Request
 *
 * @link http://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X17
 */
class Request extends X\Request
{
    const TYPE_ACCEPT_DATE = 'acceptdate';

    /** @var int contractid */
    protected $contractId;

    /** @var string mode */
    protected $type;

    public function __construct($authType = self::AUTH_CLASSIC)
    {
        if (!in_array($authType, array(self::AUTH_CLASSIC, self::AUTH_LIGHT))) {
            throw new ApiException('This interface doesn\'t support the authentication type given.');
        }

        $this->url = 'https://arbitrage.webmoney.ru/xml/X17_GetContractInfo.aspx';
        $this->type = self::TYPE_ACCEPT_DATE;

        parent::__construct($authType);
    }

    /**
     * @return array
     */
    protected function getValidationRules()
    {
        return array(
                RequestValidator::TYPE_REQUIRED => array('contractId'),
                RequestValidator::TYPE_DEPEND_REQUIRED => array(
                        'signerWmid' => array('authType' => array(self::AUTH_CLASSIC)),
                ),
                RequestValidator::TYPE_RANGE => array(
                        'type' => array(self::TYPE_ACCEPT_DATE),
                ),
        );
    }

    /**
     * @return string
     */
    public function getData()
    {
        $xml = '<contract.request>';
        $xml .= self::xmlElement('wmid', $this->signerWmid);
        $xml .= self::xmlElement('contractid', $this->contractId);
        $xml .= self::xmlElement('mode', $this->type);
        $xml .= self::xmlElement('sign', $this->signature);
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
            $this->signature = $requestSigner->sign($this->contractId . $this->type);
        }
    }

    /**
     * @return int
     */
    public function getContractId()
    {
        return $this->contractId;
    }

    /**
     * @param int $contractId
     */
    public function setContractId($contractId)
    {
        $this->contractId = (int)$contractId;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = (string)$type;
    }
}
