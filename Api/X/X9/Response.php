<?php

namespace baibaratsky\WebMoney\Api\X\X9;

use baibaratsky\WebMoney\Request\AbstractResponse;

/**
 * Class Response
 *
 * @link https://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X9
 */
class Response extends AbstractResponse
{
    /** @var Purse[] purses */
    protected $purses;

    public function __construct($response)
    {
        parent::__construct($response);

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
     * @return Purse[]
     */
    public function getPurses()
    {
        return $this->purses;
    }

    /**
     * @param $name
     * @return Purse|bool Returns false if there is no such purse
     */
    public function getPurseByName($name)
    {
        foreach ($this->purses as $purse) {
            if ($purse->getName() == $name) {
                return $purse;
            }
        }

        return false;
    }
}
