<?php

spl_autoload_register(array('WebMoney', 'loadClassName'));

class WebMoney
{
    protected static $directories = array('api');

    private $_requestPerformer;

    public function __construct(WMApiRequestPerformer $requestPerformer)
    {
        $this->_requestPerformer = $requestPerformer;
    }

    public function request(WMApiRequest $requestObject)
    {
        return $this->_requestPerformer->perform($requestObject);
    }

    public static function loadClassName($className)
    {
        foreach (self::$directories as $directory) {
            $file = implode(DIRECTORY_SEPARATOR, array(__DIR__, $directory, $className)) . '.php';
            if (file_exists($file)) {
                require_once($file);
            }
        }
    }
}
