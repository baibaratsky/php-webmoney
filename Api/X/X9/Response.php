<?php
namespace Baibaratsky\WebMoney\Api\X\X9;

use Baibaratsky\WebMoney;

/**
 * Class Response
 *
 * @link https://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X9
 */
class Response extends WebMoney\Request\Response
{
    /** @var int reqn */
    protected $requestNumber;

    /** @var string retdesc */
    protected $returnDescription;

    /** @var Purse[] purses */
    protected $purses;

    public function __construct($response)
    {
        $responseObject = new \SimpleXMLElement($response);
        $this->requestNumber = (int)$responseObject->reqn;
        $this->returnCode = (int)$responseObject->retval;
        $this->returnDescription = (string)$responseObject->retdesc;
        if (isset($responseObject->purses)) {
            foreach ($responseObject->purses->children() as $purse) {
                $this->purses[] = new Purse($this->purseToArray($purse));
            }
        }
    }

    protected function purseToArray(\SimpleXMLElement $purse)
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
        return $this->requestNumber;
    }

    /**
     * @return string
     */
    public function getReturnDescription()
    {
        return $this->returnDescription;
    }

    /**
     * @return Purse[]
     */
    public function getPurses()
    {
        return $this->purses;
    }
}
