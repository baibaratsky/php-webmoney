<?php

namespace baibaratsky\WebMoney\Api\X\X15\Get;

use baibaratsky\WebMoney\Api\X\X15\Trust;
use baibaratsky\WebMoney\Request\AbstractResponse;

/**
 * Class Response
 *
 * @link https://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X15
 */
class Response extends AbstractResponse
{
    /** @var int reqn */
    protected $requestNumber;

    /** @var Trust[] trustlist */
    protected $trusts = array();

    public function __construct($response)
    {
        parent::__construct($response);

        $responseObject = new \SimpleXMLElement($response);
        $this->requestNumber = (int)$responseObject->reqn;
        $this->returnCode = (int)$responseObject->retval;
        $this->returnDescription = (string)$responseObject->retdesc;

        if (isset($responseObject->trustlist)) {
            foreach ($responseObject->trustlist->children() as $trust) {
                $this->trusts[] = new Trust($this->trustToArray($trust));
            }
        }
    }

    protected function trustToArray(\SimpleXMLElement $trust)
    {
        return array(
                'id' => (int)$trust['id'],
                'canIssueInvoice' => (int)$trust['inv'],
                'canMakeTransfer' => (int)$trust['trans'],
                'canCheckBalance' => (int)$trust['purse'],
                'canViewHistory' => (int)$trust['transhist'],
                'masterWmid' => (string)$trust->master,
                'purse' => (string)$trust->purse,
                '24hLimit' => $trust->daylimit,
                'dayLimit' => $trust->dlimit,
                'weekLimit' => $trust->wlimit,
                'monthLimit' => $trust->mlimit,
                'daySum' => $trust->dsum,
                'weekSum' => $trust->wsum,
                'monthSum' => $trust->msum,
                'lastOperationDateTime' => self::createDateTime((string)$trust->lastsumdate),
                'payeeWmid' => $trust->storeswmid,
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
     * @return int
     */
    public function getReturnCode()
    {
        return $this->returnCode;
    }

    /**
     * @return Trust[]
     */
    public function getTrusts()
    {
        return $this->trusts;
    }
}
