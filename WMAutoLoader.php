<?php

spl_autoload_register(array('WMAutoLoader', 'loadClassName'));

class WMAutoLoader
{
    protected static $directories = array('.', 'api');

    public static function loadClassName($className)
    {
        foreach (self::$directories as $directory) {
            if ($directory == '.') {
                $pathParts = array(__DIR__, $className);
            } else {
                $pathParts = array(__DIR__, $directory, $className);
            }

            $file = implode(DIRECTORY_SEPARATOR, $pathParts) . '.php';
            if (file_exists($file)) {
                require_once($file);
            }
        }
    }
}
