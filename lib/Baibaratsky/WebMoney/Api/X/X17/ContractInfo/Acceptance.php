<?php
namespace Baibaratsky\WebMoney\Api\X\X17\ContractInfo;

class Acceptance
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
