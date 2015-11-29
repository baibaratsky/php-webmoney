<?php

namespace baibaratsky\WebMoney\Api\X\X21\TrustRequest;

use baibaratsky\WebMoney\Request\AbstractResponse;

/**
 * Class Response
 *
 * @link http://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X21
 */
class Response extends AbstractResponse
{
    /** @var int trust/@purseid */
    protected $purseId;

    /** @var int trust/realsmstype */
    protected $realSmsType;

    /** @var string userdesc */
    protected $userDescription;

    /** @var string slavepurse */
    protected $slavePurse;

    /** @var int slavewmid */
    protected $slaveWmid;

    /** @var int smssecureid */
    protected $smsSecureId;

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $responseObject = new \SimpleXMLElement($response);
        $this->returnCode = (int)$responseObject->retval;
        $this->returnDescription = (string)$responseObject->retdesc;

        $this->purseId = (int)$responseObject->trust['purseid'];
        $this->realSmsType = (int)$responseObject->trust->realsmstype;
        $this->userDescription = (string)$responseObject->userdesc;
        if ($responseObject->slavepurse) {
            $this->slavePurse = (string)$responseObject->slavepurse;
        }
        if ($responseObject->slavewmid) {
            $this->slaveWmid = (int)$responseObject->slavewmid;
        }
        if ($responseObject->smssecureid) {
            $this->smsSecureId = (int)$responseObject->smssecureid;
        }
    }

    /**
     * @return int trust/@purseid
     */
    public function getPurseId()
    {
        return $this->purseId;
    }

    /**
     * @return int trust/realsmstype
     */
    public function getRealSmsType()
    {
        return $this->realSmsType;
    }

    /**
     * @return string userdesc
     */
    public function getUserDescription()
    {
        return $this->userDescription;
    }

    /**
     * @return string slavepurse
     */
    public function getSlavePurse()
    {
        return $this->slavePurse;
    }

    /**
     * @return int slavewmid
     */
    public function getSlaveWmid()
    {
        return $this->slaveWmid;
    }

    /**
     * @return int smssecureid
     */
    public function getSmsSecureId()
    {
        return $this->smsSecureId;
    }
}
