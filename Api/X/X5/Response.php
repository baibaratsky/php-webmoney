<?php

namespace baibaratsky\WebMoney\Api\X\X5;

use baibaratsky\WebMoney\Request\AbstractResponse;

/**
 * Class Response
 *
 * @link https://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X5
 */
class Response extends AbstractResponse
{
    /** @var int reqn */
    protected $requestNumber;

    /** @var Finishprotect */
    protected $operation;

    public function __construct($response)
    {
        $responseObject = new \SimpleXMLElement($response);
        $this->requestNumber = (int)$responseObject->reqn;
        $this->returnCode = (int)$responseObject->retval;
        $this->returnDescription = (string)$responseObject->retdesc;

        if (isset($responseObject->operation)) {
            $this->operation = new Finishprotect($this->operationToArray($responseObject->operation));
        }
    }

    protected function operationToArray(\SimpleXMLElement $operation)
    {
        return array(
            'operationid' => (int)$operation['id'],
            'operationts' => (int)$operation['ts'],
            'opertype' => (string)$operation->opertype,
            'dateupd' => (string)$operation->dateupd,

        );
    }

    /**
     * @return Finishprotect
     */
    public function getOperation()
    {
        return $this->operation;
    }
    /**
     * @return int
     */
    public function getReturnCode()
    {
        return $this->returnCode;
    }
}
