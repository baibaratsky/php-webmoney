<?php

namespace baibaratsky\WebMoney\Api\MegaStock\CheckMerchant;

use baibaratsky\WebMoney;

/**
 * Class Response
 *
 * @link http://www.megastock.ru/Doc/AddIntMerchant.aspx
 */
class Response extends WebMoney\Request\Response
{
    /** @var string retdescr */
    protected $returnDescription;

    /** @var int resourceid */
    protected $resourceId = null;

    /** @var string resourcestate */
    protected $resourceState = null;

    /** @var string message */
    protected $message = null;

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
            $this->resourceState = (string)$responseObject->resourcestate;
            if (!empty($this->resourceState)) {
                $this->message = (string)$responseObject->message;
            }
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

    /**
     * @return string
     */
    public function getResourceState()
    {
        return $this->resourceState;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }
}
