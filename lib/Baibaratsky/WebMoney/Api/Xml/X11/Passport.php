<?php
namespace Baibaratsky\WebMoney\Api\Xml\X11;

class Passport
{
    /** @var int cid */
    private $_id;

    /** @var int regcid */
    private $_registrantId;

    /** @var int tid */
    private $_type;

    /** @var bool locked */
    private $_rightToIssue;

    /** @var bool admlocked */
    private $_admRightToIssue;

    /** @var bool recalled */
    private $_recalled;

    /** @var string datecrt */
    private $_issuanceDt;

    /** @var int datediff */
    private $_issuanceDiff;

    /** @var string regnickname */
    private $_registrantNickname;

    /** @var string regwmid */
    private $_registrantWmid;

    /** @var string status */
    private $_status;

    /** @var string notary */
    private $_notary;

    /**
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->_id = (int)$params['cid'];
        $this->_registrantId = (int)$params['regcid'];
        $this->_type = (int)$params['tid'];
        $this->_rightToIssue = (bool)$params['locked'];
        $this->_admRightToIssue = (bool)$params['admlocked'];
        $this->_recalled = (bool)$params['recalled'];
        $this->_issuanceDt = $params['datecrt'];
        $this->_issuanceDiff = (int)$params['datediff'];
        $this->_registrantNickname = $params['regnickname'];
        $this->_registrantWmid = $params['regwmid'];
        $this->_status = $params['status'];
        $this->_notary = $params['notary'];
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @return int
     */
    public function getRegistrantId()
    {
        return $this->_registrantId;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * @return bool
     */
    public function getRightToIssue()
    {
        return $this->_rightToIssue;
    }

    /**
     * @return bool
     */
    public function getAdmRightToIssue()
    {
        return $this->_admRightToIssue;
    }

    /**
     * @return bool
     */
    public function getRecalled()
    {
        return $this->_recalled;
    }

    /**
     * @return string
     */
    public function getIssuanceDt()
    {
        return $this->_issuanceDt;
    }

    /**
     * @return int
     */
    public function getIssuanceDiff()
    {
        return $this->_issuanceDiff;
    }

    /**
     * @return string
     */
    public function getRegistrantNickname()
    {
        return $this->_registrantNickname;
    }

    /**
     * @return string
     */
    public function getRegistrantWmid()
    {
        return $this->_registrantWmid;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->_status;
    }

    /**
     * @return string
     */
    public function getNotary()
    {
        return $this->_notary;
    }
}
