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
        parent::__construct($response);

        $responseObject = new \SimpleXMLElement($response);
        $this->requestNumber = (int)$responseObject->reqn;
        $this->returnCode = (int)$responseObject->retval;
        $this->returnDescription = (string)$responseObject->retdesc;
        if (isset($responseObject->operations)) {
            foreach ($responseObject->operations->children() as $operation) {
                $this->operations[] = new Operation($this->operationSimpleXmlToArray($operation));
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

    protected function operationSimpleXmlToArray($simpleXml)
    {
        $data = array(
                'transactionId' => (int)$simpleXml['id'],
                'payerPurse' => (string)$simpleXml->pursesrc,
                'payeePurse' => (string)$simpleXml->pursedest,
                'amount' => (float)$simpleXml->amount,
                'fee' => (float)$simpleXml->comiss,
                'status' => (string)$simpleXml->opertype,
                'invoiceId' => (int)$simpleXml->wminvid,
                'orderId' => (int)$simpleXml->orderid,
                'transactionExternalId' => (int)$simpleXml->tranid,
                'protectionPeriod' => (int)$simpleXml->period,
                'description' => (string)$simpleXml->desc,
                'createDateTime' => self::createDateTime((string)$simpleXml->datecrt),
                'updateDateTime' => self::createDateTime((string)$simpleXml->dateupd),
                'correspondentWmid' => (string)$simpleXml->corrwm,
                'balance' => (float)$simpleXml->rest,
        );

        if ($data['status'] != Operation::STATUS_COMPLETED) {
            $data['incomplete'] = isset($simpleXml->timelock);
        }

        return $data;
    }
}
