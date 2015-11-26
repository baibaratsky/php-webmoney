<?php

namespace baibaratsky\WebMoney\Api\X\X21\TrustConfirm;

use baibaratsky\WebMoney\Request\AbstractResponse;

/**
 * Class Response
 *
 * @link http://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X21
 */
class Response extends AbstractResponse
{
    /** @var int trust/@id */
    protected $trustId;

    /** @var string trust/slavepurse */
    protected $slavePurse;

    /** @var string trust/slavewmid */
    protected $slaveWmid;

    /** @var string userdesc */
    protected $userDescription;

    /** @var string smssentstate */
    protected $smsSentState;

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $responseObject = new \SimpleXMLElement($response);
        $this->returnCode = (int) $responseObject->retval;
        $this->returnDescription = (string) $responseObject->retdesc;

        $this->trustId = (int)$responseObject->trust['id'];
        $this->slavePurse = (string)$responseObject->trust->slavepurse;
        $this->slaveWmid = (string)$responseObject->trust->slavewmid;
        $this->userDescription = (string)$responseObject->userdesc;
        $this->smsSentState = (string)$responseObject->smssentstate;
    }

    /**
     * @return int trust/@id
     */
    public function getTrustId()
    {
        return $this->trustId;
    }

    /**
     * @return string trust/slavepurse
     */
    public function getSlavePurse()
    {
        return $this->slavePurse;
    }

    /**
     * @return string trust/slavewmid
     */
    public function getSlaveWmid()
    {
        return $this->slaveWmid;
    }

    /**
     * @return string userdesc
     */
    public function getUserDescription()
    {
        return $this->userDescription;
    }

    /**
     * @return string smssentstate
     */
    public function getSmsSentState()
    {
        return $this->smsSentState;
    }
}
