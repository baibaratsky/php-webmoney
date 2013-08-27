<?php

spl_autoload_register(array('WebMoney', 'loadClass'));

class WebMoney
{
    /** @var array */
    protected static $_directories = array('api');

    /** @var WMApiRequestPerformer */
    private $_xmlRequestPerformer;

    /** @var WMSoapApiRequestPerformer */
    private $_soapRequestPerformer;

    /**
     * @param WMApiRequestPerformer $xmlRequestPerformer
     * @param WMSoapApiRequestPerformer $soapRequestPerformer
     */
    public function __construct(WMApiRequestPerformer $xmlRequestPerformer, WMSoapApiRequestPerformer $soapRequestPerformer = null)
    {
        $this->_xmlRequestPerformer = $xmlRequestPerformer;
        if ($soapRequestPerformer !== null) {
            $this->_soapRequestPerformer = $soapRequestPerformer;
        }
    }

    /**
     * @param WMApiRequest $requestObject
     *
     * @return WMApiResponse
     * @throws WMException
     */
    public function request(WMApiRequest $requestObject)
    {
        if ($requestObject instanceof WMXmlApiRequest) {
            return $this->_xmlRequestPerformer->perform($requestObject);
        } elseif ($requestObject instanceof WMCapitallerPaymentRequest) {
            return $this->_soapRequestPerformer->perform($requestObject);
        }

        throw new WMException('Wrong class of requestObject.');
    }

    /**
     * @param string $className
     */
    public static function loadClass($className)
    {
        foreach (self::$_directories as $directory) {
            $file = implode(DIRECTORY_SEPARATOR, array(__DIR__, $directory, $className)) . '.php';
            if (is_readable($file)) {
                require_once($file);
            }
        }
    }
}
