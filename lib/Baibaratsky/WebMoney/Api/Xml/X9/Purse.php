<?php
namespace Baibaratsky\WebMoney\Api\Xml\X9;

class Purse
{
    /** @var int purse@id */
    protected $_id;

    /** @var string purse\pursename */
    protected $_purseName;

    /** @var float purse\amount */
    protected $_amount;

    /** @var string purse\desc */
    protected $_description;

    /** @var int purse\outsideopen */
    protected $_outsideOpen;

    /** @var string purse\lastintr */
    protected $_lastIncomingTransaction;

    /** @var string purse\lastouttr */
    protected $_lastOutgoingTransaction;

    public function __construct(array $params)
    {
        $this->_id = $params['id'];
        $this->_purseName = $params['pursename'];
        $this->_amount = $params['amount'];
        $this->_description = $params['desc'];
        $this->_outsideOpen = $params['outsideopen'];
        $this->_lastIncomingTransaction = $params['lastintr'];
        $this->_lastOutgoingTransaction = $params['lastouttr'];
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @return string
     */
    public function getPurseName()
    {
        return $this->_purseName;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->_amount;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->_description;
    }

    /**
     * @return int
     */
    public function getOutsideOpen()
    {
        return $this->_outsideOpen;
    }

    /**
     * @return string
     */
    public function getLastIncomingTransaction()
    {
        return $this->_lastIncomingTransaction;
    }

    /**
     * @return string
     */
    public function getLastOutgoingTransaction()
    {
        return $this->_lastOutgoingTransaction;
    }
}
