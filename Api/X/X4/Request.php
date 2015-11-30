<?php

namespace app\components\wm\Api\X\X4;

use baibaratsky\WebMoney\Api\X;
use baibaratsky\WebMoney\Signer;
use baibaratsky\WebMoney\Request\RequestValidator;
use baibaratsky\WebMoney\Exception\ApiException;

/**
 * Class Request
 *
 * @link https://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X4
 */
class Request extends X\Request
{
	/** @var string wmid */
	protected $signerWmid;

	/** @var string getpurses/wmid */
	protected $requestedWmid;

    /** @var string getoperations\purse */
    protected $purse;

    /** @var  string getoutinvoices\wminvid */
    protected $invoiceId;

    /** @var \DateTime getoperations\datestart */
    protected $startDateTime;

    /** @var \DateTime getoperations\datefinish */
    protected $endDateTime;

	public function __construct($authType = self::AUTH_CLASSIC)
	{
		if ($authType === self::AUTH_CLASSIC) {
			$this->url = 'https://w3s.webmoney.ru/asp/XMLOutInvoices.asp';
		} else {
			throw new ApiException('This interface doesn\'t support the authentication type given.');
		}

		parent::__construct($authType);
	}

	/**
	 * @return string
	 */
	public function getResponseClassName()
	{
		return Response::className();
	}

	/**
	 * @param Signer $requestSigner
	 *
	 */
	public function sign(Signer $requestSigner = null)
	{
		if ($this->authType === self::AUTH_CLASSIC) {
			$this->signature = $requestSigner->sign($this->purse . $this->requestNumber);
		}
	}

	/**
	 * @return array
	 */
	protected function getValidationRules()
	{
        return array(
            RequestValidator::TYPE_REQUIRED => array('purse', 'startDateTime', 'endDateTime'),
            RequestValidator::TYPE_DEPEND_REQUIRED => array(
                'signerWmid' => array('authType' => array(self::AUTH_CLASSIC)),
            ),
        );
	}

	/**
	 * @return string
	 */
	public function getData()
	{
		$xml = '<w3s.request>';
		$xml .= self::xmlElement('reqn', $this->requestNumber);
		$xml .= self::xmlElement('wmid', $this->signerWmid);
		$xml .= self::xmlElement('sign', $this->signature);
		$xml .= '<getoutinvoices>';
		$xml .= self::xmlElement('purse', $this->purse);
		$xml .= self::xmlElement('wminvid', $this->invoiceId);
		$xml .= self::xmlElement('datestart', $this->startDateTime->format('Ymd H:i:s'));
		$xml .= self::xmlElement('datefinish', $this->endDateTime->format('Ymd H:i:s'));
		$xml .= '</getoutinvoices>';
		$xml .= '</w3s.request>';

		return $xml;
	}

	/**
	 * @return string
	 */
	public function getSignerWmid()
	{
		return $this->signerWmid;
	}

	/**
	 * @param string $signerWmid
	 */
	public function setSignerWmid($signerWmid)
	{
		$this->signerWmid = $signerWmid;
	}

	/**
	 * @return string
	 */
	public function getRequestedWmid()
	{
		return $this->requestedWmid;
	}

	/**
	 * @param string $requestedWmid
	 */
	public function setRequestedWmid($requestedWmid)
	{
		$this->requestedWmid = $requestedWmid;
	}

    /**
     * @param $purse
     */
    public function setPurse($purse)
    {
        $this->purse = $purse;
    }

    /**
     * @return string
     */
    public function getPurse()
    {
        return $this->purse;
    }

    /**
     * @param \DateTime $startDateTime
     */
    public function setStartDateTime($startDateTime)
    {
        $this->startDateTime = $startDateTime;
    }

    /**
     * @return \DateTime
     */
    public function getStartDateTime()
    {
        return $this->startDateTime;
    }

    /**
     * @param \DateTime $endDateTime
     */
    public function setEndDateTime($endDateTime)
    {
        $this->endDateTime = $endDateTime;
    }

    /**
     * @return \DateTime
     */
    public function getEndDateTime()
    {
        return $this->endDateTime;
    }

    /**
     * @param int $invoiceId
     */
    public function setInvoiceId($invoiceId)
    {
        $this->invoiceId = $invoiceId;
    }

    /**
     * @return int
     */
    public function getInvoiceId()
    {
        return $this->invoiceId;
    }
}
