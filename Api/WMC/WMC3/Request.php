<?php

namespace baibaratsky\WebMoney\Api\WMC\WMC3;

use baibaratsky\WebMoney\Api\WMC;
use baibaratsky\WebMoney\Exception\ApiException;
use baibaratsky\WebMoney\Request\RequestValidator;
use baibaratsky\WebMoney\Signer;
use DateTime;

/**
 * Class Request
 *
 * @link http://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_WMC3
 */
class Request extends WMC\Request
{
    /** @var DateTime datestart */
    protected $dateStart;

    /** @var DateTime dateend */
    protected $dateEnd;

    /** @var int wmtranid */
    protected $transactionId;

    /**
     * @param string $authType
     *
     * @throws ApiException
     */
    public function __construct($authType = self::AUTH_CLASSIC)
    {
        switch ($authType) {
            case self::AUTH_CLASSIC:
                $this->url = 'https://transfer.gdcert.com/ATM/Xml/History1.ashx';
                break;
            case self::AUTH_LIGHT:
                $this->url = 'https://transfer.gdcert.com/ATM/Xml/History1.ashx';
                break;
            default:
                throw new ApiException('This interface doesn\'t support the authentication type given.');
        }

        parent::__construct($authType);
    }

    /**
     * @return array
     */
    protected function getValidationRules()
    {
        return array(
            RequestValidator::TYPE_REQUIRED => array(
                'datestart', 'dateend', 'transactionId'
            )
        );
    }

    /**
     * @return string
     */
    public function getData()
    {
        $xml = '<w3s.request lang="' . $this->getLang() . '">';
        $xml .= self::xmlElement('wmid', $this->getSignerWmid());
        $xml .= '<sign type="' . $this->getAuthTypeNum() . '">' . $this->signature . '</sign>';
        $xml .= self::xmlElement('datestart', $this->getStartDateTime()->format('Ymd H:i:s'));
        $xml .= self::xmlElement('dateend', $this->getEndDateTime()->format('Ymd H:i:s'));
        $xml .= self::xmlElement('wmtranid', $this->getTransactionId());
        $xml .= '</w3s.request>';

        return $xml;
    }

    /**
     * @return string
     */
    public function getResponseClassName()
    {
        return Response::className();
    }
  
    /**
     * @param string $lightCertificate
     * @param string $lightKey
     */
    public function cert($lightCertificate, $lightKey) {
      if ($this->authType === self::AUTH_LIGHT) {
          $this->signature = base64_encode(
              $this->getSignerWmid() . $this->getStartDateTime()->format('Ymd H:i:s') .
              $this->getEndDateTime()->format('Ymd H:i:s') . $this->getTransactionId()
          );
      }
      parent::cert($lightCertificate, $lightKey);
    }

    /**
     * @param Signer $requestSigner
     */
    public function sign(Signer $requestSigner = null)
    {
        if ($this->authType === self::AUTH_CLASSIC) {
            $this->signature = $requestSigner->sign(
                $this->getSignerWmid() . $this->getStartDateTime()->format('Ymd H:i:s') .
                $this->getEndDateTime()->format('Ymd H:i:s') . $this->getTransactionId()
            );
        }
    }

    /**
     * @return int
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * @param int $id
     */
    public function setTransactionId($id)
    {
        $this->transactionId = (int)$id;
    }

    /**
     * @return DateTime
     */
    public function getStartDateTime()
    {
        return $this->dateStart;
    }

    /**
     * @param DateTime $date
     */
    public function setStartDateTime(DateTime $date)
    {
        $this->datestart = $date;
    }

    /**
     * @return DateTime
     */
    public function getEndDateTime()
    {
        return $this->dateEnd;
    }

    /**
     * @param DateTime $date
     */
    public function setEndDateTime(DateTime $date)
    {
        $this->dateend = $date;
    }
}
