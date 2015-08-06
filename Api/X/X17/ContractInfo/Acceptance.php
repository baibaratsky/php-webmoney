<?php

namespace baibaratsky\WebMoney\Api\X\X17\ContractInfo;

class Acceptance
{
    /** @var int @contractid */
    protected $contractId;

    /** @var string @wmid */
    protected $wmid;

    /** @var \DateTime|null @acceptdate */
    protected $acceptDateTime;

    /**
     * @param int $contractId
     * @param string $wmid
     * @param \DateTime|null $acceptDate
     */
    public function __construct($contractId, $wmid, \DateTime $acceptDate = null)
    {
        $this->contractId = $contractId;
        $this->wmid = $wmid;
        $this->acceptDateTime = $acceptDate;
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
     * @return \DateTime|null
     */
    public function getAcceptDateTime()
    {
        return $this->acceptDateTime;
    }

    /**
     * @deprecated Use getAcceptDateTime() instead
     * @return string
     */
    public function getAcceptDate()
    {
        if ($this->acceptDateTime === null) {
            return null;
        }

        return $this->acceptDateTime->format('Y-m-d\TH:i:s.u');
    }
}
