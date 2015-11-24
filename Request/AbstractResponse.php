<?php

namespace baibaratsky\WebMoney\Request;

abstract class AbstractResponse
{
    /** @var string Raw response data from WM */
    protected $rawData;

    /** @var int retval */
    protected $returnCode;

    /** @var string retdesc */
    protected $returnDescription;

    /** @var \DateTimeZone */
    private static $timeZone;

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        $this->rawData = $response;
    }

    /**
     * @return string Fully qualified name of the class
     */
    public static function className()
    {
        return get_called_class();
    }

    /**
     * Creates DateTime object from ISO 8601 string
     * @param string $dateTimeString
     * @return \DateTime
     */
    protected static function createDateTime($dateTimeString)
    {
        return new \DateTime($dateTimeString, self::getTimeZone());
    }

    /**
     * Returns WebMoney API timezone as DateTimeZone object
     * @return \DateTimeZone
     */
    protected static function getTimeZone()
    {
        if (self::$timeZone === null) {
            self::$timeZone = new \DateTimeZone('Europe/Moscow');
        }
        return self::$timeZone;
    }

    /**
     * @return int
     */
    public function getReturnCode()
    {
        return $this->returnCode;
    }

    /**
     * @return string
     */
    public function getReturnDescription()
    {
        return $this->returnDescription;
    }

    /**
     * @return string
     */
    public function getRawData()
    {
        return $this->rawData;
    }
}
