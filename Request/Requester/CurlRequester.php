<?php

namespace baibaratsky\WebMoney\Request\Requester;

use baibaratsky\WebMoney\Request\AbstractRequest;
use baibaratsky\WebMoney\Request\XmlRequest;
use baibaratsky\WebMoney\Exception\RequesterException;
use baibaratsky\WebMoney\WebMoney;

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

        /** @var XmlRequest $request */

        $handler = curl_init($request->getUrl());

        curl_setopt($handler, CURLOPT_POST, true);
        curl_setopt($handler, CURLOPT_POSTFIELDS, $request->getData());

        curl_setopt($handler, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($handler, CURLOPT_SSLVERSION, 3);

        if(method_exists($request, 'getAuthType') && $request->getAuthType() == $request::AUTH_LIGHT) {
            $keys = WebMoney::getPathsToSertificate();
            curl_setopt($handler, CURLOPT_SSLKEY, $keys['key']);
            curl_setopt($handler, CURLOPT_SSLKEYPASSWD, $keys['pass']);
            curl_setopt($handler, CURLOPT_SSLCERT, $keys['cer']);
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
