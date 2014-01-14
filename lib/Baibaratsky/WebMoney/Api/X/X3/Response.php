<?php
namespace Baibaratsky\WebMoney\Api\X\X3;

use Baibaratsky\WebMoney;

/**
 * Class Response
 *
 * @link https://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X3
 */
class Response extends WebMoney\Request\Response
{
    /** @var int reqn */
    protected $_requestNumber;

    /** @var string retdesc */
    protected $_returnDescription;

    /** @var Operation[] operations */
    protected $_operations = array();

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        $responseObject = new \SimpleXMLElement($response);
        $this->_requestNumber = (int)$responseObject->reqn;
        $this->_returnCode = (int)$responseObject->retval;
        $this->_returnDescription = (int)$responseObject->retdesc;
        if (isset($responseObject->operations->operation)) {
            foreach ($responseObject->operations->operation as $operation) {
                $this->_operations[] = new Operation($this->_operationXmlToArray($operation));
            }
        }
    }

    /**
     * @return int
     */
    public function getRequestNumber()
    {
        return $this->_requestNumber;
    }

    /**
     * @return string
     */
    public function getReturnDescription()
    {
        return $this->_returnDescription;
    }

    /**
     * @return Operation[]
     */
    public function getOperations()
    {
        return $this->_operations;
    }

    protected function _operationXmlToArray($xml)
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
