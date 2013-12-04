<?php
namespace Baibaratsky\WebMoney\Api\Xml\X8;

class Wmid
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
