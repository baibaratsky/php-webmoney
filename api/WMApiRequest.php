<?php

abstract class WMApiRequest
{
    abstract public function validate();

    abstract public function getUrl();

    abstract public function getXml();

    abstract public function getResponseClassName();
}
