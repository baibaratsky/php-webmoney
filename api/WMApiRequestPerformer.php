<?php

abstract class WMApiRequestPerformer
{
    /**
     * @param WMApiRequest $request
     *
     * @return WMApiResponse
     */
    public function perform(WMApiRequest $request)
    {
        $response = $this->_request($request);
        $responseClassName = $request->getResponseClassName();

        return new $responseClassName($response);
    }

    /**
     * @param WMApiRequest $request
     *
     * @return mixed
     */
    abstract protected function _request(WMApiRequest $request);
}
