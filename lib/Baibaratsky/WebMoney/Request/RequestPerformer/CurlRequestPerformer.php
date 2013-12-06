<?php
namespace Baibaratsky\WebMoney\Request\RequestPerformer;

use Baibaratsky\WebMoney\Request\AbstractRequest;
use Baibaratsky\WebMoney\Request\XmlRequest;
use Baibaratsky\WebMoney\Exception\RequestPerformerException;

class CurlRequestPerformer extends AbstractRequestPerformer
{
    /**
     * @param AbstractRequest $request
     *
     * @return string
     * @throws RequestPerformerException
     */
    protected function _request(AbstractRequest $request)
    {
        if (!$request instanceof XmlRequest) {
            throw new RequestPerformerException('This request performer doesn\'t support such type of request.');
        }

        /** @var \Baibaratsky\WebMoney\Request\XmlRequest $request */

        $handler = curl_init($request->getUrl());

        curl_setopt($handler, CURLOPT_POST, true);
        curl_setopt($handler, CURLOPT_POSTFIELDS, $request->getData());

        curl_setopt($handler, CURLOPT_SSL_VERIFYPEER, 0);

        ob_start();
        if (!curl_exec($handler)) {
            throw new RequestPerformerException('Error while performing request (' . curl_error($handler) . ')');
        }
        $content = ob_get_contents();
        ob_end_clean();
        curl_close($handler);

        if (trim($content) == '') {
            throw new RequestPerformerException('No response was received from the server');
        }

        return $content;
    }
}
