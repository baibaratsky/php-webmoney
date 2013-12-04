<?php
namespace Baibaratsky\WebMoney\Api\Xml\X17\CreateContract;

use Baibaratsky\WebMoney\Api\Response as ApiResponse;

/**
 * Class Response
 *
 * @link http://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X17
 */
class Response extends ApiResponse
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
        $responseObject = new \SimpleXMLElement($response);
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
