<?php

namespace baibaratsky\WebMoney\Api\X\X17\ContractInfo;

use baibaratsky\WebMoney\Request\AbstractResponse;

/**
 * Class Response
 *
 * @link http://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X17
 */
class Response extends AbstractResponse
{
    /** @var Acceptance[] contractinfo */
    protected $acceptances = array();

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $responseObject = new \SimpleXMLElement($response);
        $this->requestNumber = (int)$responseObject->reqn;
        $this->returnCode = (int)$responseObject->retval;
        $this->returnDescription = (string)$responseObject->retdesc;

        foreach ($responseObject->contractinfo->row as $contract) {
            $this->acceptances[] = new Acceptance(
                (int)$contract['contractid'],
                (string)$contract['wmid'],
                empty($contract['acceptdate']) ? null : self::createDateTime($contract['acceptdate'])
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
