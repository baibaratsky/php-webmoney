<?php

namespace baibaratsky\WebMoney;

use baibaratsky\WebMoney\Request;
use baibaratsky\WebMoney\Request\Requester\AbstractRequester;
use baibaratsky\WebMoney\Exception\CoreException;

class WebMoney
{
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
     * @param Request\AbstractRequest $requestObject
     *
     * @return Request\Response
     * @throws CoreException
     */
    public function request(Request\AbstractRequest $requestObject)
    {
        if (!$requestObject->validate()) {
            throw new CoreException('Incorrect request data. See getErrors().');
        }

        return $this->xmlRequester->perform($requestObject);
    }
}
