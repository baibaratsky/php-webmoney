<?php

namespace baibaratsky\WebMoney\Request\Requester;

use baibaratsky\WebMoney\Api\X\Request;
use baibaratsky\WebMoney\Exception\RequesterException;
use baibaratsky\WebMoney\Request\AbstractRequest;

class LightRequester extends AbstractRequester
{
    protected $keyFile;
    protected $keyPassword;
    protected $certFile;

    /**
     * @param string $keyFile
     * @param string $keyPassword
     * @param string $certFile
     */
    public function __construct($keyFile, $keyPassword, $certFile)
    {
        $this->keyFile = $keyFile;
        $this->keyPassword = $keyPassword;
        $this->certFile = $certFile;
    }

    public function perform(AbstractRequest $request)
    {
        if (!$request instanceof Request) {
            throw new RequesterException('This requester doesn\'t support such type of request.');
        }
        if ($request->getAuthType() != Request::AUTH_LIGHT) {
            throw new RequesterException('This requester doesn\'t support such auth type.');
        }

        return parent::perform($request);
    }

    /**
     * @param AbstractRequest $request
     *
     * @return string
     * @throws \baibaratsky\WebMoney\Exception\RequesterException
     */
    protected function request(AbstractRequest $request)
    {
        /** @var Request $request */

        $handler = curl_init($request->getUrl());

        curl_setopt($handler, CURLOPT_POST, true);
        curl_setopt($handler, CURLOPT_POSTFIELDS, $request->getData());

        curl_setopt($handler, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($handler, CURLOPT_SSLVERSION, 3);

        curl_setopt($handler, CURLOPT_SSLKEY, $this->keyFile);
        curl_setopt($handler, CURLOPT_SSLKEYPASSWD, $this->keyPassword);
        curl_setopt($handler, CURLOPT_SSLCERT, $this->certFile);

        ob_start();
        if (!curl_exec($handler)) {
            throw new RequesterException('Error while performing request (' . curl_error($handler) . ')');
        }
        $content = ob_get_contents();
        ob_end_clean();
        curl_close($handler);

        if (trim($content) == '') {
            throw new RequesterException('No response was received from the server');
        }

        return $content;
    }
}
