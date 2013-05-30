<?php

spl_autoload_register(array('WebMoney', 'loadClass'));

class WebMoney
{
    protected static $_directories = array('api');

    private $_requestPerformer;

    public function __construct(WMApiRequestPerformer $requestPerformer)
    {
        $this->_requestPerformer = $requestPerformer;
    }

    public function request(WMApiRequest $requestObject)
    {
        return $this->_requestPerformer->perform($requestObject);
    }

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
