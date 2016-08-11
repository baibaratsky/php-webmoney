<?php

namespace baibaratsky\WebMoney\Request;

use baibaratsky\WebMoney\Exception\Exception;
use baibaratsky\WebMoney\Signer;

abstract class AbstractRequest
{
    /** @var string */
    protected $url;

    /** @var array */
    protected $errors = array();

    /** @var string sign|signstr */
    protected $signature;

    /**
     * Sign data for light authentication keys (for the ATM and WMC interfaces)
     * @param string $data data to sign
     * @param string $key full path to the private key file
     * @param string $keyPassword (optional) password for the private key
     *
     * @return string
     * @throws Exception
     */
    protected static function signLight($data, $key, $keyPassword = '')
    {
        if (!is_file($key)) {
            throw new Exception('Cannot access private key');
        }

        $privateKey = openssl_get_privatekey(file_get_contents($key), $keyPassword);
        openssl_sign($data, $signature, $privateKey, OPENSSL_ALGO_SHA1);
        return base64_encode($signature);
    }

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
     * @return string
     */
    public function getSignature()
    {
        return $this->signature;
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
