<?php

namespace baibaratsky\WebMoney\Api\X\X5;

class Finishprotect
{
    /** @var int @id */
    protected $operationid;
    /** @var int @ts */
    protected $operationts;
    /** @var string operation\opertype */
    protected $operationType;
    /** @var string operation\dateupd */
    protected $dateupd;

    public function __construct(array $data)
    {
        $this->operationid = $data['operationid'];
        $this->operationts = $data['operationts'];
        $this->operationType = $data['opertype'];
        $this->dateupd = $data['dateupd'];
    }

    /**
     * @return int
     */
    public function getOperationId()
    {
        return $this->operationid;
    }

    /**
     * @return int
     */
    public function getOperationTs()
    {
        return $this->operationts;
    }

    /**
     * @return string
     */
    public function getOperationType()
    {
        return $this->operationType;
    }

    /**
     * @return string
     */
    public function getDateupd()
    {
        return $this->dateupd;
    }
}
