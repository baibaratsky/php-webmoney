<?php

namespace baibaratsky\WebMoney\Api\X\X23;

use baibaratsky\WebMoney\Request\AbstractResponse;

/**
 * Class Response
 *
 * @link https://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X23
 */
class Response extends AbstractResponse
{
    const STATUS_NOT_PAID = 0;
    const STATUS_PAID_WITH_PROTECTION = 1;
    const STATUS_PAID = 2;
    const STATUS_DECLINED = 3;

    /** @var int reqn */
    protected $requestNumber;

    /** @var int @id */
    protected $invoiceId;

    /** @var int ininvoice/state */
    protected $status;

    /** @var \DateTime ininvoice/dateupd */
    protected $updateDateTime;

    public function __construct($response)
    {
        parent::__construct($response);

        $responseObject = new \SimpleXMLElement($response);
        $this->requestNumber = (int)$responseObject->reqn;
        $this->returnCode = (int)$responseObject->retval;
        $this->returnDescription = (string)$responseObject->retdesc;

        if (isset($responseObject->ininvoice)) {
            $ininvoice = $responseObject->ininvoice;
            $this->invoiceId = (int)$ininvoice['id'];
            $this->status = (int)$ininvoice->state;
            $this->updateDateTime = self::createDateTime((string)$ininvoice->dateupd); //wm format Ymd H:i:s
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
     * @return int
     */
    public function getInvoiceId()
    {
        return $this->invoiceId;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return \DateTime
     */
    public function getUpdateDateTime()
    {
        return $this->updateDateTime;
    }
}
