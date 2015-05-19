<?php

namespace baibaratsky\WebMoney\Api\X\X11;

use baibaratsky\WebMoney\Request\AbstractResponse;

/**
 * Class Response
 *
 * @link https://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X11
 */
class Response extends AbstractResponse
{
    /** @var int fullaccess */
    protected $hasFullAccess;

    /** @var string certinfo/@wmid */
    protected $wmid;

    /** @var array certinfo/directory/tid */
    protected static $passportTypes;

    /** @var array certinfo/directory/ctype */
    protected static $legalStatuses;

    /** @var array certinfo/directory/jstatus */
    protected static $legalPositionStatuses;

    /** @var Passport certinfo/attestat */
    protected $passport;

    /** @var Wmid[] certinfo/wmids */
    protected $wmids = array();

    /** @var UserInfo certinfo/userinfo/value */
    protected $userInfo;

    /** @var CheckLock certinfo/userinfo/check-lock */
    protected $checkLock;

    /** @var WebList certinfo/userinfo/weblist */
    protected $webList;

    /** @var ExtendedData certinfo/userinfo/extendeddata */
    protected $extendedData;

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        $responseObject = new \SimpleXMLElement($response);
        $this->returnCode = (int)$responseObject['retval'];
        $this->returnDescription = (string)$responseObject['retdesc'];
        $this->hasFullAccess = (int)$responseObject->fullaccess;
        $certInfo = $responseObject->certinfo;
        $this->wmid = (string)$certInfo['wmid'];

        if ((array)$certInfo->directory) {
            static::$legalStatuses = $this->dirtyXmlToArray($certInfo->directory->ctype);
            static::$legalPositionStatuses = $this->dirtyXmlToArray($certInfo->directory->jstatus);
            static::$passportTypes = $this->dirtyXmlToArray($certInfo->directory->tid);
        }

        if ((array)$certInfo->attestat) {
            $passport = $this->rowAttributesXmlToArray($certInfo->attestat);
            $this->passport = new Passport(reset($passport));
        }

        if ((array)$certInfo->wmids) {
            foreach ($this->rowAttributesXmlToArray($certInfo->wmids) as $wmid) {
                $this->wmids[] = new Wmid($wmid);
            }
        }

        if ((array)$certInfo->userinfo) {
            if ($certInfo->userinfo->value !== null) {
                $userInfo = $this->rowAttributesXmlToArray($certInfo->userinfo->value);
                $this->userInfo = new UserInfo(reset($userInfo));
            }

            if ((array)$certInfo->userinfo->{'check-lock'}) {
                $checkLock = $this->rowAttributesXmlToArray($certInfo->userinfo->{'check-lock'});
                $this->checkLock = new CheckLock(reset($checkLock));
            }

            if ((array)$certInfo->userinfo->weblist) {
                $webList = $this->rowAttributesXmlToArray($certInfo->userinfo->weblist);
                if (!empty($webList)) {
                    $this->webList = new WebList(reset($webList));
                }
            }

            if ((array)$certInfo->userinfo->extendeddata) {
                $extendedData = $this->rowAttributesXmlToArray($certInfo->userinfo->extendeddata);
                if (!empty($extendedData)) {
                    $this->extendedData = new ExtendedData(reset($extendedData));
                }
            }
        }
    }

    /**
     * @return int
     */
    public function getHasFullAccess()
    {
        return $this->hasFullAccess;
    }

    /**
     * @return string
     */
    public function getWmid()
    {
        return $this->wmid;
    }

    /**
     * @return array
     */
    public static function getPassportTypes()
    {
        return static::$passportTypes;
    }

    /**
     * @return array
     */
    public static function getLegalStatuses()
    {
        return static::$legalStatuses;
    }

    /**
     * @return array
     */
    public static function getLegalPositionStatuses()
    {
        return static::$legalPositionStatuses;
    }

    /**
     * @return Passport
     */
    public function getPassport()
    {
        return $this->passport;
    }

    /**
     * @return Wmid[]
     */
    public function getWmids()
    {
        return $this->wmids;
    }

    /**
     * @return UserInfo
     */
    public function getUserInfo()
    {
        return $this->userInfo;
    }

    /**
     * @return CheckLock
     */
    public function getCheckLock()
    {
        return $this->checkLock;
    }

    /**
     * @return WebList
     */
    public function getWebList()
    {
        return $this->webList;
    }

    /**
     * @return ExtendedData
     */
    public function getExtendedData()
    {
        return $this->extendedData;
    }

    /**
     * @param \SimpleXMLElement $xml
     *
     * @return array
     */
    protected function dirtyXmlToArray(\SimpleXMLElement $xml)
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
    protected function rowAttributesXmlToArray($xml)
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
