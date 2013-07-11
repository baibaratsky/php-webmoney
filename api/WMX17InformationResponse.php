<?php

/**
 * Class WMX17InformationResponse
 *
 * @link http://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X17
 */
class WMX17InformationResponse extends WMApiResponse
{
    /** @var string retdesc */
    protected $_returnDescription;

    /** @var WMX17InformationResponseContractInfo[] contractinfo */
    protected $_contractsInfo = array();

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        $responseObject = new SimpleXMLElement($response);
        $this->_returnCode = (int)$responseObject->retval;
        $this->_returnDescription = (string)$responseObject->retdesc;

        foreach ($responseObject->contract->row as $contract) {
            $this->_contractsInfo[] = new WMX17InformationResponseContractInfo(
                $contract['contractid'],
                $contract['wmid'],
                $contract['acceptdate']
            );
        }
    }
}

class WMX17InformationResponseContractInfo
{
    /** @var int @contractid */
    protected $_contractId;

    /** @var string @wmid */
    protected $_wmid;

    /** @var string @acceptdate */
    protected $_acceptDate;

    public function __construct($contractId, $wmid, $acceptDate)
    {
        $this->_contractId = (int)$contractId;
        $this->_wmid = (string)$wmid;
        $this->_acceptDate = (string)$acceptDate;
    }

    /**
     * @return int
     */
    public function getContractId()
    {
        return $this->_contractId;
    }

    /**
     * @return string
     */
    public function getWmid()
    {
        return $this->_wmid;
    }

    /**
     * @return string
     */
    public function getAcceptDate()
    {
        return $this->_acceptDate;
    }
}
