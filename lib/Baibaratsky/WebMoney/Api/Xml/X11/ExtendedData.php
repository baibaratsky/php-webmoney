<?php
namespace Baibaratsky\WebMoney\Api\Xml\X11;

class ExtendedData
{
    /** @var string type */
    private $_type;

    /** @var string account */
    private $_account;

    /** @var string check-lock */
    private $_checkLock;

    /**
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->_type = $params['type'];
        $this->_account = $params['account'];
        $this->_checkLock = $params['check-lock'];
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * @return string
     */
    public function getAccount()
    {
        return $this->_account;
    }

    /**
     * @return string
     */
    public function getCheckLock()
    {
        return $this->_checkLock;
    }
}
