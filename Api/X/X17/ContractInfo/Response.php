<?php

namespace baibaratsky\WebMoney\Api\X\X17\ContractInfo;

use baibaratsky\WebMoney;

/**
 * Class Response
 *
 * @link http://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X17
 */
class Response extends WebMoney\Request\Response
{
    /** @var string retdesc */
    protected $returnDescription;

    /** @var Acceptance[] contractinfo */
    protected $acceptances = array();

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        $responseObject = new \SimpleXMLElement($response);
        $this->returnCode = (int)$responseObject->retval;
        $this->returnDescription = (string)$responseObject->retdesc;

        foreach ($responseObject->contractinfo->row as $contract) {
            $this->acceptances[] = new Acceptance(
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
        return $this->acceptances;
    }
}

