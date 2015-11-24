<?php

namespace baibaratsky\WebMoney\Api\X\X6;

use baibaratsky\WebMoney\Request\AbstractResponse;

/**
 * Class Response
 *
 * @link http://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X6
 */
class Response extends AbstractResponse
{
    /** @var Message message */
    protected $message;

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $responseObject = new \SimpleXMLElement($response);
        $this->returnCode = (int)$responseObject->retval;
        $this->returnDescription = (string)$responseObject->retdesc;
        $this->message = new Message(
                (string)$responseObject->message->receiverwmid,
                (string)$responseObject->message->msgsubj,
                (string)$responseObject->message->msgtext,
                self::createDateTime((string)$responseObject->message->datecrt)
        );
    }

    /**
     * @return Message
     */
    public function getMessage()
    {
        return $this->message;
    }
}
