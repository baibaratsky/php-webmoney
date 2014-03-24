<?php

namespace baibaratsky\WebMoney\Request\Requester;

use baibaratsky\WebMoney\Request\AbstractRequest;
use baibaratsky\WebMoney\Request\Response;

abstract class AbstractRequester
{
    /**
     * @param AbstractRequest $request
     *
     * @return Response
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
