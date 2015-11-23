<?php

namespace baibaratsky\WebMoney\Api\X\X15;

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
	protected $trustlist = [];

	public function __construct($response)
	{
		$responseObject = new \SimpleXMLElement($response);
		$this->requestNumber = (int)$responseObject->reqn;
		$this->returnCode = (int)$responseObject->retval;
		$this->returnDescription = (string)$responseObject->retdesc;

		if (isset($responseObject->trustlist)) {
			foreach ($responseObject->trustlist->children() as $trust) {
				$this->trustlist[] = new Trust($this->trustToArray($trust));
			}
		}
	}

	protected function trustToArray(\SimpleXMLElement $trust)
	{
		return array(
			'id' => (int)$trust['id'],
			'canInvoice' => (int)$trust['inv'],
			'canTransfer' => (int)$trust['trans'],
			'canViewBalance' => (int)$trust['purse'],
			'canViewHistory' => (int)$trust['transhist'],
			'purse' => (string)$trust->purse,
            'daylimit' => $trust->daylimit,
            'dlimit' => $trust->dlimit,
            'wlimit' => $trust->wlimit,
            'mlimit' => $trust->mlimit,
            'dsum' => $trust->dsum,
            'wsum' => $trust->wsum,
            'msum' => $trust->msum,
            'lastsumdate' => $trust->lastsumdate,
            'storeswmid' => $trust->storeswmid
		);
	}

	/**
	 * @return Trust[]
	 */
	public function getTrustlist()
	{
		return $this->trustlist;
	}
}
