<?php
namespace Baibaratsky\WebMoney\RequestPerformer;

use Baibaratsky\WebMoney\Api\Capitaller\PaymentRequest;
use Baibaratsky\WebMoney\Api\ApiRequest;
use Baibaratsky\WebMoney\Exception\RequestPerformerException;

/**
 * Class SoapApiRequestPerformer
 */
class SoapApiRequestPerformer extends ApiRequestPerformer
{
    /**
     * @param ApiRequest $request
     *
     * @return mixed
     * @throws RequestPerformerException
     */
    protected function _request(ApiRequest $request)
    {
        if (!$request instanceof PaymentRequest) {
            throw new RequestPerformerException('This request performer doesn\'t support such type of request.');
        }

        /** @var PaymentRequest $request */

        $client = new \SoapClient($request->getUrl(), array('encoding' => 'utf-8'));
        return $client->__soapCall($request->getFunctionName(), $request->getParams());
    }
}
