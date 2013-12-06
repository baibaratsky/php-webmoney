<?php
namespace Baibaratsky\WebMoney\Request\RequestPerformer;

use Baibaratsky\WebMoney\Request\AbstractRequest;
use Baibaratsky\WebMoney\Request\Response;

abstract class AbstractRequestPerformer
{
    /**
     * @param AbstractRequest $request
     *
     * @return Response
     */
    public function perform(AbstractRequest $request)
    {
        $response = $this->_request($request);
        $responseClassName = $request->getResponseClassName();

        return new $responseClassName($response);
    }

    /**
     * @param \Baibaratsky\WebMoney\Request\AbstractRequest $request
     *
     * @return mixed
     */
    abstract protected function _request(AbstractRequest $request);
}
