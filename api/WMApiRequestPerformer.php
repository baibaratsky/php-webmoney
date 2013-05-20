<?php

abstract class WMApiRequestPerformer
{
    public function perform(WMApiRequest $request)
    {
        $response = $this->_request($request);
        $responseClassName = $request->getResponseClassName();
        return new $responseClassName($response);
    }

    abstract protected function _request(WMApiRequest $request);
}
