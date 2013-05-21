<?php

abstract class WMApiRequest
{
    protected $_params = array();

    public function __get($name)
    {
        return $this->_params[$name];
    }

    public function __set($name, $value)
    {
        $this->_params[$name] = $value;
    }

    abstract public function validate();

    abstract public function getUrl();

    abstract public function getXml();

    abstract public function getResponseClassName();
}
