<?php
namespace Baibaratsky\WebMoney\Api\Xml\X11;

use Baibaratsky\WebMoney\Api;

/**
 * Class Response
 *
 * @link https://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X11
 */
class Response extends Api\Response
{
    /** @var string /@retdesc */
    protected $_returnDescription;

    /** @var int fullaccess */
    protected $_hasFullAccess;

    /** @var string certinfo/@wmid */
    protected $_wmid;

    /** @var array certinfo/directory/tid */
    protected static $_passportTypes;

    /** @var array certinfo/directory/ctype */
    protected static $_legalStatuses;

    /** @var array certinfo/directory/jstatus */
    protected static $_legalPositionStatuses;

    /** @var Passport certinfo/attestat */
    protected $_passport;

    /** @var Wmid[] certinfo/wmids */
    protected $_wmids = array();

    /** @var UserInfo[] certinfo/userinfo/value */
    protected $_userInfo = array();

    /** @var CheckLock[] certinfo/userinfo/check-lock */
    protected $_checkLock = array();

    /** @var WebList[] certinfo/userinfo/weblist */
    protected $_webList = array();

    /** @var ExtendedData[] certinfo/userinfo/extendeddata */
    protected $_extendedData = array();

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        $responseObject = new \SimpleXMLElement($response);
        $this->_returnCode = (int)$responseObject['retval'];
        $this->_returnDescription = (string)$responseObject['retdesc'];
        $this->_hasFullAccess = (int)$responseObject->fullaccess;
        $certInfo = $responseObject->certinfo;
        $this->_wmid = (string)$certInfo['wmid'];

        if ($certInfo->directory !== null) {
            static::$_legalStatuses = $this->_dirtyXmlToArray($certInfo->directory->ctype);
            static::$_legalPositionStatuses = $this->_dirtyXmlToArray($certInfo->directory->jstatus);
            static::$_passportTypes = $this->_dirtyXmlToArray($certInfo->directory->tid);
        }

        if ($certInfo->attestat !== null) {
            $this->_passport = new Passport($this->_rowAttributesXmlToArray($certInfo->attestat));
        }

        if ($certInfo->wmids !== null) {
            foreach ($this->_rowAttributesXmlToArray($certInfo->wmids) as $wmid) {
                $this->_wmids[] = new Wmid($wmid);
            }
        }

        if ($certInfo->userinfo !== null) {
            if ($certInfo->userinfo->value !== null) {
                foreach ($this->_rowAttributesXmlToArray($certInfo->userinfo->value) as $userInfo) {
                    $this->_userInfo[] = new UserInfo($userInfo);
                }
            }

            if ($certInfo->userinfo->{'check-lock'} !== null) {
                foreach ($this->_rowAttributesXmlToArray($certInfo->userinfo->{'check-lock'}) as $checkLock) {
                    $this->_checkLock[] = new CheckLock($checkLock);
                }
            }

            if ($certInfo->userinfo->weblist !== null) {
                foreach ($this->_rowAttributesXmlToArray($certInfo->userinfo->weblist) as $webList) {
                    $this->_webList[] = new WebList($webList);
                }
            }

            if ($certInfo->userinfo->extendeddata !== null) {
                foreach ($this->_rowAttributesXmlToArray($certInfo->userinfo->extendeddata) as $extendedData) {
                    $this->_extendedData[] = new ExtendedData($extendedData);
                }
            }
        }
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
    public static function getPassportTypes()
    {
        return static::$_passportTypes;
    }

    /**
     * @return array
     */
    public static function getLegalStatuses()
    {
        return static::$_legalStatuses;
    }

    /**
     * @return array
     */
    public static function getLegalPositionStatuses()
    {
        return static::$_legalPositionStatuses;
    }

    /**
     * @return Passport[]
     */
    public function getPassport()
    {
        return $this->_passport;
    }

    /**
     * @return Wmid[]
     */
    public function getWmids()
    {
        return $this->_wmids;
    }

    /**
     * @return UserInfo[]
     */
    public function getUserInfo()
    {
        return $this->_userInfo;
    }

    /**
     * @return CheckLock[]
     */
    public function getCheckLock()
    {
        return $this->_checkLock;
    }

    /**
     * @return WebList[]
     */
    public function getWebList()
    {
        return $this->_webList;
    }

    /**
     * @return ExtendedData[]
     */
    public function getExtendedData()
    {
        return $this->_extendedData;
    }

    /**
     * @param \SimpleXMLElement $xml
     *
     * @return array
     */
    protected function _dirtyXmlToArray(\SimpleXMLElement $xml)
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
     * @param \SimpleXMLElement $xml
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
            $returnArray[] = reset($object);
        }

        if (count($returnArray) == 1) {
            return reset($returnArray);
        }

        return $returnArray;
    }
}
