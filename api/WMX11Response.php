<?php


class WMX11Response extends WMApiResponse
{
    /** @var int */
    protected $_returnCode;

    /** @var string */
    protected $_returnDescription;

    /** @var int */
    protected $_hasFullAccess;

    /** @var string */
    protected $_wmid;

    /** @var array */
    protected $_certificateTypes;

    /** @var array */
    protected $_legalStatuses;

    /** @var array */
    protected $_legalPositionStatuses;

    /** @var array */
    protected $_certificates;

    /** @var array */
    protected $_wmids;

    /** @var array */
    protected $_userInfo;

    /** @var array */
    protected $_checkLock;

    /** @var array */
    protected $_webList;

    /** @var array */
    protected $_extendedData;

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        $responseObject = new SimpleXMLElement($response);

        $this->_returnCode = (int)$responseObject['retval'];
        $this->_returnDescription = (string)$responseObject['retdesc'];
        $this->_hasFullAccess = (int)$responseObject->fullAccess;
        $certInfo = $responseObject->certinfo;
        $this->_wmid = (string)$certInfo['wmid'];

        if (isset($certInfo->directory)) {
            $this->_legalStatuses = $this->_dirtyXmlToArray($certInfo->directory->ctype);
            $this->_legalPositionStatuses = $this->_dirtyXmlToArray($certInfo->directory->jstatus);
            $this->_certificateTypes = $this->_dirtyXmlToArray($certInfo->directory->tid);
        }

        $this->_certificates = $this->_rowAttributesXmlToArray($certInfo->attestat);
        $this->_wmids = $this->_rowAttributesXmlToArray($certInfo->wmids);

        if (isset($certInfo->userinfo)) {
            $this->_userInfo = $this->_rowAttributesXmlToArray($certInfo->userinfo->value);
            $this->_checkLock = $this->_rowAttributesXmlToArray($certInfo->userinfo->{'check-lock'});
            $this->_webList = $this->_rowAttributesXmlToArray($certInfo->userinfo->weblist);
            $this->_extendedData = $this->_rowAttributesXmlToArray($certInfo->userinfo->extendeddata);
        }
    }

    /**
     * @return int
     */
    public function getReturnCode()
    {
        return $this->_returnCode;
    }

    /**
     * @return string
     */
    public function getReturnDescription()
    {
        return $this->_returnDescription;
    }

    /**
     * @return int
     */
    public function getHasFullAccess()
    {
        return $this->_hasFullAccess;
    }

    /**
     * @return string
     */
    public function getWmid()
    {
        return $this->_wmid;
    }

    /**
     * @return array
     */
    public function getCertificateTypes()
    {
        return $this->_certificateTypes;
    }

    /**
     * @return array
     */
    public function getLegalStatuses()
    {
        return $this->_legalStatuses;
    }

    /**
     * @return array
     */
    public function getLegalPositionStatuses()
    {
        return $this->_legalPositionStatuses;
    }

    /**
     * @return array
     */
    public function getCertificates()
    {
        return $this->_certificates;
    }

    /**
     * @return array
     */
    public function getWmids()
    {
        return $this->_wmids;
    }

    /**
     * @return array
     */
    public function getUserInfo()
    {
        return $this->_userInfo;
    }

    /**
     * @return array
     */
    public function getCheckLock()
    {
        return $this->_checkLock;
    }

    /**
     * @return array
     */
    public function getWebList()
    {
        return $this->_webList;
    }

    /**
     * @return array
     */
    public function getExtendedData()
    {
        return $this->_extendedData;
    }

    /**
     * @param SimpleXMLElement $xml
     *
     * @return array
     */
    protected function _dirtyXmlToArray(SimpleXMLElement $xml)
    {
        $returnArray = array();
        foreach ($xml as $object) {
            $key = (string)$object['id'];
            $value = (string)$object;
            $returnArray[$key] = $value;
        }

        return $returnArray;
    }

    /**
     * @param SimpleXMLElement $xml
     *
     * @return array
     */
    protected function _rowAttributesXmlToArray($xml)
    {
        if ($xml === null) {
            return null;
        }

        $returnArray = array();
        foreach ($xml->row as $object) {
            $returnArray[] = current($object);
        }

        return $returnArray;
    }
}
