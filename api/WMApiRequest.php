<?php

abstract class WMApiRequest
{
    abstract public function validate();

    abstract public function getUrl();

    abstract public function getXml();

    abstract public function getResponseClassName();

    abstract public function sign(WMRequestSigner $requestSigner);

    protected function _generateRequestNumber()
    {
        return str_replace('.', '', microtime(true));
    }
}
