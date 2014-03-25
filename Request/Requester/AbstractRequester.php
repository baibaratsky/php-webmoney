<?php

namespace baibaratsky\WebMoney\Request\Requester;

use baibaratsky\WebMoney\Request\AbstractRequest;
use baibaratsky\WebMoney\Request\AbstractResponse;

abstract class AbstractRequester
{
    /**
     * @param AbstractRequest $request
     *
     * @return AbstractResponse
     */
    public function perform(AbstractRequest $request)
    {
        $response = $this->request($request);
        $responseClassName = $request->getResponseClassName();

        return new $responseClassName($response);
    }

    /**
     * @param AbstractRequest $request
     *
     * @return mixed
     */
    abstract protected function request(AbstractRequest $request);
}
