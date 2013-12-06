<?php
namespace Baibaratsky\WebMoney\Api\MegaStock\CheckMerchant;

use Baibaratsky\WebMoney\Api\MegaStock;
use Baibaratsky\WebMoney\Exception\ApiException;
use Baibaratsky\WebMoney\Signer\RequestSigner;
use Baibaratsky\WebMoney\Validator\RequestValidator;

/**
 * Class Request
 *
 * @link http://www.megastock.ru/Doc/AddIntMerchant.aspx
 */
class Request extends MegaStock\Request
{
    /** @var int int_id */
    protected $_integratorId;

    /** @var string int_wmid */
    protected $_integratorWmid;

    /** @var int resourceid */
    protected $_resourceId;

    public function __construct($loginType = self::LOGIN_TYPE_PROCESSING, $salt = null)
    {
        parent::__construct($loginType, $salt);

        $this->_url = 'https://www.megastock.ru/xml/int/CheckMerchant.ashx';
    }

    /**
     * @return array
     */
    protected function _getValidationRules()
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
        $xml .= '<login type="' . $this->_loginType . '"></login>';
        $xml .= self::_xmlElement('int_id', $this->_integratorId);
        $xml .= self::_xmlElement('int_wmid', $this->_integratorWmid);
        $xml .= self::_xmlElement('resourceid', $this->_resourceId);
        $xml .= self::_xmlElement('sign', $this->_signature);
        $xml .= '</ms.request>';

        return $xml;
    }

    /**
     * @return string
     */
    public function getResponseClassName()
    {
        return 'Baibaratsky\WebMoney\Api\MegaStock\CheckMerchant\Response';
    }

    /**
     * @param RequestSigner $requestSigner
     *
     * @throws ApiException
     */
    public function sign(RequestSigner $requestSigner = null)
    {
        $signString = $this->_loginType . $this->_integratorId . $this->_integratorWmid . $this->_resourceId;
        if ($this->_loginType == self::LOGIN_TYPE_KEEPER) {
            if ($requestSigner === null) {
                throw new ApiException('This type of login requires the request signer.');
            }
            $this->_signature = $requestSigner->sign($signString);
        } else {
            $this->_signature = base64_encode(sha1($signString . $this->_salt));
        }
    }

    /**
     * @return int
     */
    public function getIntegratorId()
    {
        return $this->_integratorId;
    }

    /**
     * @param int $integratorId
     */
    public function setIntegratorId($integratorId)
    {
        $this->_integratorId = $integratorId;
    }

    /**
     * @return string
     */
    public function getIntegratorWmid()
    {
        return $this->_integratorWmid;
    }

    /**
     * @param string $integratorWmid
     */
    public function setIntegratorWmid($integratorWmid)
    {
        $this->_integratorWmid = $integratorWmid;
    }

    /**
     * @return int
     */
    public function getResourceId()
    {
        return $this->_resourceId;
    }

    /**
     * @param int $resourceId
     */
    public function setResourceId($resourceId)
    {
        $this->_resourceId = $resourceId;
    }
}
