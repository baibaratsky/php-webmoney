<?php

namespace baibaratsky\WebMoney\Api\X\X15;

class Trust
{
    /** @var int trust/@id */
    protected $id;

    /** @var boolean trust/@inv */
    protected $canIssueInvoice;

    /** @var boolean trust/@trans */
    protected $canMakeTransfer;

    /** @var boolean trust/@purse */
    protected $canCheckBalance;

    /** @var boolean trust/@transhist */
    protected $canViewHistory;

    /** @var string trust/master */
    protected $masterWmid;

    /** @var string trust/purse */
    protected $purse;

    /** @var string trust/daylimit */
    protected $_24hLimit;

    /** @var string trust/dlimit */
    protected $dayLimit;

    /** @var string trust/wlimit */
    protected $weekLimit;

    /** @var string trust/mlimit */
    protected $monthLimit;

    /** @var string trust/dsum */
    protected $daySum;

    /** @var string trust/wsum */
    protected $weekSum;

    /** @var string trust/msum */
    protected $monthSum;

    /** @var string trust/lastsumdate */
    protected $lastOperationDate;

    /** @var string trust/storeswmid */
    protected $payeeWmid;

    public function __construct(array $params)
    {
        $this->id = $params['id'];
        $this->canIssueInvoice = $params['canIssueInvoice'];
        $this->canMakeTransfer = $params['canMakeTransfer'];
        $this->canCheckBalance = $params['canCheckBalance'];
        $this->canViewHistory = $params['canViewHistory'];
        $this->masterWmid = $params['masterWmid'];
        $this->purse = $params['purse'];
        $this->_24hLimit = $params['24hLimit'];
        $this->dayLimit = $params['dayLimit'];
        $this->weekLimit = $params['weekLimit'];
        $this->monthLimit = $params['monthLimit'];
        $this->daySum = $params['daySum'];
        $this->weekSum = $params['weekSum'];
        $this->monthSum = $params['monthSum'];
        $this->lastOperationDate = $params['lastOperationDate'];
        $this->payeeWmid = $params['payeeWmid'];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCanIssueInvoice()
    {
        return $this->canIssueInvoice;
    }

    public function getCanMakeTransfer()
    {
        return $this->canMakeTransfer;
    }

    public function getCanCheckBalance()
    {
        return $this->canCheckBalance;
    }

    public function getCanViewHistory()
    {
        return $this->canViewHistory;
    }

    public function getPurse()
    {
        return $this->purse;
    }

    public function get24hLimit()
    {
        return $this->_24hLimit;
    }

    public function getDayLimit()
    {
        return $this->dayLimit;
    }

    public function getWeekLimit()
    {
        return $this->weekLimit;
    }

    public function getMonthLimit()
    {
        return $this->monthLimit;
    }

    public function getDaySum()
    {
        return $this->daySum;
    }

    public function getWeekSum()
    {
        return $this->weekSum;
    }

    public function getMonthSum()
    {
        return $this->monthSum;
    }

    public function getLastOperationDate()
    {
        return $this->lastOperationDate;
    }

    public function getPayeeWmid()
    {
        return $this->payeeWmid;
    }
}
