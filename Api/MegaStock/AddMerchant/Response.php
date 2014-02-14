<?php
namespace baibaratsky\WebMoney\Api\MegaStock\AddMerchant;

use baibaratsky\WebMoney;

/**
 * Class Response
 *
 * @link http://www.megastock.ru/Doc/AddIntMerchant.aspx?lang=en
 */
class Response extends WebMoney\Request\Response
{
    /** @var string retdescr */
    protected $returnDescription;

    /** @var int resourceid */
    protected $resourceId = null;

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        $responseObject = new \SimpleXMLElement($response);
        $this->returnCode = (int)$responseObject->retval;
        $this->returnDescription = (string)$responseObject->retdescr;
        if ($this->returnCode == 0) {
            $this->resourceId = (int)$responseObject->resourceid;
        }
    }

    /**
     * @return string
     */
    public function getReturnDescription()
    {
        return $this->returnDescription;
    }

    /**
     * @return int
     */
    public function getResourceId()
    {
        return $this->resourceId;
    }
}
