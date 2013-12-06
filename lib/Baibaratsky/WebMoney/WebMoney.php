<?php
namespace Baibaratsky\WebMoney;

use Baibaratsky\WebMoney\Request;
use Baibaratsky\WebMoney\Request\RequestPerformer\AbstractRequestPerformer;
use Baibaratsky\WebMoney\Request\RequestPerformer\SoapRequestPerformer;
use Baibaratsky\WebMoney\Exception\CoreException;

class WebMoney
{
    /** @var AbstractRequestPerformer */
    private $_xmlRequestPerformer;

    /** @var SoapRequestPerformer */
    private $_soapRequestPerformer;

    /**
     * @param AbstractRequestPerformer $xmlRequestPerformer
     * @param SoapRequestPerformer $soapRequestPerformer
     */
    public function __construct(AbstractRequestPerformer $xmlRequestPerformer, SoapRequestPerformer $soapRequestPerformer = null)
    {
        $this->_xmlRequestPerformer = $xmlRequestPerformer;
        if ($soapRequestPerformer !== null) {
            $this->_soapRequestPerformer = $soapRequestPerformer;
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
            return $this->_xmlRequestPerformer->perform($requestObject);
        } elseif ($requestObject instanceof Request\AbstractRequest) {
            return $this->_soapRequestPerformer->perform($requestObject);
        }

        throw new CoreException('Wrong class of requestObject.');
    }
}
