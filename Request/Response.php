<?php
namespace baibaratsky\WebMoney\Request;

abstract class Response
{
    /** @var \DateTimeZone */
    private static $timeZone;

    /** @var int retval */
    protected $returnCode;

    /**
     * @param string $response
     */
    abstract public function __construct($response);

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
}
