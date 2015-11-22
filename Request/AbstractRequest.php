<?php

namespace baibaratsky\WebMoney\Request;

use baibaratsky\WebMoney\Signer;

abstract class AbstractRequest
{
    const AUTH_CLASSIC = 'classic';
    const AUTH_LIGHT = 'light';
    const AUTH_SHA256 = 'sha256';
    const AUTH_MD5 = 'md5';
    const AUTH_SECRET_KEY = 'secret_key';

    /** @var string */
    protected $url;

    /** @var string */
    protected $authType;

    /** @var array */
    protected $errors = array();

    /** @var string sign|signstr */
    protected $signature;

    /** @var string Light auth cert file name (PEM) */
    protected $cert;

    /** @var string Light auth key file name (PEM) */
    protected $certKey;

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
     * @return string
     */
    public function getAuthType()
    {
        return $this->authType;
    }

    /**
     * @param Signer $requestSigner
     * @return
     */
    abstract public function sign(Signer $requestSigner = null);

    /**
     * @return string[]
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

    /**
     * @return string
     */
    public function getCert()
    {
        return $this->cert;
    }

    /**
     * @return string
     */
    public function getCertKey()
    {
        return $this->certKey;
    }
}
