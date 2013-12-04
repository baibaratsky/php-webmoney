<?php
namespace Baibaratsky\WebMoney\Api\MegaStock;

use Baibaratsky\WebMoney\Api\Response as ApiResponse;

/**
 * Class Response
 *
 * @link http://www.megastock.ru/Doc/AddIntMerchant.aspx?lang=en
 */
class Response extends ApiResponse
{
    /** @var string retdescr */
    protected $_returnDescription;

    /** @var int resourceid */
    protected $_resourceId = null;

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
