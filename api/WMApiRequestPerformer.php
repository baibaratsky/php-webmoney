<?php

abstract class WMApiRequestPerformer
{
    /** @var  WMRequestSigner */
    protected $_requestSigner;

    /**
     * @param WMRequestSigner $requestSigner
     */
    public function __construct(WMRequestSigner $requestSigner)
    {
        $this->_requestSigner = $requestSigner;
    }

    /**
     * @param WMXmlApiRequest $request
     *
     * @return WMApiResponse
     */
    public function perform(WMXmlApiRequest $request)
    {
        $request->sign($this->_requestSigner);
        $response = $this->_request($request);
        $responseClassName = $request->getResponseClassName();

        return new $responseClassName($response);
    }

    /**
     * @param WMXmlApiRequest $request
     *
     * @return mixed
     */
    abstract protected function _request(WMXmlApiRequest $request);
}
