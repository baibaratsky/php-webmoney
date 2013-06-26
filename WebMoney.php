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
     * @param WMXmlApiRequest $requestObject
     * @param WMApiRequestPerformer $requestPerformer
     * @return WMApiResponse
     */
    public function request(WMXmlApiRequest $requestObject, WMApiRequestPerformer $requestPerformer = null)
    {
        if ($requestPerformer === null) {
            if (get_class($requestObject) === 'WMCapitallerPaymentRequest') {
                $requestPerformerReflection = new ReflectionObject($this->_requestPerformer);
                $requestSignerProperty = $requestPerformerReflection->getProperty('_requestSigner');
                $requestSignerProperty->setAccessible(true);
                $requestPerformer = new WMSoapApiRequestPerformer(
                    $requestSignerProperty->getValue($this->_requestPerformer)
                );
            } else {
                $requestPerformer = $this->_requestPerformer;
            }
        }
        return $requestPerformer->perform($requestObject);
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
