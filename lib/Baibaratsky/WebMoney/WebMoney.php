<?php
namespace Baibaratsky\WebMoney;

use Baibaratsky\WebMoney\Api\ApiRequest;
use Baibaratsky\WebMoney\Api\ApiResponse;
use Baibaratsky\WebMoney\Api\XmlApiRequest;
use Baibaratsky\WebMoney\Api\Capitaller\PaymentRequest;
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
     * @param ApiRequest $requestObject
     *
     * @return ApiResponse
     * @throws CoreException
     */
    public function request(ApiRequest $requestObject)
    {
        if (!$requestObject->validate()) {
            throw new CoreException('Incorrect request data. See getErrors().');
        }

        if ($requestObject instanceof XmlApiRequest) {
            return $this->_xmlRequestPerformer->perform($requestObject);
        } elseif ($requestObject instanceof PaymentRequest) {
            return $this->_soapRequestPerformer->perform($requestObject);
        }

        throw new CoreException('Wrong class of requestObject.');
    }
}
