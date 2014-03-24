<?php

namespace baibaratsky\WebMoney\Api\X\X11;

class Passport
{
    /** @var int cid */
    private $id;

    /** @var int regcid */
    private $registrantId;

    /** @var int tid */
    private $type;

    /** @var bool locked */
    private $rightToIssue;

    /** @var bool admlocked */
    private $admRightToIssue;

    /** @var bool recalled */
    private $recalled;

    /** @var string datecrt */
    private $issuanceDt;

    /** @var int datediff */
    private $issuanceDiff;

    /** @var string regnickname */
    private $registrantNickname;

    /** @var string regwmid */
    private $registrantWmid;

    /** @var string status */
    private $status;

    /** @var string notary */
    private $notary;

    /**
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->id = (int)$params['cid'];
        $this->registrantId = (int)$params['regcid'];
        $this->type = (int)$params['tid'];
        $this->rightToIssue = (bool)$params['locked'];
        $this->admRightToIssue = (bool)$params['admlocked'];
        $this->recalled = (bool)$params['recalled'];
        $this->issuanceDt = $params['datecrt'];
        $this->issuanceDiff = (int)$params['datediff'];
        if (isset($params['regnickname'])) {
            $this->registrantNickname = $params['regnickname'];
        }
        $this->registrantWmid = $params['regwmid'];
        $this->status = $params['status'];
        $this->notary = $params['notary'];
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getRegistrantId()
    {
        return $this->registrantId;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function getRightToIssue()
    {
        return $this->rightToIssue;
    }

    /**
     * @return bool
     */
    public function getAdmRightToIssue()
    {
        return $this->admRightToIssue;
    }

    /**
     * @return bool
     */
    public function getRecalled()
    {
        return $this->recalled;
    }

    /**
     * @return string
     */
    public function getIssuanceDt()
    {
        return $this->issuanceDt;
    }

    /**
     * @return int
     */
    public function getIssuanceDiff()
    {
        return $this->issuanceDiff;
    }

    /**
     * @return string
     */
    public function getRegistrantNickname()
    {
        return $this->registrantNickname;
    }

    /**
     * @return string
     */
    public function getRegistrantWmid()
    {
        return $this->registrantWmid;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getNotary()
    {
        return $this->notary;
    }
}
