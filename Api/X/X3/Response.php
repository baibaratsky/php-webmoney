<?php

namespace baibaratsky\WebMoney\Api\X\X3;

use baibaratsky\WebMoney\Request\AbstractResponse;

/**
 * Class Response
 *
 * @link https://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X3
 */
class Response extends AbstractResponse
{
    /** @var int reqn */
    protected $requestNumber;

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
        $this->returnDescription = (string)$responseObject->retdesc;
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
     * @return Operation[]
     */
    public function getOperations()
    {
        return $this->operations;
    }

    protected function operationXmlToArray($xml)
    {
        $data = array(
            'transactionId' => (int)$xml['id'],
            'payerPurse' => (string)$xml->pursesrc,
            'payeePurse' => (string)$xml->pursedest,
            'amount' => (float)$xml->amount,
            'fee' => (float)$xml->comiss,
            'operationType' => (string)$xml->opertype,
            'invoiceId' => (int)$xml->wminvid,
            'orderId' => (int)$xml->orderid,
            'transactionExternalId' => (int)$xml->tranid,
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
