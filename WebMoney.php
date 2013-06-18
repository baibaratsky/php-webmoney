<?php

spl_autoload_register(array('WebMoney', 'loadClass'));

class WebMoney
{
    /** @var array */
    protected static $_directories = array('api');

    /** @var WMApiRequestPerformer */
    private $_requestPerformer;

    /**
     * @param WMApiRequestPerformer $requestPerformer
     */
    public function __construct(WMApiRequestPerformer $requestPerformer)
    {
        $this->_requestPerformer = $requestPerformer;
    }

    /**
     * @param WMApiRequest $requestObject
     *
     * @return WMApiResponse
     */
    public function request(WMApiRequest $requestObject)
    {
        return $this->_requestPerformer->perform($requestObject);
    }

    /**
     * @param string $className
     */
    public static function loadClass($className)
    {
        foreach (self::$_directories as $directory) {
            $file = implode(DIRECTORY_SEPARATOR, array(__DIR__, $directory, $className)) . '.php';
            if (file_exists($file)) {
                require_once($file);
            }
        }
    }
}
