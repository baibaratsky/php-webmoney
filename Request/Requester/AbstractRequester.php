<?php
namespace Baibaratsky\WebMoney\Request\Requester;

use Baibaratsky\WebMoney\Request\AbstractRequest;
use Baibaratsky\WebMoney\Request\Response;

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
