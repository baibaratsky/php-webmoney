<?php

namespace baibaratsky\WebMoney\Api\X\X1;

use baibaratsky\WebMoney\Request\AbstractResponse;

/**
 * Class Response
 *
 * @link https://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X1
 */
class Response extends AbstractResponse
{
    /** @var Invoice */
    protected $invoice;

    public function __construct($response)
    {
        $responseObject          = new \SimpleXMLElement($response);
        $this->requestNumber     = (int)$responseObject->reqn;
        $this->returnCode        = (int)$responseObject->retval;
        $this->returnDescription = (string)$responseObject->retdesc;

        if (isset($responseObject->invoice)) {
            $this->invoice = new Invoice($this->invoiceToArray($responseObject->invoice));
        }
    }

    protected function invoiceToArray(\SimpleXMLElement $invoice)
    {
        return array(
            'invoiceid'    => (int)$invoice['id'],
            'invoicets'    => (int)$invoice['ts'],
            'orderid'      => (string)$invoice->orderid,
            'customerwmid' => (string)$invoice->customerwmid,
            'storepurse'   => (string)$invoice->storepurse,
            'amount'       => (float)$invoice->amount,
            'desc'         => (string)$invoice->desc,
            'address'      => (string)$invoice->address,
            'period'       => (int)$invoice->period,
            'expiration'   => (int)$invoice->expiration,
            'state'        => (int)$invoice->state,
            'datecrt'      => (string)$invoice->datecrt,
            'dateupd'      => (string)$invoice->dateupd,
        );
    }

    /**
     * @return Invoice
     */
    public function getInvoice()
    {
        return $this->invoice;
    }

    /**
     * @return int
     */
    public function getReturnCode()
    {
        return $this->returnCode;
    }
}
