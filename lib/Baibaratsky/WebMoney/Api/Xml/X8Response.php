<?php
namespace Baibaratsky\WebMoney\Api\Xml;

use Baibaratsky\WebMoney\Api\ApiResponse;

/**
 * Class X8Response
 *
 * @link https://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X8
 */
class X8Response extends ApiResponse
{
    /** @var int retval */
    protected $_returnCode;

    /** @var string retdesc */
    protected $_returnDescription;

    /** @var X8ResponseWmid testwmpurse/wmid */
    protected $_wmid;

    /** @var X8ResponsePurse testwmpurse/purse */
    protected $_purse;

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        $responseObject = new \SimpleXMLElement($response);
        $this->_returnCode = (int)$responseObject->retval;
        $this->_returnDescription = (string)$responseObject->retdesc;
        if (!empty($responseObject->testwmpurse->wmid)) {
            $this->_wmid = new X8ResponseWmid(
                (string)$responseObject->testwmpurse->wmid,
                (int)$responseObject->testwmpurse->wmid['available'] > 0 ?
                        (bool)$responseObject->testwmpurse->wmid['available'] : null,
                (int)$responseObject->testwmpurse->wmid['themselfcorrstate'] > 0 ?
                        (int)$responseObject->testwmpurse->wmid['themselfcorrstate'] >= 8 : null,
                (int)$responseObject->testwmpurse->wmid['newattst'] > 0 ?
                        (int)$responseObject->testwmpurse->wmid['newattst'] : null
            );
        }
        if (!empty($responseObject->testwmpurse->purse)) {
            $this->_purse = new X8ResponsePurse(
                (string)$responseObject->testwmpurse->purse,
                (int)$responseObject->testwmpurse->purse['merchant_active_mode'] > 0 ?
                        (bool)$responseObject->testwmpurse->purse['merchant_active_mode'] : null,
                (int)$responseObject->testwmpurse->purse['merchant_allow_cashier'] > 0 ?
                        (bool)$responseObject->testwmpurse->purse['merchant_allow_cashier'] : null
            );
        }
    }
}

class X8ResponseWmid
{
    /** @var string wmid */
    private $_wmid;

    /** @var bool wmid/@available */
    private $_areIncomingOperationsForbidden;

    /** @var bool wmid/@themselfcorrstate */
    private $_areNonCorrespondentsForbidden;

    /** @var int wmid/@newattst */
    private $_passportType;

    /**
     * @param string $wmid
     * @param bool $areIncomingOperationsForbidden
     * @param bool $areNonCorrespondentsForbidden
     * @param int $passportType
     */
    public function __construct($wmid, $areIncomingOperationsForbidden, $areNonCorrespondentsForbidden, $passportType)
    {
        $this->_wmid = $wmid;
        $this->_areIncomingOperationsForbidden = $areIncomingOperationsForbidden;
        $this->_areNonCorrespondentsForbidden = $areNonCorrespondentsForbidden;
        $this->_passportType = $passportType;
    }

    /**
     * @return string
     */
    public function getWmid()
    {
        return $this->_wmid;
    }

    /**
     * @return bool
     */
    public function getAreIncomingOperationsForbidden()
    {
        return $this->_areIncomingOperationsForbidden;
    }

    /**
     * @return bool
     */
    public function getAreNonCorrespondentsForbidden()
    {
        return $this->_areNonCorrespondentsForbidden;
    }

    /**
     * @return int
     */
    public function getPassportType()
    {
        return $this->_passportType;
    }
}

class X8ResponsePurse
{
    /** @var string purse */
    private $_purse;

    /** @var bool purse/@merchant_active_mode */
    private $_isMerchantActive;

    /** @var bool purse/@merchant_allow_cashier */
    private $_isCashierAllowed;

    /**
     * @param string $purse
     * @param bool $isMerchantActive
     * @param bool $isCashierAllowed
     */
    public function __construct($purse, $isMerchantActive, $isCashierAllowed)
    {
        $this->_purse = $purse;
        $this->_isMerchantActive = $isMerchantActive;
        $this->_isCashierAllowed = $isCashierAllowed;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->_purse;
    }

    /**
     * @return bool
     */
    public function getIsMerchantActive()
    {
        return $this->_isMerchantActive;
    }

    /**
     * @return bool
     */
    public function getIsCashierAllowed()
    {
        return $this->_isCashierAllowed;
    }
}