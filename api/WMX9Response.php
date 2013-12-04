<?php

/**
 * Class WMX9Response
 *
 * @link https://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X9
 */
class WMX9Response extends WMApiResponse
{
    /** @var int reqn */
    protected $_requestNumber;

    /** @var string retdesc */
    protected $_returnDescription;

    /** @var WMX9ResponsePurse[] purses */
    protected $_purses;

    public function __construct($response)
    {
        $responseObject = new SimpleXMLElement($response);
        $this->_requestNumber = (int)$responseObject->reqn;
        $this->_returnCode = (int)$responseObject->retval;
        $this->_returnDescription = (string)$responseObject->retdesc;
        if (isset($responseObject->purses)) {
            foreach ($responseObject->purses->children() as $purse) {
                $this->_purses[] = new WMX9ResponsePurse($this->_purseToArray($purse));
            }
        }
    }

    protected function _purseToArray(SimpleXMLElement $purse)
    {
        return array(
            'id' => (int)$purse['id'],
            'pursename' => (string)$purse->pursename,
            'amount' => (float)$purse->amount,
            'desc' => (string)$purse->desc,
            'outsideopen' => (string)$purse->outsideopen,
            'lastintr' => (string)$purse->lastintr,
            'lastouttr' => (string)$purse->lastouttr,
        );
    }

    /**
     * @return int
     */
    public function getRequestNumber()
    {
        return $this->_requestNumber;
    }

    /**
     * @return string
     */
    public function getReturnDescription()
    {
        return $this->_returnDescription;
    }

    /**
     * @return \WMX9ResponsePurse[]
     */
    public function getPurses()
    {
        return $this->_purses;
    }
}

class WMX9ResponsePurse
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
