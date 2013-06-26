<?php

abstract class WMApiResponse
{
    /** @var DateTimeZone */
    private static $_timeZone;

    /** @var int retval (SendWMResult for Capitaller) */
    protected $_returnCode;

    /**
     * @param string $response
     */
    abstract public function __construct($response);

    /**
     * Creates DateTime object from ISO 8601 string
     * @param string $dateTimeString
     * @return DateTime
     */
    protected static function _createDateTime($dateTimeString)
    {
        return new DateTime($dateTimeString, self::_getTimeZone());
    }

    /**
     * Returns WebMoney API timezone as DateTimeZone object
     * @return DateTimeZone
     */
    protected static function _getTimeZone()
    {
        if (self::$_timeZone === null) {
            self::$_timeZone = new DateTimeZone('Europe/Moscow');
        }
        return self::$_timeZone;
    }

    /**
     * @return int
     */
    public function getReturnCode()
    {
        return $this->_returnCode;
    }
}
