<?php

namespace baibaratsky\WebMoney\Api\X\X15;

class Trust
{
	/** @var int trust/@id */
	protected $id;

	/** @var boolean trust/@inv */
	protected $canInvoice;

	/** @var boolean trust/@trans */
	protected $canTransfer;

	/** @var boolean trust/@purse */
	protected $canViewBalance;

	/** @var boolean trust/@transhist */
	protected $canViewHistory;

	/** @var string trust/purse */
	protected $purse;

	/** @var string trust/daylimit */
	protected $daylimit;

	/** @var string trust/dlimit */
	protected $dlimit;

	/** @var string trust/wlimit */
	protected $wlimit;

	/** @var string trust/mlimit */
	protected $mlimit;

	/** @var string trust/dsum */
	protected $dsum;

	/** @var string trust/wsum */
	protected $wsum;

	/** @var string trust/msum */
	protected $msum;

	/** @var string trust/lastsumdate */
	protected $lastsumdate;

	/** @var string trust/storeswmid */
	protected $storeswmid;

	public function __construct(array $params)
	{
		$this->id = $params['id'];
		$this->canInvoice = $params['canInvoice'];
		$this->canTransfer = $params['canTransfer'];
		$this->canViewBalance = $params['canViewBalance'];
		$this->canViewHistory = $params['canViewHistory'];
		$this->purse = $params['purse'];
		$this->daylimit = $params['daylimit'];
		$this->dlimit = $params['dlimit'];
		$this->wlimit = $params['wlimit'];
		$this->mlimit = $params['mlimit'];
		$this->dsum = $params['dsum'];
		$this->wsum = $params['wsum'];
		$this->msum = $params['msum'];
		$this->lastsumdate = $params['lastsumdate'];
		$this->storeswmid = $params['storeswmid'];
	}

	public function getId()
	{
		return $this->id;
	}

	public function getCanInvoice()
	{
		return $this->canInvoice;
	}

	public function getCanTransfer()
	{
		return $this->canTransfer;
	}

	public function getCanViewHistory()
	{
		return $this->canViewHistory;
	}

	public function getCanViewBalance()
	{
		return $this->canViewBalance;
	}

	public function getPurse()
	{
		return $this->purse;
	}

	public function getDayLimit()
	{
		return $this->daylimit;
	}

	public function getDlimit()
	{
		return $this->dlimit;
	}

	public function getWeekLimit()
	{
		return $this->wlimit;
	}

	public function getMonthLimit()
	{
		return $this->mlimit;
	}

	public function getDaySum()
	{
		return $this->dsum;
	}

	public function getWeekSum()
	{
		return $this->wsum;
	}

	public function getMonthSum()
	{
		return $this->msum;
	}

	public function getLastSumDate()
	{
		return $this->lastsumdate;
	}

    public function getStoresWmid()
    {
        return $this->storeswmid;
    }
}
