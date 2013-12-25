<?php
namespace Baibaratsky\WebMoney;

use Baibaratsky\WebMoney\Request;
use Baibaratsky\WebMoney\Request\Requester\AbstractRequester;
use Baibaratsky\WebMoney\Request\Requester\SoapRequester;
use Baibaratsky\WebMoney\Exception\CoreException;

class WebMoney
{
    /** @var AbstractRequester */
    private $xmlRequester;

    /** @var SoapRequester */
    private $soapRequester;

    /**
     * @param AbstractRequester $xmlRequester
     * @param SoapRequester $soapRequester
     */
    public function __construct(AbstractRequester $xmlRequester, SoapRequester $soapRequester = null)
    {
        $this->xmlRequester = $xmlRequester;
        if ($soapRequester !== null) {
            $this->soapRequester = $soapRequester;
        }
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

        if ($requestObject instanceof Request\XmlRequest) {
            return $this->xmlRequester->perform($requestObject);
        } elseif ($requestObject instanceof Request\AbstractRequest) {
            return $this->soapRequester->perform($requestObject);
        }

        throw new CoreException('Wrong class of requestObject.');
    }
}
