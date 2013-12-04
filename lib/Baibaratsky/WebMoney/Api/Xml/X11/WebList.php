<?php
namespace Baibaratsky\WebMoney\Api\Xml\X11;

class WebList
{
    /** @var string url */
    private $_url;

    /** @var string check-lock */
    private $_checkLock;

    /** @var bool ischeck */
    private $_isCheck;

    /** @var bool islock */
    private $_isLock;

    /**
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->_url = $params['url'];
        $this->_checkLock = $params['check-lock'];
        $this->_isCheck = $params['ischeck'];
        $this->_isLock = $params['islock'];
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->_url;
    }

    /**
     * @return string
     */
    public function getCheckLock()
    {
        return $this->_checkLock;
    }

    /**
     * @return bool
     */
    public function getIsCheck()
    {
        return $this->_isCheck;
    }

    /**
     * @return bool
     */
    public function getIsLock()
    {
        return $this->_isLock;
    }
}
