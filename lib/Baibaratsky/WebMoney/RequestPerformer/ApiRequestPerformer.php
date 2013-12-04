<?php
namespace Baibaratsky\WebMoney\RequestPerformer;

use Baibaratsky\WebMoney\Api\Request;
use Baibaratsky\WebMoney\Api\Response;

abstract class ApiRequestPerformer
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function perform(Request $request)
    {
        $response = $this->_request($request);
        $responseClassName = $request->getResponseClassName();

        return new $responseClassName($response);
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    abstract protected function _request(Request $request);
}
