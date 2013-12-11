<?php
namespace Baibaratsky\WebMoney\Api\X\X11;

use Baibaratsky\WebMoney;

/**
 * Class Response
 *
 * @link https://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X11
 */
class Response extends WebMoney\Request\Response
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

    /** @var UserInfo certinfo/userinfo/value */
    protected $_userInfo;

    /** @var CheckLock certinfo/userinfo/check-lock */
    protected $_checkLock;

    /** @var WebList certinfo/userinfo/weblist */
    protected $_webList;

    /** @var ExtendedData certinfo/userinfo/extendeddata */
    protected $_extendedData;

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
            $passport = $this->_rowAttributesXmlToArray($certInfo->attestat);
            $this->_passport = new Passport(reset($passport));
        }

        if ($certInfo->wmids !== null) {
            foreach ($this->_rowAttributesXmlToArray($certInfo->wmids) as $wmid) {
                $this->_wmids[] = new Wmid($wmid);
            }
        }

        if ($certInfo->userinfo !== null) {
            if ($certInfo->userinfo->value !== null) {
                $userInfo = $this->_rowAttributesXmlToArray($certInfo->userinfo->value);
                $this->_userInfo = new UserInfo(reset($userInfo));
            }

            if ($certInfo->userinfo->{'check-lock'} !== null) {
                $checkLock = $this->_rowAttributesXmlToArray($certInfo->userinfo->{'check-lock'});
                $this->_checkLock = new CheckLock(reset($checkLock));
            }

            if ($certInfo->userinfo->weblist !== null) {
                $webList = $this->_rowAttributesXmlToArray($certInfo->userinfo->weblist);
                if (!empty($webList)) {
                    $this->_webList = new WebList(reset($webList));
                }
            }

            if ($certInfo->userinfo->extendeddata !== null) {
                $extendedData = $this->_rowAttributesXmlToArray($certInfo->userinfo->extendeddata);
                if (!empty($extendedData)) {
                    $this->_extendedData = new ExtendedData(reset($extendedData));
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
     * @return Passport
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
     * @return UserInfo
     */
    public function getUserInfo()
    {
        return $this->_userInfo;
    }

    /**
     * @return CheckLock
     */
    public function getCheckLock()
    {
        return $this->_checkLock;
    }

    /**
     * @return WebList
     */
    public function getWebList()
    {
        return $this->_webList;
    }

    /**
     * @return ExtendedData
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

        return $returnArray;
    }
}
