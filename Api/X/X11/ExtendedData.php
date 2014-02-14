<?php
namespace baibaratsky\WebMoney\Api\X\X11;

class ExtendedData
{
    /** @var string type */
    private $type;

    /** @var string account */
    private $account;

    /** @var string check-lock */
    private $checkLock;

    /**
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->type = $params['type'];
        $this->account = $params['account'];
        $this->checkLock = $params['check-lock'];
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @return string
     */
    public function getCheckLock()
    {
        return $this->checkLock;
    }
}
