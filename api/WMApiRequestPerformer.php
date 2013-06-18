<?php

abstract class WMApiRequestPerformer
{
    /** @var  WMRequestSigner */
    protected $_requestSigner;

    /**
     * @param WMApiRequest $request
     *
     * @return WMApiResponse
     */
    public function perform(WMApiRequest $request)
    {
        $request->sign($this->_requestSigner);
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
