<?php
namespace Baibaratsky\WebMoney\Api\Xml\X17\CreateContract;

use Baibaratsky\WebMoney\Api;

/**
 * Class Response
 *
 * @link http://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X17
 */
class Response extends Api\Response
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

