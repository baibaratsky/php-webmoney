<?php
namespace Baibaratsky\WebMoney\Api\Xml\X8;

class Purse
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
