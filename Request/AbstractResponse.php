<?php

namespace baibaratsky\WebMoney\Request;

abstract class AbstractResponse
{
    /** @var \DateTimeZone */
    private static $timeZone;

    /** @var int retval */
    protected $returnCode;

    /** @var string retdesc */
    protected $returnDescription;

    /**
     * @param string $response
     */
    abstract public function __construct($response);

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
}
