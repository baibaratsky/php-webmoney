<?php
namespace baibaratsky\WebMoney\Api\X\X17\ContractInfo;

class Acceptance
{
    /** @var int @contractid */
    protected $contractId;

    /** @var string @wmid */
    protected $wmid;

    /** @var string @acceptdate */
    protected $acceptDate;

    public function __construct($contractId, $wmid, $acceptDate)
    {
        $this->contractId = (int)$contractId;
        $this->wmid = (string)$wmid;
        $this->acceptDate = (string)$acceptDate;
    }

    /**
     * @return int
     */
    public function getContractId()
    {
        return $this->contractId;
    }

    /**
     * @return string
     */
    public function getWmid()
    {
        return $this->wmid;
    }

    /**
     * @return string
     */
    public function getAcceptDate()
    {
        return $this->acceptDate;
    }
}
