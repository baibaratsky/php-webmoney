<?php

namespace baibaratsky\WebMoney\Api\X\X19;

use baibaratsky\WebMoney\Request\AbstractResponse;

/**
 * Class Response
 *
 * @link https://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X19
 */
class Response extends AbstractResponse
{
    /** @var string retid */
    protected $returnId;

    /** @var string userinfo/iname */
    protected $userFirstName;

    /** @var string userinfo/oname */
    protected $userMiddleName;

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        $responseObject = new \SimpleXMLElement($response);
        $this->returnCode = (int)$responseObject->retval;
        $this->returnDescription = (string)$responseObject->retdesc;
        $this->returnId = (string)$responseObject->retid;
        $this->userFirstName = (string)$responseObject->userinfo->iname;
        $this->userMiddleName = (string)$responseObject->userinfo->oname;
    }

    /**
     * @return string
     */
    public function getReturnId()
    {
        return $this->returnId;
    }

    /**
     * @return string
     */
    public function getUserFirstName()
    {
        return $this->userFirstName;
    }

    /**
     * @return string
     */
    public function getUserMiddleName()
    {
        return $this->userMiddleName;
    }
}
