<?php
namespace Baibaratsky\WebMoney\Api\Xml;

use Baibaratsky\WebMoney\Api\ApiResponse;

/**
 * Class X19Response
 *
 * @link https://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X19
 */
class X19Response extends ApiResponse
{
    /** @var string retdesc */
    protected $_returnDescription;

    /** @var string retid */
    protected $_returnId;

    /** @var string userinfo/iname */
    protected $_userFirstName;

    /** @var string userinfo/oname */
    protected $_userMiddleName;

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        $responseObject = new \SimpleXMLElement($response);
        $this->_returnCode = (int)$responseObject->retval;
        $this->_returnDescription = (string)$responseObject->retdesc;
        $this->_returnId = (string)$responseObject->retid;
        $this->_userFirstName = (string)$responseObject->userinfo->iname;
        $this->_userMiddleName = (string)$responseObject->userinfo->oname;
    }


    /**
     * @return string
     */
    public function getReturnDescription()
    {
        return $this->_returnDescription;
    }

    /**
     * @return string
     */
    public function getReturnId()
    {
        return $this->_returnId;
    }

    /**
     * @return string
     */
    public function getUserFirstName()
    {
        return $this->_userFirstName;
    }

    /**
     * @return string
     */
    public function getUserMiddleName()
    {
        return $this->_userMiddleName;
    }
}
