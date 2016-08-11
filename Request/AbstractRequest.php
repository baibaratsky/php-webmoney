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
     * @return bool
     */
    public function validate()
    {
        $validator = new RequestValidator($this);
        $this->errors = $validator->validate($this->getValidationRules());

        return count($this->errors) == 0;
    }
  
    /**
     * Sign data for light authentication keys - needed for ATM and WMC interface
     * @param string $data data to sign
     * @param string $lightKey filepath to private key
     * @param string $lightPass (optional) password for private key
     *
     * @return string
     * @throws Exception
     */
    public function signLight($data, $lightKey, $lightPass = '') {
      if (!is_file($lightKey)) {
        throw new Exception('Cannot access private key');
      }
      
      $pkeyid = openssl_get_privatekey(file_get_contents($lightKey), $lightPass);
      openssl_sign($data, $sig, $pkeyid, OPENSSL_ALGO_SHA1);
      return base64_encode($sig);
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
    public function getSignature() {
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
