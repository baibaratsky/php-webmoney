<?php

/**
 * Class WMMSAddMerchantResponse
 *
 * @link http://www.megastock.ru/Doc/AddIntMerchant.aspx?lang=en
 */
class WMMSAddMerchantResponse extends WMApiResponse
{
    /** @var string retdescr */
    protected $_returnDescription;

    /** @var int resourceid */
    protected $_resourceId;

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        $responseObject = new SimpleXMLElement($response);
        $this->_returnCode = (int)$responseObject->retval;
        $this->_returnDescription = (string)$responseObject->retdescr;
        if ($this->_returnCode == 0) {
            $this->_resourceId = (int)$responseObject->resourceid;
        }
    }

    /**
     * @return string
     */
    public function getReturnDescription()
    {
        return $this->_returnDescription;
    }

    /**
     * @return int
     */
    public function getResourceId()
    {
        return $this->_resourceId;
    }
}
