<?php

namespace baibaratsky\WebMoney\Api\X\X15\Get;

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

	/** @var string trust/purse */
	protected $purse;

	/** @var string trust/daylimit */
	protected $limit24h;

	/** @var string trust/dlimit */
	protected $limitDay;

	/** @var string trust/wlimit */
	protected $limitWeek;

	/** @var string trust/mlimit */
	protected $limitMonth;

	/** @var string trust/dsum */
	protected $sumDay;

	/** @var string trust/wsum */
	protected $sumWeek;

	/** @var string trust/msum */
	protected $sumMonth;

	/** @var string trust/lastsumdate */
	protected $lastOperationDateTime;

	/** @var string trust/storeswmid */
	protected $payeeWmid;

	public function __construct(array $params)
	{
		$this->id = $params['id'];
		$this->canIssueInvoice = $params['canIssueInvoice'];
		$this->canMakeTransfer = $params['canMakeTransfer'];
		$this->canCheckBalance = $params['canCheckBalance'];
		$this->canViewHistory = $params['canViewHistory'];
		$this->purse = $params['purse'];
		$this->limit24h = $params['limit24h'];
		$this->limitDay = $params['limitDay'];
		$this->limitWeek = $params['limitWeek'];
		$this->limitMonth = $params['limitMonth'];
		$this->sumDay = $params['sumDay'];
		$this->sumWeek = $params['sumWeek'];
		$this->sumMonth = $params['sumMonth'];
		$this->lastOperationDateTime = $params['lastOperationDateTime'];
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

	public function getLimit24h()
	{
		return $this->limit24h;
	}

	public function getLimitDay()
	{
		return $this->limitDay;
	}

	public function getLimitWeek()
	{
		return $this->limitWeek;
	}

	public function getLimitMonth()
	{
		return $this->limitMonth;
	}

	public function getSumDay()
	{
		return $this->sumDay;
	}

	public function getSumWeek()
	{
		return $this->sumWeek;
	}

	public function getSumMonth()
	{
		return $this->sumMonth;
	}

	public function getLastOperationDateTime()
	{
		return $this->lastOperationDateTime;
	}

    public function getPayeeWmid()
    {
        return $this->payeeWmid;
    }
}
