<?php
namespace Baibaratsky\WebMoney\Request;

abstract class AbstractRequest
{
    /** @var string */
    protected $url;

    /** @var array */
    protected $errors = array();

    /** @var string sign|signstr */
    protected $signature;

    /**
     * @return bool
     */
    public function validate()
    {
        $validator = new RequestValidator($this);
        $this->errors = $validator->validate($this->getValidationRules());

        return count($this->errors) == 0;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
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
        return $this->errors;
    }

    /**
     * @return array
     */
    abstract protected function getValidationRules();

    /**
     * @return string
     */
    abstract public function getResponseClassName();
}
