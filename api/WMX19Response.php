<?php

class WMX19Response extends WMApiResponse
{
    protected $_returnCode;
    protected $_returnDescription;
    protected $_returnId;
    protected $_userFirstName;
    protected $_userMiddleName;

    public function __construct($response)
    {
        $response = preg_replace('/ encoding=\"(.*)\"/', '', $response);

        $xmlObject = new SimpleXMLElement($response);

        $this->_returnCode = (int)$xmlObject->retval;
        $this->_returnDescription = (string)$xmlObject->retdesc;
        $this->_returnId = (string)$xmlObject->retid;
        $this->_userFirstName = (string)$xmlObject->userinfo->iname;
        $this->_userMiddleName = (string)$xmlObject->userinfo->oname;
    }

    /**
     * @return mixed
     */
    public function getReturnCode()
    {
        return $this->_returnCode;
    }

    /**
     * @return mixed
     */
    public function getReturnDescription()
    {
        return $this->_returnDescription;
    }

    /**
     * @return mixed
     */
    public function getReturnId()
    {
        return $this->_returnId;
    }

    /**
     * @return mixed
     */
    public function getUserFirstName()
    {
        return $this->_userFirstName;
    }

    /**
     * @return mixed
     */
    public function getUserMiddleName()
    {
        return $this->_userMiddleName;
    }
}
