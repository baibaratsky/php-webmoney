<?php
namespace Baibaratsky\WebMoney\Api\X\X17\ContractInfo;

use Baibaratsky\WebMoney;

/**
 * Class Response
 *
 * @link http://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X17
 */
class Response extends WebMoney\Request\Response
{
    /** @var string retdesc */
    protected $_returnDescription;

    /** @var Acceptance[] contractinfo */
    protected $_acceptances = array();

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        $responseObject = new \SimpleXMLElement($response);
        $this->_returnCode = (int)$responseObject->retval;
        $this->_returnDescription = (string)$responseObject->retdesc;

        foreach ($responseObject->contractinfo->row as $contract) {
            $this->_acceptances[] = new Acceptance(
                $contract['contractid'],
                $contract['wmid'],
                $contract['acceptdate']
            );
        }
    }

    /**
     * @return Acceptance[]
     */
    public function getAcceptances()
    {
        return $this->_acceptances;
    }
}

