<?php
namespace Baibaratsky\WebMoney\Api\MegaStock;

use Baibaratsky\WebMoney\Api\ApiResponse;

/**
 * Class CheckMerchantResponse
 *
 * @link http://www.megastock.ru/Doc/AddIntMerchant.aspx
 */
class CheckMerchantResponse extends ApiResponse
{
    /** @var string retdescr */
    protected $_returnDescription;

    /** @var int resourceid */
    protected $_resourceId = null;

    /** @var string resourcestate */
    protected $_resourceState = null;

    /** @var string message */
    protected $_message = null;

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        $responseObject = new \SimpleXMLElement($response);
        $this->_returnCode = (int)$responseObject->retval;
        $this->_returnDescription = (string)$responseObject->retdescr;
        if ($this->_returnCode == 0) {
            $this->_resourceId = (int)$responseObject->resourceid;
            $this->_resourceState = (string)$responseObject->resourcestate;
            if ($this->_resourceState == 'не активирован' || $this->_resourceState == 'удален') {
                $this->_message = (string)$responseObject->message;
            }
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

    /**
     * @return string
     */
    public function getResourceState()
    {
        return $this->_resourceState;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->_message;
    }
}
