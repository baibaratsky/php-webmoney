<?php
namespace Baibaratsky\WebMoney\Api\Xml;

use Baibaratsky\WebMoney\Api\ApiResponse;

/**
 * Class X17ContractInfoResponse
 *
 * @link http://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X17
 */
class X17ContractInfoResponse extends ApiResponse
{
    /** @var string retdesc */
    protected $_returnDescription;

    /** @var X17ContractInfoResponseAcceptance[] contractinfo */
    protected $_acceptances = array();

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        $responseObject = new \SimpleXMLElement($response);
        $this->_returnCode = (int)$responseObject->retval;
        $this->_returnDescription = (string)$responseObject->retdesc;

        foreach ($responseObject->contractinfo->row as $contract) {
            $this->_acceptances[] = new X17ContractInfoResponseAcceptance(
                $contract['contractid'],
                $contract['wmid'],
                $contract['acceptdate']
            );
        }
    }

    /**
     * @return X17ContractInfoResponseAcceptance[]
     */
    public function getAcceptances()
    {
        return $this->_acceptances;
    }
}

class X17ContractInfoResponseAcceptance
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
