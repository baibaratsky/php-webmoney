<?php

class WebMoney
{
    private $_requestPerformer;

    public function __construct(WMApiRequestPerformer $requestPerformer)
    {
        $this->_requestPerformer = $requestPerformer;
    }

    public function request(WMApiRequest $requestObject)
    {
        return $this->_requestPerformer->perform($requestObject);
    }
}
