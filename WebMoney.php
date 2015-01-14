<?php

namespace baibaratsky\WebMoney;

use baibaratsky\WebMoney\Request\AbstractRequest;
use baibaratsky\WebMoney\Request\AbstractResponse;
use baibaratsky\WebMoney\Request\Requester\AbstractRequester;
use baibaratsky\WebMoney\Exception\CoreException;

/**
 * Class WebMoney
 *
 * @package baibaratsky\WebMoney
 */
class WebMoney
{
    /** @var array */
    static private $pathsToSertificate = ['key' => '', 'cer' => '', 'pass' => ''];

    /** @var AbstractRequester */
    private $xmlRequester;

    /**
     * @param AbstractRequester $xmlRequester
     */
    public function __construct(AbstractRequester $xmlRequester)
    {
        $this->xmlRequester = $xmlRequester;
    }

    /**
     * @param AbstractRequest $requestObject
     *
     * @return AbstractResponse
     * @throws CoreException
     */
    public function request(AbstractRequest $requestObject)
    {
        if (!$requestObject->validate()) {
            throw new CoreException('Incorrect request data. See getErrors().');
        }

        return $this->xmlRequester->perform($requestObject);
    }

    /**
     * @return array
     */
    public static function getPathsToSertificate()
    {
        return self::$pathsToSertificate;
    }

    /**
     * @param string $pathToKey
     * @param string $pathToCer
     * @param string $password
     *
     * @internal param array $pathsToSertificate
     */
    public static function setPathsToSertificate($pathToKey, $pathToCer, $password)
    {
        self::$pathsToSertificate = [
            'key'  => $pathToKey,
            'cer'  => $pathToCer,
            'pass' => $password
        ];
    }
}
