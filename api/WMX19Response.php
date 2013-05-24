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
        $responseObject = new SimpleXMLElement($response);
        $this->_returnCode = (int)$responseObject->retval;
        $this->_returnDescription = (string)$responseObject->retdesc;
        $this->_returnId = (string)$responseObject->retid;
        $this->_userFirstName = (string)$responseObject->userinfo->iname;
        $this->_userMiddleName = (string)$responseObject->userinfo->oname;
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
