<?php

/**
 * Class WMMegaStockCheckMerchant
 *
 * @link http://www.megastock.ru/Doc/AddIntMerchant.aspx
 */
class WMMSCheckMerchantRequest extends WMMSApiRequest
{
    /** @var int int_id */
    protected $_integratorId;

    /** @var string int_wmid */
    protected $_integratorWmid;

    /** @var int resourceid */
    protected $_resourceId;

    /** @var string sign */
    protected $_sign;

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
            WMApiRequestValidator::TYPE_REQUIRED => array('integratorId', 'integratorWmid', 'resourceId'),
        );
    }

    /**
     * @return string
     */
    public function getXml()
    {
        $xml = '<ms.request>';
        $xml .= '<login type="' . $this->_loginType . '"></login>';
        $xml .= self::_xmlElement('int_id', $this->_integratorId);
        $xml .= self::_xmlElement('int_wmid', $this->_integratorWmid);
        $xml .= self::_xmlElement('resourceid', $this->_resourceId);
        $xml .= self::_xmlElement('sign', $this->_sign);
        $xml .= '</ms.request>';

        return $xml;
    }

    /**
     * @return string
     */
    public function getResponseClassName()
    {
        return 'WMMSCheckMerchantResponse';
    }

    /**
     * @param WMRequestSigner $requestSigner
     *
     * @throws WMException
     */
    public function sign(WMRequestSigner $requestSigner = null)
    {
        $signString = $this->_loginType . $this->_integratorId . $this->_integratorWmid . $this->_resourceId;
        if ($this->_loginType == self::LOGIN_TYPE_KEEPER) {
            if ($requestSigner === null) {
                throw new WMException('This type of login requires the request signer.');
            }
            $this->_sign = $requestSigner->sign($signString);
        } else {
            $this->_sign = base64_encode(sha1($signString . $this->_salt));
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
