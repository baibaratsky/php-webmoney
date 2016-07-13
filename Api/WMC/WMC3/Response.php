<?php

namespace baibaratsky\WebMoney\Api\WMC\WMC3;

use baibaratsky\WebMoney\Request\AbstractResponse;
use DateTime;

/**
 * Class Response
 *
 * @link http://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_WMC3
 */
class Response extends AbstractResponse
{
    /** @var \DateTime datestart */
    protected $datestart;

    /** @var \DateTime dateend */
    protected $dateend;

    /** @var int history/@cnt */
    protected $count;

    /** @var Payment[] operations */
    protected $payments = array();

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $responseObject = new \SimpleXMLElement($response);
        $this->returnCode  = (int) $responseObject->retval;
        $this->returnDescription = (string) $responseObject->retdesc;
        $this->datestart   = self::createDateTime((string)$responseObject->datestart);
        $this->dateend     = self::createDateTime((string)$responseObject->dateend);

        if (isset($responseObject->history)) {
            $this->count       = (int) $responseObject->history['count'];
            foreach ($responseObject->history->children() as $payment) {
                $this->payments[] = new Payment($this->operationSimpleXmlToArray($payment));
            }
        }
    }

    /**
     * @return Payment[]
     */
    public function getPayments()
    {
        return $this->payments;
    }

    protected function operationSimpleXmlToArray($simpleXml)
    {
        $data = array(
            'id'         => (int) $simpleXml['id'],
            'currency'   => (string) $simpleXml['currency'],
            'test'       => (int)    $simpleXml['test'],
            'payeePurse' => (string) $simpleXml->purse,
            'phone'      => (string) $simpleXml->phone,
            'price'      => (float)  $simpleXml->price,
            'amount'     => (float)  $simpleXml->amount,
            'comiss'     => (float)  $simpleXml->comiss,
            'rest'       => (float)  $simpleXml->rest,
            'date'       => self::createDateTime((string)$simpleXml->date),
            'point'      => (int)    $simpleXml->point,
            'wmtranid'   => (int)    $simpleXml->wmtranid,
            'dateupd'    => self::createDateTime((string)$simpleXml->dateupd),
        );

        return $data;
    }

    /**
     * @return \DateTime
     */
    public function getDateStart()
    {
        return $this->datestart;
    }

    /**
     * @return \DateTime
     */
    public function getDateEnd()
    {
        return $this->dateend;
    }

    /**
     * @return string
     */
    public function getCount()
    {
        return $this->count;
    }
}
