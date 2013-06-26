<?php

class WMSoapApiRequestPerformer extends WMApiRequestPerformer
{
    /**
     * @param WMApiRequest $request
     * @return array
     * @throws WMException
     */
    protected function _request(WMApiRequest $request)
    {
        if (!is_subclass_of($request, 'WMCapitallerPaymentRequest')) {
            throw new WMException('This request performer doesn\'t support such type of request.');
        }

        /** @var WMCapitallerPaymentRequest $request */

        $client = new SoapClient($request->getUrl(), array('encoding' => 'utf-8'));
        return $client->__soapCall($request->getFunctionName(), $request->getParams());
    }
}
