<?php
namespace Baibaratsky\WebMoney\Request\Requester;

use Baibaratsky\WebMoney;
use Baibaratsky\WebMoney\Request\AbstractRequest;
use Baibaratsky\WebMoney\Exception\RequesterException;

/**
 * Class SoapRequester
 */
class SoapRequester extends AbstractRequester
{
    /**
     * @param AbstractRequest $request
     *
     * @return mixed
     * @throws RequesterException
     */
    protected function request(AbstractRequest $request)
    {
        if (!$request instanceof WebMoney\Api\Capitaller\Payment\Request) {
            throw new RequesterException('This requester doesn\'t support such type of request.');
        }

        /** @var \Baibaratsky\WebMoney\Api\Capitaller\Payment\Request $request */

        $client = new \SoapClient($request->getUrl(), array('encoding' => 'utf-8'));
        return $client->__soapCall($request->getFunctionName(), $request->getParams());
    }
}
