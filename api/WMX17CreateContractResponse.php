<?php

/**
 * Class WMX17CreateContractResponse
 *
 * @link http://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X17
 */
class WMX17CreateContractResponse extends WMApiResponse
{
    /** @var string retdesc */
    protected $_returnDescription;

    /** @var int contractid */
    protected $_contractId;

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        $responseObject = new SimpleXMLElement($response);
        $this->_returnCode = (int)$responseObject->retval;
        $this->_returnDescription = (string)$responseObject->retdesc;
        $this->_contractId = (int)$responseObject->contractid;
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
    public function getContractId()
    {
        return $this->_contractId;
    }
}
