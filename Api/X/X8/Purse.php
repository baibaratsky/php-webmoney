<?php
namespace baibaratsky\WebMoney\Api\X\X8;

class Purse
{
    /** @var string purse */
    private $purse;

    /** @var bool purse/@merchant_active_mode */
    private $isMerchantActive;

    /** @var bool purse/@merchant_allow_cashier */
    private $isCashierAllowed;

    /**
     * @param string $purse
     * @param bool $isMerchantActive
     * @param bool $isCashierAllowed
     */
    public function __construct($purse, $isMerchantActive, $isCashierAllowed)
    {
        $this->purse = $purse;
        $this->isMerchantActive = $isMerchantActive;
        $this->isCashierAllowed = $isCashierAllowed;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->purse;
    }

    /**
     * @return bool
     */
    public function getIsMerchantActive()
    {
        return $this->isMerchantActive;
    }

    /**
     * @return bool
     */
    public function getIsCashierAllowed()
    {
        return $this->isCashierAllowed;
    }
}
