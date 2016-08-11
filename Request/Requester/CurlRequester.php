<?php

namespace baibaratsky\WebMoney\Request\Requester;

use baibaratsky\WebMoney\Api\X\Request AS XRequest;
use baibaratsky\WebMoney\Api\ATM\Request AS ATMRequest;
use baibaratsky\WebMoney\Api\WMC\Request AS WMCRequest;
use baibaratsky\WebMoney\Exception\RequesterException;
use baibaratsky\WebMoney\Request\AbstractRequest;
use baibaratsky\WebMoney\Request\XmlRequest;

class CurlRequester extends AbstractRequester
{
    /**
     * @param AbstractRequest $request
     *
     * @return string
     * @throws RequesterException
     */
    protected function request(AbstractRequest $request)
    {
        if (!$request instanceof XmlRequest) {
            throw new RequesterException('This requester doesn\'t support such type of request.');
        }

        $handler = curl_init($request->getUrl());

        curl_setopt($handler, CURLOPT_POST, true);
        curl_setopt($handler, CURLOPT_POSTFIELDS, $request->getData());

        if ($this->verifyCertificate) {
            curl_setopt($handler, CURLOPT_CAINFO, dirname(dirname(__DIR__)) . '/WMUsedRootCAs.cer');
        }
        curl_setopt($handler, CURLOPT_SSL_VERIFYPEER, $this->verifyCertificate);
        curl_setopt($handler, CURLOPT_SSLVERSION, 1);

        if (($request instanceof XRequest && $request->getAuthType() === XRequest::AUTH_LIGHT)
                || ($request instanceof ATMRequest && $request->getAuthType() === ATMRequest::AUTH_LIGHT)
                || ($request instanceof WMCRequest && $request->getAuthType() === WMCRequest::AUTH_LIGHT)
        ) {
            curl_setopt($handler, CURLOPT_SSLCERT, $request->getLightCertificate());
            curl_setopt($handler, CURLOPT_SSLKEY, $request->getLightKey());

            $password = $request->getLightPassword();
            if (!empty($password)) {
                curl_setopt($handler, CURLOPT_KEYPASSWD, $password);
            }
        }

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
