<?php

namespace baibaratsky\WebMoney\Api\MegaStock\AddMerchant;

use baibaratsky\WebMoney\Request\AbstractResponse;

/**
 * Class Response
 *
 * @link http://www.megastock.ru/Doc/AddIntMerchant.aspx?lang=en
 */
class Response extends AbstractResponse
{
    /** @var int resourceid */
    protected $resourceId = null;

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $responseObject = new \SimpleXMLElement($response);
        $this->returnCode = (int)$responseObject->retval;
        $this->returnDescription = (string)$responseObject->retdescr;
        if ($this->returnCode == 0) {
            $this->resourceId = (int)$responseObject->resourceid;
        }
    }

    /**
     * @return int
     */
    public function getResourceId()
    {
        return $this->resourceId;
    }
}
