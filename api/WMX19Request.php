<?php

/**
 * @property int $reqn
 * @property string $lang
 * @property string $signerwmid
 * @property array $operation
 * @property string $sign
 * @property array $userinfo
 */
class WMX19Request extends WMApiRequest
{
    const LANG_RU = 'ru';
    const LANG_EN = 'en';

    const TYPE_CASH = 1;
    const TYPE_SDP = 2;
    const TYPE_BANK = 3;
    const TYPE_CARD = 4;
    const TYPE_EMONEY = 5;
    const TYPE_SMS = 6;
    const TYPE_MOBILE = 7;

    const DIRECTION_OUTPUT = 1;
    const DIRECTION_INPUT = 2;

    const PURSE_WMZ = 'WMZ';
    const PURSE_WMR = 'WMR';
    const PURSE_WME = 'WME';
    const PURSE_WMU = 'WMU';
    const PURSE_WMB = 'WMB';
    const PURSE_WMY = 'WMY';
    const PURSE_WMG = 'WMG';

    const EMONEY_RBKM = 'rbkmoney.ru';
    const EMONEY_PP = 'paypal.com';
    const EMONEY_SK = 'moneybookers.com';
    const EMONEY_QW = 'qiwi.ru';
    const EMONEY_YAM = 'money.yandex.ru';
    const EMONEY_ESP = 'easypay.by';

    public function validate()
    {

    }

    public function getUrl()
    {
        //@TODO keeper light https://apipassport.webmoney.ru/XMLCheckUserCert.aspx
        return 'https://apipassport.webmoney.ru/XMLCheckUser.aspx';
    }

    public function getXml()
    {
        $xmlObject = new SimpleXMLElement('<passport.request/>');
        $this->_fillXmlFromArray($xmlObject, $this->_params);

        return $xmlObject->asXML();
    }

    public function getResponseClassName()
    {
        return 'WMX19Response';
    }

    protected function _fillXmlFromArray(SimpleXMLElement &$xmlObject, array $data)
    {
        foreach ($data as $name => $value) {
            if (is_array($value)) {
                $this->_fillXmlFromArray($xmlObject->$name, $value);
            } else {
                $xmlObject->$name = $value;
            }
        }
    }
}
