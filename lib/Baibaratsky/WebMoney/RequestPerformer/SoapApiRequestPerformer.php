<?php
namespace Baibaratsky\WebMoney\RequestPerformer;

use Baibaratsky\WebMoney\Api\Capitaller\Payment\Request;
use Baibaratsky\WebMoney\Api\Request;
use Baibaratsky\WebMoney\Exception\RequestPerformerException;

/**
 * Class SoapApiRequestPerformer
 */
class SoapApiRequestPerformer extends ApiRequestPerformer
{
    /**
     * @param Request $request
     *
     * @return mixed
     * @throws RequestPerformerException
     */
    protected function _request(Request $request)
    {
        if (!$request instanceof Request) {
            throw new RequestPerformerException('This request performer doesn\'t support such type of request.');
        }

        /** @var \Baibaratsky\WebMoney\Api\Capitaller\Payment\Request $request */

        $client = new \SoapClient($request->getUrl(), array('encoding' => 'utf-8'));
        return $client->__soapCall($request->getFunctionName(), $request->getParams());
    }
}
