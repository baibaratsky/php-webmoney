<?php
namespace Baibaratsky\WebMoney\Api\X\X9;

class Purse
{
    /** @var int purse/@id */
    protected $id;

    /** @var string purse\pursename */
    protected $purseName;

    /** @var float purse\amount */
    protected $amount;

    /** @var string purse\desc */
    protected $description;

    /** @var int purse\outsideopen */
    protected $outsideOpen;

    /** @var string purse\lastintr */
    protected $lastIncomingTransaction;

    /** @var string purse\lastouttr */
    protected $lastOutgoingTransaction;

    public function __construct(array $params)
    {
        $this->id = $params['id'];
        $this->purseName = $params['pursename'];
        $this->amount = $params['amount'];
        $this->description = $params['desc'];
        $this->outsideOpen = $params['outsideopen'];
        $this->lastIncomingTransaction = $params['lastintr'];
        $this->lastOutgoingTransaction = $params['lastouttr'];
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPurseName()
    {
        return $this->purseName;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getOutsideOpen()
    {
        return $this->outsideOpen;
    }

    /**
     * @return string
     */
    public function getLastIncomingTransaction()
    {
        return $this->lastIncomingTransaction;
    }

    /**
     * @return string
     */
    public function getLastOutgoingTransaction()
    {
        return $this->lastOutgoingTransaction;
    }
}
