<?php

namespace baibaratsky\WebMoney\Api\MegaStock\CheckMerchant;

use baibaratsky\WebMoney\Api\MegaStock;
use baibaratsky\WebMoney\Exception\ApiException;
use baibaratsky\WebMoney\Signer;
use baibaratsky\WebMoney\Request\RequestValidator;

/**
 * Class Request
 *
 * @link http://www.megastock.ru/Doc/AddIntMerchant.aspx
 */
class Request extends MegaStock\Request
{
    /** @var int int_id */
    protected $integratorId;

    /** @var string int_wmid */
    protected $integratorWmid;

    /** @var int resourceid */
    protected $resourceId;

    public function __construct($loginType = self::LOGIN_TYPE_PROCESSING, $salt = null)
    {
        parent::__construct($loginType, $salt);

        $this->url = 'https://www.megastock.ru/xml/int/CheckMerchant.ashx';
    }

    /**
     * @return array
     */
    protected function getValidationRules()
    {
        return array(
            RequestValidator::TYPE_REQUIRED => array('integratorId', 'integratorWmid', 'resourceId'),
        );
    }

    /**
     * @return string
     */
    public function getData()
    {
        $xml = '<ms.request>';
        $xml .= '<login type="' . $this->loginType . '"></login>';
        $xml .= self::xmlElement('int_id', $this->integratorId);
        $xml .= self::xmlElement('int_wmid', $this->integratorWmid);
        $xml .= self::xmlElement('resourceid', $this->resourceId);
        $xml .= self::xmlElement('sign', $this->signature);
        $xml .= '</ms.request>';

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
     * @throws ApiException
     */
    public function sign(Signer $requestSigner = null)
    {
        $signString = $this->loginType . $this->integratorId . $this->integratorWmid . $this->resourceId;
        if ($this->loginType == self::LOGIN_TYPE_KEEPER) {
            if ($requestSigner === null) {
                throw new ApiException('This type of login requires the request signer.');
            }
            $this->signature = $requestSigner->sign($signString);
        } else {
            $this->signature = base64_encode(sha1($signString . $this->salt));
        }
    }

    /**
     * @return int
     */
    public function getIntegratorId()
    {
        return $this->integratorId;
    }

    /**
     * @param int $integratorId
     */
    public function setIntegratorId($integratorId)
    {
        $this->integratorId = $integratorId;
    }

    /**
     * @return string
     */
    public function getIntegratorWmid()
    {
        return $this->integratorWmid;
    }

    /**
     * @param string $integratorWmid
     */
    public function setIntegratorWmid($integratorWmid)
    {
        $this->integratorWmid = $integratorWmid;
    }

    /**
     * @return int
     */
    public function getResourceId()
    {
        return $this->resourceId;
    }

    /**
     * @param int $resourceId
     */
    public function setResourceId($resourceId)
    {
        $this->resourceId = $resourceId;
    }
}
