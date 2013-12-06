<?php
namespace Baibaratsky\WebMoney\Api\Xml\X8;

use Baibaratsky\WebMoney\Api;

/**
 * Class Response
 *
 * @link https://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X8
 */
class Response extends Api\Response
{
    /** @var int retval */
    protected $_returnCode;

    /** @var string retdesc */
    protected $_returnDescription;

    /** @var Wmid testwmpurse/wmid */
    protected $_wmid;

    /** @var Purse testwmpurse/purse */
    protected $_purse;

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        $responseObject = new \SimpleXMLElement($response);
        $this->_returnCode = (int)$responseObject->retval;
        $this->_returnDescription = (string)$responseObject->retdesc;
        if (!empty($responseObject->testwmpurse->wmid)) {
            $this->_wmid = new Wmid(
                (string)$responseObject->testwmpurse->wmid,
                (int)$responseObject->testwmpurse->wmid['available'] > 0 ?
                        (bool)$responseObject->testwmpurse->wmid['available'] : null,
                (int)$responseObject->testwmpurse->wmid['themselfcorrstate'] > 0 ?
                        (int)$responseObject->testwmpurse->wmid['themselfcorrstate'] >= 8 : null,
                (int)$responseObject->testwmpurse->wmid['newattst'] > 0 ?
                        (int)$responseObject->testwmpurse->wmid['newattst'] : null
            );
        }
        if (!empty($responseObject->testwmpurse->purse)) {
            $this->_purse = new Purse(
                (string)$responseObject->testwmpurse->purse,
                (int)$responseObject->testwmpurse->purse['merchant_active_mode'] > 0 ?
                        (bool)$responseObject->testwmpurse->purse['merchant_active_mode'] : null,
                (int)$responseObject->testwmpurse->purse['merchant_allow_cashier'] > 0 ?
                        (bool)$responseObject->testwmpurse->purse['merchant_allow_cashier'] : null
            );
        }
    }
}
