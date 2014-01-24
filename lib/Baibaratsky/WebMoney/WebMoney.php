<?php
namespace Baibaratsky\WebMoney;

use Baibaratsky\WebMoney\Request;
use Baibaratsky\WebMoney\Request\Requester\AbstractRequester;
use Baibaratsky\WebMoney\Exception\CoreException;

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
