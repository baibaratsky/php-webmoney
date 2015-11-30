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

    /** @var Invoice[] outinvoices */
    protected $invoices = array();

    public function __construct($response)
    {
        parent::__construct($response);

        $responseSimpleXml = new \SimpleXMLElement($response);
        $this->requestNumber = (int)$responseSimpleXml->reqn;
        $this->returnCode = (int)$responseSimpleXml->retval;
        $this->returnDescription = (string)$responseSimpleXml->retdesc;
        if (isset($responseSimpleXml->outinvoices)) {
            foreach ($responseSimpleXml->outinvoices->children() as $invoiceSimpleXml) {
                $this->invoices[] = new Invoice($this->invoiceSimpleXmlToArray($invoiceSimpleXml));
            }
        }
    }

    protected function invoiceSimpleXmlToArray($simpleXml)
    {
        return array(
                'id' => (int)$simpleXml['id'],
                'orderId' => (string)$simpleXml->orderid,
                'customerWmid' => (string)$simpleXml->customerwmid,
                'purse' => (string)$simpleXml->storepurse,
                'amount' => (float)$simpleXml->amount,
                'description' => (string)$simpleXml->desc,
                'address' => (string)$simpleXml->address,
                'protectionPeriod' => (int)$simpleXml->period,
                'expiration' => (int)$simpleXml->expiration,
                'status' => (int)$simpleXml->state,
                'createDateTime' => self::createDateTime((string)$simpleXml->datecrt),
                'updateDateTime' => self::createDateTime((string)$simpleXml->dateupd),
                'transactionId' => (int)$simpleXml->wmtranid,
                'customerPurse' => (string)$simpleXml->customerpurse,
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
     * @return Invoice[]
     */
    public function getInvoices()
    {
        return $this->invoices;
    }
}
