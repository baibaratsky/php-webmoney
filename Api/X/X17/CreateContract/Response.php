<?php

namespace baibaratsky\WebMoney\Api\X\X17\CreateContract;

use baibaratsky\WebMoney\Request\AbstractResponse;

/**
 * Class Response
 *
 * @link http://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X17
 */
class Response extends AbstractResponse
{
    /** @var int contractid */
    protected $contractId;

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $responseObject = new \SimpleXMLElement($response);
        $this->returnCode = (int)$responseObject->retval;
        $this->returnDescription = (string)$responseObject->retdesc;
        $this->contractId = (int)$responseObject->contractid;
    }

    /**
     * @return int
     */
    public function getContractId()
    {
        return $this->contractId;
    }
}
