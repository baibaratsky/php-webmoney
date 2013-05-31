<?php

abstract class WMApiRequestPerformer
{
    /** @var  WMRequestSigner */
    protected $_requestSigner;

    public function perform(WMApiRequest $request)
    {
        $request->sign($this->_requestSigner);
        $response = $this->_request($request);
        $responseClassName = $request->getResponseClassName();

        return new $responseClassName($response);
    }

    abstract protected function _request(WMApiRequest $request);
}
