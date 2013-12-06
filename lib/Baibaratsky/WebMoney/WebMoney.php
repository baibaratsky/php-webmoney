<?php
namespace Baibaratsky\WebMoney;

use Baibaratsky\WebMoney\Api\Request;
use Baibaratsky\WebMoney\Api\Response;
use Baibaratsky\WebMoney\Api\XmlRequest;
use Baibaratsky\WebMoney\Exception\CoreException;
use Baibaratsky\WebMoney\RequestPerformer\ApiRequestPerformer;
use Baibaratsky\WebMoney\RequestPerformer\SoapApiRequestPerformer;

class WebMoney
{
    /** @var ApiRequestPerformer */
    private $_xmlRequestPerformer;

    /** @var SoapApiRequestPerformer */
    private $_soapRequestPerformer;

    /**
     * @param ApiRequestPerformer $xmlRequestPerformer
     * @param SoapApiRequestPerformer $soapRequestPerformer
     */
    public function __construct(ApiRequestPerformer $xmlRequestPerformer, SoapApiRequestPerformer $soapRequestPerformer = null)
    {
        $this->_xmlRequestPerformer = $xmlRequestPerformer;
        if ($soapRequestPerformer !== null) {
            $this->_soapRequestPerformer = $soapRequestPerformer;
        }
    }

    /**
     * @param Request $requestObject
     *
     * @return Response
     * @throws CoreException
     */
    public function request(Request $requestObject)
    {
        if (!$requestObject->validate()) {
            throw new CoreException('Incorrect request data. See getErrors().');
        }

        if ($requestObject instanceof XmlRequest) {
            return $this->_xmlRequestPerformer->perform($requestObject);
        } elseif ($requestObject instanceof Request) {
            return $this->_soapRequestPerformer->perform($requestObject);
        }

        throw new CoreException('Wrong class of requestObject.');
    }
}
