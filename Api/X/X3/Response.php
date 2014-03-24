<?php

namespace baibaratsky\WebMoney\Api\X\X3;

use baibaratsky\WebMoney;

/**
 * Class Response
 *
 * @link https://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X3
 */
class Response extends WebMoney\Request\Response
{
    /** @var int reqn */
    protected $requestNumber;

    /** @var string retdesc */
    protected $returnDescription;

    /** @var Operation[] operations */
    protected $operations = array();

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        $responseObject = new \SimpleXMLElement($response);
        $this->requestNumber = (int)$responseObject->reqn;
        $this->returnCode = (int)$responseObject->retval;
        $this->returnDescription = (int)$responseObject->retdesc;
        if (isset($responseObject->operations->operation)) {
            foreach ($responseObject->operations->operation as $operation) {
                $this->operations[] = new Operation($this->operationXmlToArray($operation));
            }
        }
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
     * @return Operation[]
     */
    public function getOperations()
    {
        return $this->operations;
    }

    protected function operationXmlToArray($xml)
    {
        $data = array(
            'invoiceId' => (int)$xml['id'],
            'systemInvoiceId' => (int)$xml['ts'],
            'senderPurse' => (string)$xml->pursesrc,
            'recipientPurse' => (string)$xml->pursedest,
            'amount' => (float)$xml->amount,
            'fee' => (float)$xml->comiss,
            'operationType' => (string)$xml->opertype,
            'wmInvoiceNumber' => (int)$xml->wminvid,
            'externalInvoiceId' => (int)$xml->orderid,
            'transactionId' => (int)$xml->tranid,
            'period' => (int)$xml->period,
            'description' => (string)$xml->desc,
            'createDateTime' => (string)$xml->datecrt,
            'updateDateTime' => (string)$xml->dateupd,
            'correspondentWmid' => (string)$xml->corrwm,
            'balance' => (float)$xml->rest,
        );

        if ($data['operationType'] != Operation::TYPE_SIMPLE) {
            $data['incomplete'] = isset($xml->timelock);
        }

        return $data;
    }
}
