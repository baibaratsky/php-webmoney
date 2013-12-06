<?php
namespace Baibaratsky\WebMoney\Api\X\X17\CreateContract;

use Baibaratsky\WebMoney;

/**
 * Class Response
 *
 * @link http://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X17
 */
class Response extends WebMoney\Request\Response
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
