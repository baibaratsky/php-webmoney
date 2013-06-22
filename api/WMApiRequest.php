<?php

abstract class WMApiRequest
{
    /** @var string */
    protected $_url;

    /** @var array */
    protected $_errors = array();

    /**
     * @return bool
     */
    public function validate()
    {
        $validator = new WMApiRequestValidator($this);
        $this->_errors = $validator->validate($this->_getValidationRules());

        return count($this->_errors) == 0;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->_url;
    }

    /**
     * @param WMRequestSigner $requestSigner
     *
     * @return void
     */
    abstract public function sign(WMRequestSigner $requestSigner);

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->_errors;
    }

    /**
     * @return array
     */
    abstract protected function _getValidationRules();
}
