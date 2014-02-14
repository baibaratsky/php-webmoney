<?php
namespace baibaratsky\WebMoney\Api\X\X8;

class Wmid
{
    /** @var string wmid */
    private $wmid;

    /** @var bool wmid/@available */
    private $areIncomingOperationsForbidden;

    /** @var bool wmid/@themselfcorrstate */
    private $areNonCorrespondentsForbidden;

    /** @var int wmid/@newattst */
    private $passportType;

    /**
     * @param string $wmid
     * @param bool $areIncomingOperationsForbidden
     * @param bool $areNonCorrespondentsForbidden
     * @param int $passportType
     */
    public function __construct($wmid, $areIncomingOperationsForbidden, $areNonCorrespondentsForbidden, $passportType)
    {
        $this->wmid = $wmid;
        $this->areIncomingOperationsForbidden = $areIncomingOperationsForbidden;
        $this->areNonCorrespondentsForbidden = $areNonCorrespondentsForbidden;
        $this->passportType = $passportType;
    }

    /**
     * @return string
     */
    public function getWmid()
    {
        return $this->wmid;
    }

    /**
     * @return bool
     */
    public function getAreIncomingOperationsForbidden()
    {
        return $this->areIncomingOperationsForbidden;
    }

    /**
     * @return bool
     */
    public function getAreNonCorrespondentsForbidden()
    {
        return $this->areNonCorrespondentsForbidden;
    }

    /**
     * @return int
     */
    public function getPassportType()
    {
        return $this->passportType;
    }
}
