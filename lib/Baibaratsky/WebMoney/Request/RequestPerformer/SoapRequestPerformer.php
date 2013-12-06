<?php
namespace Baibaratsky\WebMoney\Request\RequestPerformer;

use Baibaratsky\WebMoney;
use Baibaratsky\WebMoney\Request\AbstractRequest;
use Baibaratsky\WebMoney\Exception\RequestPerformerException;

/**
 * Class SoapRequestPerformer
 */
class SoapRequestPerformer extends AbstractRequestPerformer
{
    /**
     * @param AbstractRequest $request
     *
     * @return mixed
     * @throws RequestPerformerException
     */
    protected function _request(AbstractRequest $request)
    {
        if (!$request instanceof WebMoney\Api\Capitaller\Payment\Request) {
            throw new RequestPerformerException('This request performer doesn\'t support such type of request.');
        }

        /** @var \Baibaratsky\WebMoney\Api\Capitaller\Payment\Request $request */

        $client = new \SoapClient($request->getUrl(), array('encoding' => 'utf-8'));
        return $client->__soapCall($request->getFunctionName(), $request->getParams());
    }
}
