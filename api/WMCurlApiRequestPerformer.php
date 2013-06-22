<?php

class WMCurlApiRequestPerformer extends WMApiRequestPerformer
{
    /**
     * @param WMXmlApiRequest $request
     *
     * @return string
     * @throws WMException
     */
    protected function _request(WMXmlApiRequest $request)
    {
        $handler = curl_init($request->getUrl());

        curl_setopt($handler, CURLOPT_POST, true);
        curl_setopt($handler, CURLOPT_POSTFIELDS, $request->getXml());

        curl_setopt($handler, CURLOPT_SSL_VERIFYPEER, 0);

        ob_start();
        if (!curl_exec($handler)) {
            throw new WMException('Error while performing request (' . curl_error($handler) . ')');
        }
        $content = ob_get_contents();
        ob_end_clean();
        curl_close($handler);

        if (trim($content) == '') {
            throw new WMException('No response was received from the server');
        }

        return $content;
    }
}
