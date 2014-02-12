<?php
namespace Baibaratsky\WebMoney\Api\X\X11;

class WebList
{
    /** @var string url */
    private $url;

    /** @var string check-lock */
    private $checkLock;

    /** @var bool ischeck */
    private $isCheck;

    /** @var bool islock */
    private $isLock;

    /**
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->url = $params['url'];
        $this->checkLock = $params['check-lock'];
        $this->isCheck = $params['ischeck'];
        $this->isLock = $params['islock'];
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getCheckLock()
    {
        return $this->checkLock;
    }

    /**
     * @return bool
     */
    public function getIsCheck()
    {
        return $this->isCheck;
    }

    /**
     * @return bool
     */
    public function getIsLock()
    {
        return $this->isLock;
    }
}
