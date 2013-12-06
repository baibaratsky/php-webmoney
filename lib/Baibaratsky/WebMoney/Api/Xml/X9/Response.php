<?php
namespace Baibaratsky\WebMoney\Api\Xml\X9;

use Baibaratsky\WebMoney\Api;

/**
 * Class Response
 *
 * @link https://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X9
 */
class Response extends Api\Response
{
    /** @var int reqn */
    protected $_requestNumber;

    /** @var string retdesc */
    protected $_returnDescription;

    /** @var Purse[] purses */
    protected $_purses;

    public function __construct($response)
    {
        $responseObject = new \SimpleXMLElement($response);
        $this->_requestNumber = (int)$responseObject->reqn;
        $this->_returnCode = (int)$responseObject->retval;
        $this->_returnDescription = (string)$responseObject->retdesc;
        if (isset($responseObject->purses)) {
            foreach ($responseObject->purses->children() as $purse) {
                $this->_purses[] = new Purse($this->_purseToArray($purse));
            }
        }
    }

    protected function _purseToArray(\SimpleXMLElement $purse)
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
     * @return Purse[]
     */
    public function getPurses()
    {
        return $this->_purses;
    }
}
