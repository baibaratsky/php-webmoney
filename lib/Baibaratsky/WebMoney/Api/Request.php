<?php
namespace Baibaratsky\WebMoney\Api;

use Baibaratsky\WebMoney\Signer\RequestSigner;
use Baibaratsky\WebMoney\Validator\RequestValidator;

abstract class Request
{
    /** @var string */
    protected $_url;

    /** @var array */
    protected $_errors = array();

    /** @var string sign|signstr */
    protected $_signature;

    /**
     * @return bool
     */
    public function validate()
    {
        $validator = new RequestValidator($this);
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
     * @param RequestSigner $requestSigner
     *
     * @return void
     */
    abstract public function sign(RequestSigner $requestSigner = null);

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

    /**
     * @return string
     */
    abstract public function getResponseClassName();
}
