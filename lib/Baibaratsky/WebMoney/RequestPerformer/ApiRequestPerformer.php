<?php
namespace Baibaratsky\WebMoney\RequestPerformer;

use Baibaratsky\WebMoney\Api\ApiRequest;
use Baibaratsky\WebMoney\Api\ApiResponse;

abstract class ApiRequestPerformer
{
    /**
     * @param ApiRequest $request
     *
     * @return ApiResponse
     */
    public function perform(ApiRequest $request)
    {
        $response = $this->_request($request);
        $responseClassName = $request->getResponseClassName();

        return new $responseClassName($response);
    }

    /**
     * @param ApiRequest $request
     *
     * @return mixed
     */
    abstract protected function _request(ApiRequest $request);
}
