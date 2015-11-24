<?php

namespace baibaratsky\WebMoney\Api\X\X15\Get;

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
	protected $trusts = [];

	public function __construct($response)
	{
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
			'purse' => (string)$trust->purse,
			'limit24h' => $trust->limit24h,
			'limitDay' => $trust->limitDay,
			'limitWeek' => $trust->limitWeek,
            'limitMonth' => $trust->limitMonth,
            'sumDay' => $trust->sumDay,
            'sumWeek' => $trust->sumWeek,
            'sumMonth' => $trust->sumMonth,
            'lastOperationDateTime' => $trust->lastOperationDateTime,
            'payeeWmid' => $trust->payeeWmid,
		);
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
