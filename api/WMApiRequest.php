<?php

abstract class WMApiRequest
{
    const AUTH_CLASSIC = 'classic';
    const AUTH_LIGHT = 'light';

    protected $_errors = array();
    protected $_xml;

    /**
     * @return bool
     */
    abstract public function validate();

    /**
     * @return string
     */
    abstract public function getUrl();

    /**
     * @return string
     */
    abstract public function getXml();

    /**
     * @return string
     */
    abstract public function getResponseClassName();

    /**
     * @param WMRequestSigner $requestSigner
     *
     * @return void
     */
    abstract public function sign(WMRequestSigner $requestSigner);

    /**
     * @return array
     */
    abstract public function toArray();

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->_errors;
    }

    /**
     * @param string $name
     * @param string|int|float $value
     */
    protected function _addElementToXml($name, $value)
    {
        if (!empty($value)) {
            $this->_xml .= '<' . $name . '>' . $value . '</' . $name . '>';
        }
    }

    /**
     * @return string
     */
    protected function _generateRequestNumber()
    {
        return str_replace('.', '', microtime(true));
    }
}
