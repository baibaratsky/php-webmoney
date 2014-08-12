<?php

namespace baibaratsky\WebMoney\Request\Requester;

use baibaratsky\WebMoney\Request\AbstractRequest;
use baibaratsky\WebMoney\Request\RequestSigner;
use baibaratsky\WebMoney\Request\XmlRequest;
use baibaratsky\WebMoney\Exception\RequesterException;

class ClassicRequester extends AbstractRequester
{
    /** @var RequestSigner */
    protected $requestSigner;

    public function __construct(RequestSigner $requestSigner = null)
    {
        $this->requestSigner = $requestSigner;
    }

    public function perform(AbstractRequest $request)
    {
        if (!$request instanceof XmlRequest) {
            throw new RequesterException('This requester doesn\'t support such type of request.');
        }
        $request->sign($this->requestSigner);

        return parent::perform($request);
    }

    /**
     * @param AbstractRequest $request
     *
     * @return string
     * @throws RequesterException
     */
    protected function request(AbstractRequest $request)
    {
        /** @var XmlRequest $request */

        $handler = curl_init($request->getUrl());

        curl_setopt($handler, CURLOPT_POST, true);
        curl_setopt($handler, CURLOPT_POSTFIELDS, $request->getData());

        curl_setopt($handler, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($handler, CURLOPT_SSLVERSION, 3);

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
