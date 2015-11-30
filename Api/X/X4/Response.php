<?php

namespace baibaratsky\WebMoney\Api\X\X4;

use baibaratsky\WebMoney\Request\AbstractResponse;

/**
 * Class Response
 *
 * @link https://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X4
 */
class Response extends AbstractResponse
{
	/** @var int reqn */
	protected $requestNumber;

	/** @var Trust[] trustlist */
	protected $outInvoices = [];

	public function __construct($response)
	{
		$responseObject = new \SimpleXMLElement($response);
		$this->requestNumber = (int)$responseObject->reqn;
		$this->returnCode = (int)$responseObject->retval;
		$this->returnDescription = (string)$responseObject->retdesc;

		if (isset($responseObject->outinvoices)) {
			foreach ($responseObject->outinvoices->children() as $outinvoice) {
				$this->outInvoices[] = new OutInvoice($this->operationXmlToArray($outinvoice));
			}
		}
	}

	protected function operationXmlToArray($xml)
	{
		return array(
			'outInvoiceId' => (int)$xml['id'],
			'orderId' => (string)$xml->orderid,
			'customerWmid' => (string)$xml->customerwmid,
			'purse' => (string)$xml->storepurse,
			'amount' => (float)$xml->amount,
			'description' => (string)$xml->desc,
			'address' => (string)$xml->address,
			'period' => (int)$xml->period,
			'expiration' => (int)$xml->expiration,
			'state' => (int)$xml->state,
			'createDateTime' => (string)$xml->datecrt,
			'updateDateTime' => (string)$xml->dateupd,
			'wmtranid' => (int)$xml->wmtranid,
			'customerPurse' => (string)$xml->customerpurse,
		);
	}

	/**
	 * @return OutInvoice[]
	 */
	public function getOutinvoices()
	{
		return $this->outinvoices;
	}

    /**
	 * @return int
	 */
	public function getReturnCode()
	{
		return $this->returnCode;
	}
}
