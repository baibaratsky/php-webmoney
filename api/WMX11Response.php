<?php

/**
 * Class WMX11Response
 *
 * @link https://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X11
 */
class WMX11Response extends WMApiResponse
{
    /** @var int /@retval */
    protected $_returnCode;

    /** @var string /@retdesc */
    protected $_returnDescription;

    /** @var int fullaccess */
    protected $_hasFullAccess;

    /** @var string certinfo/@wmid */
    protected $_wmid;

    /** @var array certinfo/directory/tid */
    protected static $_certificateTypes;

    /** @var array certinfo/directory/ctype */
    protected static $_legalStatuses;

    /** @var array certinfo/directory/jstatus */
    protected static $_legalPositionStatuses;

    /** @var WMX11ResponseCertificate[] certinfo/attestat */
    protected $_certificates = array();

    /** @var WMX11ResponseWmid[] certinfo/wmids */
    protected $_wmids = array();

    /** @var WMX11ResponseUserInfo[] certinfo/userinfo/value */
    protected $_userInfo = array();

    /** @var WMX11ResponseCheckLock[] certinfo/userinfo/check-lock */
    protected $_checkLock = array();

    /** @var WMX11ResponseWebList[] certinfo/userinfo/weblist */
    protected $_webList = array();

    /** @var WMX11ResponseExtendedData[] certinfo/userinfo/extendeddata */
    protected $_extendedData = array();

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

        if ($certInfo->directory !== null) {
            static::$_legalStatuses = $this->_dirtyXmlToArray($certInfo->directory->ctype);
            static::$_legalPositionStatuses = $this->_dirtyXmlToArray($certInfo->directory->jstatus);
            static::$_certificateTypes = $this->_dirtyXmlToArray($certInfo->directory->tid);
        }

        if ($certInfo->attestat !== null) {
            foreach ($this->_rowAttributesXmlToArray($certInfo->attestat) as $certificate) {
                $this->_certificates[] = new WMX11ResponseCertificate($certificate);
            }
        }

        if ($certInfo->wmids !== null) {
            foreach ($this->_rowAttributesXmlToArray($certInfo->wmids) as $wmid) {
                $this->_wmids[] = new WMX11ResponseWmid($wmid);
            }
        }

        if ($certInfo->userinfo !== null) {
            if ($certInfo->userinfo->value !== null) {
                foreach ($this->_rowAttributesXmlToArray($certInfo->userinfo->value) as $userInfo) {
                    $this->_userInfo[] = new WMX11ResponseUserInfo($userInfo);
                }
            }

            if ($certInfo->userinfo->{'check-lock'} !== null) {
                foreach ($this->_rowAttributesXmlToArray($certInfo->userinfo->{'check-lock'}) as $checkLock) {
                    $this->_checkLock[] = new WMX11ResponseCheckLock($checkLock);
                }
            }

            if ($certInfo->userinfo->weblist !== null) {
                foreach ($this->_rowAttributesXmlToArray($certInfo->userinfo->weblist) as $webList) {
                    $this->_webList[] = new WMX11ResponseWebList($webList);
                }
            }

            if ($certInfo->userinfo->extendeddata !== null) {
                foreach ($this->_rowAttributesXmlToArray($certInfo->userinfo->extendeddata) as $extendedData) {
                    $this->_extendedData[] = new WMX11ResponseExtendedData($extendedData);
                }
            }
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
    public static function getCertificateTypes()
    {
        return static::$_certificateTypes;
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
     * @return WMX11ResponseCertificate[]
     */
    public function getCertificates()
    {
        return $this->_certificates;
    }

    /**
     * @return WMX11ResponseWmid[]
     */
    public function getWmids()
    {
        return $this->_wmids;
    }

    /**
     * @return WMX11ResponseUserInfo[]
     */
    public function getUserInfo()
    {
        return $this->_userInfo;
    }

    /**
     * @return WMX11ResponseCheckLock[]
     */
    public function getCheckLock()
    {
        return $this->_checkLock;
    }

    /**
     * @return WMX11ResponseWebList[]
     */
    public function getWebList()
    {
        return $this->_webList;
    }

    /**
     * @return WMX11ResponseExtendedData[]
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

class WMX11ResponseCertificate
{
    /** @var int cid */
    private $_id;

    /** @var int regcid */
    private $_registrantId;

    /** @var int tid */
    private $_typeId;

    /** @var bool locked */
    private $_rightToIssue;

    /** @var bool admlocked */
    private $_admRightToIssue;

    /** @var bool recalled */
    private $_recalled;

    /** @var string datecrt */
    private $_issuanceDt;

    /** @var int datediff */
    private $_issuanceDiff;

    /** @var string regnickname */
    private $_registrantNickname;

    /** @var string regwmid */
    private $_registrantWmid;

    /** @var string status */
    private $_status;

    /** @var string notary */
    private $_notary;

    /**
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->_id = (int)$params['cid'];
        $this->_registrantId = (int)$params['regcid'];
        $this->_typeId = (int)$params['tid'];
        $this->_rightToIssue = (bool)$params['locked'];
        $this->_admRightToIssue = (bool)$params['admlocked'];
        $this->_recalled = (bool)$params['recalled'];
        $this->_issuanceDt = $params['datecrt'];
        $this->_issuanceDiff = (int)$params['datediff'];
        $this->_registrantNickname = $params['regnickname'];
        $this->_registrantWmid = $params['regwmid'];
        $this->_status = $params['status'];
        $this->_notary = $params['notary'];
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @return int
     */
    public function getRegistrantId()
    {
        return $this->_registrantId;
    }

    /**
     * @return int
     */
    public function getTypeId()
    {
        return $this->_typeId;
    }

    /**
     * @return bool
     */
    public function getRightToIssue()
    {
        return $this->_rightToIssue;
    }


    /**
     * @return bool
     */
    public function getAdmRightToIssue()
    {
        return $this->_admRightToIssue;
    }

    /**
     * @return bool
     */
    public function getRecalled()
    {
        return $this->_recalled;
    }

    /**
     * @return string
     */
    public function getIssuanceDt()
    {
        return $this->_issuanceDt;
    }

    /**
     * @return int
     */
    public function getIssuanceDiff()
    {
        return $this->_issuanceDiff;
    }

    /**
     * @return string
     */
    public function getRegistrantNickname()
    {
        return $this->_registrantNickname;
    }

    /**
     * @return string
     */
    public function getRegistrantWmid()
    {
        return $this->_registrantWmid;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->_status;
    }

    /**
     * @return string
     */
    public function getNotary()
    {
        return $this->_notary;
    }
}

class WMX11ResponseWmid
{
    /** @var string wmid */
    private $_wmid;

    /** @var string info */
    private $_information;

    /** @var string nickname */
    private $_nickname;

    /** @var string datereg */
    private $_registrationDt;

    /** @var int yearreg */
    private $_registrationYear;

    /** @var int monthreg */
    private $_registrationMonth;

    /** @var int dayreg */
    private $_registrationDay;

    /** @var string timereg */
    private $_registrationTime;

    /** @var int ctype */
    private $_certificateTypeId;

    /** @var string companyname */
    private $_companyName;

    /** @var int companyid */
    private $_companyId;

    /** @var string phone */
    private $_phone;

    /** @var string email */
    private $_email;

    /** @var string phone-check-lock */
    private $_phoneCheckLock;

    /** @var string email-check-lock */
    private $_emailCheckLock;

    /**
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->_wmid = $params['wmid'];
        $this->_information = $params['info'];
        $this->_nickname = $params['nickname'];
        $this->_registrationDt = $params['datereg'];
        $this->_registrationYear = (int)$params['yearreg'];
        $this->_registrationMonth = (int)$params['monthreg'];
        $this->_registrationDay = (int)$params['dayreg'];
        $this->_registrationTime = $params['timereg'];
        $this->_certificateTypeId = (int)$params['ctype'];
        $this->_companyName = $params['companyname'];
        $this->_companyId = (int)$params['companyid'];
        $this->_phone = $params['phone'];
        $this->_email = $params['email'];
        $this->_phoneCheckLock = $params['phone-check-lock'];
        $this->_emailCheckLock = $params['email-check-lock'];
    }

    /**
     * @return string
     */
    public function getWmid()
    {
        return $this->_wmid;
    }

    /**
     * @return string
     */
    public function getInformation()
    {
        return $this->_information;
    }

    /**
     * @return string
     */
    public function getNickname()
    {
        return $this->_nickname;
    }

    /**
     * @return string
     */
    public function getRegistrationDt()
    {
        return $this->_registrationDt;
    }

    /**
     * @return int
     */
    public function getRegistrationYear()
    {
        return $this->_registrationYear;
    }

    /**
     * @return int
     */
    public function getRegistrationMonth()
    {
        return $this->_registrationMonth;
    }

    /**
     * @return int
     */
    public function getRegistrationDay()
    {
        return $this->_registrationDay;
    }

    /**
     * @return string
     */
    public function getRegistrationTime()
    {
        return $this->_registrationTime;
    }

    /**
     * @return int
     */
    public function getCertificateTypeId()
    {
        return $this->_certificateTypeId;
    }

    /**
     * @return string
     */
    public function getCompanyName()
    {
        return $this->_companyName;
    }

    /**
     * @return int
     */
    public function getCompanyId()
    {
        return $this->_companyId;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->_phone;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * @return string
     */
    public function getPhoneCheckLock()
    {
        return $this->_phoneCheckLock;
    }

    /**
     * @return string
     */
    public function getEmailCheckLock()
    {
        return $this->_emailCheckLock;
    }
}

class WMX11ResponseUserInfo
{
    /** @var int ctype */
    private $_legalStatusId;

    /** @var int jstatus */
    private $_legalPositionStatusId;

    /** @var string osnovainfo */
    private $_basisActs;

    /** @var bool locked */
    private $_locked;

    /** @var string nickname */
    private $_nickname;

    /** @var string infoopen */
    private $_additionalInformation;

    /** @var string city */
    private $_city;

    /** @var string region */
    private $_region;

    /** @var int citid */
    private $_cityId;

    /** @var int countryid */
    private $_countryId;

    /** @var string country */
    private $_country;

    /** @var int zipcode */
    private $_zipCode;

    /** @var string adres */
    private $_address;

    /** @var string fname */
    private $_lastName;

    /** @var string iname */
    private $_firstName;

    /** @var string oname */
    private $_middleName;

    /** @var int pnomer */
    private $_passportNum;

    /** @var string pdate */
    private $_passportDate;

    /** @var int pday */
    private $_passportDay;

    /** @var int pmonth */
    private $_passportMonth;

    /** @var int pyear */
    private $_passportYear;

    /** @var string pdateMMDDYYYY */
    private $_passportFormattedDate;

    /** @var int pcountryid */
    private $_passportCountryId;

    /** @var string pcountry */
    private $_passportCountry;

    /** @var string pcity */
    private $_passportCity;

    /** @var int pcitid */
    private $_passportCityId;

    /** @var string pbywhom */
    private $_passportPlace;

    /** @var int ncountryid */
    private $_nCountryId;

    /** @var string ncountry */
    private $_nCountry;

    /** @var int ntype */
    private $_nType;

    /** @var int rcountryid */
    private $_residenceCountryId;

    /** @var string rcountry */
    private $_residenceCountry;

    /** @var string rcity */
    private $_residenceCity;

    /** @var int rcitid */
    private $_residenceCityId;

    /** @var string radres */
    private $_residenceAddress;

    /** @var string bplace */
    private $_birthPlace;

    /** @var int bday */
    private $_birthDay;

    /** @var int bmonth */
    private $_birthMonth;

    /** @var int byear */
    private $_birthYear;

    /** @var string name */
    private $_organizationName;

    /** @var string dirfio */
    private $_directorFullName;

    /** @var string buhfio */
    private $_chiefAccountantFullName;

    /** @var string inn */
    private $_tin;

    /** @var string okpo */
    private $_okpo;

    /** @var string okonx */
    private $_okved;

    /** @var string jadres */
    private $_legalAddress;

    /** @var string jcountry */
    private $_legalCountry;

    /** @var int jcountryid */
    private $_legalCountryId;

    /** @var string jcity */
    private $_legalCity;

    /** @var int jzipcode */
    private $_legalZipCode;

    /** @var string bankname */
    private $_bankName;

    /** @var string bik */
    private $_bic;

    /** @var string ks */
    private $_corrAccount;

    /** @var string rs */
    private $_currentAccount;

    /** @var string phonehome */
    private $_homePhone;

    /** @var string phonemobile */
    private $_mobilePhone;

    /** @var string icq */
    private $_icq;

    /** @var string fax */
    private $_fax;

    /** @var string phone */
    private $_contactPhone;

    /** @var string email */
    private $_email;

    /** @var string web */
    private $_url;

    /** @var string cap_owner */
    private $_capitallerFounderWmid;

    /** @var bool pasdoc */
    private $_passportVerification;

    /** @var bool inndoc */
    private $_tinVerification;

    /** @var string jabberid */
    private $_jabberId;

    /** @var string sex */
    private $_sex;

    /** @var string permis */
    private $_permis;

    /** @var string regcheck */
    private $_regCheck;

    /**
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->_legalStatusId = (int)$params['ctype'];
        $this->_legalPositionStatusId = (int)$params['jstatus'];
        $this->_basisActs = $params['osnovainfo'];
        $this->_locked = (bool)$params['locked'];
        $this->_nickname = $params['nickname'];
        $this->_additionalInformation = $params['infoopen'];
        $this->_city = $params['city'];
        $this->_region = $params['region'];
        $this->_cityId = (int)$params['citid'];
        $this->_countryId = (int)$params['countryid'];
        $this->_country = $params['country'];
        $this->_zipCode = (int)$params['zipcode'];
        $this->_address = $params['adres'];
        $this->_lastName = $params['fname'];
        $this->_firstName = $params['iname'];
        $this->_middleName = $params['oname'];
        $this->_passportNum = (int)$params['pnomer'];
        $this->_passportDate = $params['pdate'];
        $this->_passportDay = (int)$params['pday'];
        $this->_passportMonth = (int)$params['pmonth'];
        $this->_passportYear = (int)$params['pyear'];
        $this->_passportFormattedDate = $params['pdateMMDDYYYY'];
        $this->_passportCountryId = (int)$params['pcountryid'];
        $this->_passportCountry = $params['pcountry'];
        $this->_passportCity = $params['pcity'];
        $this->_passportCityId = (int)$params['pcitid'];
        $this->_passportPlace = $params['pbywhom'];
        $this->_nCountryId = (int)$params['ncountryid'];
        $this->_nCountry = $params['ncountry'];
        $this->_nType = (int)$params['ntype'];
        $this->_residenceCountryId = (int)$params['rcountryid'];
        $this->_residenceCountry = $params['rcountry'];
        $this->_residenceCity = $params['rcity'];
        $this->_residenceCityId = (int)$params['rcitid'];
        $this->_residenceAddress = $params['radres'];
        $this->_birthPlace = $params['bplace'];
        $this->_birthDay = (int)$params['bday'];
        $this->_birthMonth = (int)$params['bmonth'];
        $this->_birthYear = (int)$params['byear'];
        $this->_organizationName = $params['name'];
        $this->_directorFullName = $params['dirfio'];
        $this->_chiefAccountantFullName = $params['buhfio'];
        $this->_tin = $params['inn'];
        $this->_okpo = $params['okpo'];
        $this->_okved = $params['okonx'];
        $this->_legalAddress = $params['jadres'];
        $this->_legalCountry = $params['jcountry'];
        $this->_legalCountryId = (int)$params['jcountryid'];
        $this->_legalCity = $params['jcity'];
        $this->_legalZipCode = $params['jzipcode'];
        $this->_bankName = $params['bankname'];
        $this->_bic = $params['bik'];
        $this->_corrAccount = $params['ks'];
        $this->_currentAccount = $params['rs'];
        $this->_homePhone = $params['phonehome'];
        $this->_mobilePhone = $params['phonemobile'];
        $this->_icq = $params['icq'];
        $this->_fax = $params['fax'];
        $this->_contactPhone = $params['phone'];
        $this->_email = $params['email'];
        $this->_url = $params['web'];
        $this->_capitallerFounderWmid = $params['cap_owner'];
        $this->_passportVerification = (bool)$params['pasdoc'];
        $this->_tinVerification = (bool)$params['inndoc'];
        $this->_jabberId = $params['jabberid'];
        $this->_sex = $params['sex'];
        $this->_permis = $params['permis'];
        $this->_regCheck = $params['regcheck'];
    }

    /**
     * @return int
     */
    public function getLegalStatusId()
    {
        return $this->_legalStatusId;
    }

    /**
     * @return int
     */
    public function getLegalPositionStatusId()
    {
        return $this->_legalPositionStatusId;
    }

    /**
     * @return string
     */
    public function getBasisActs()
    {
        return $this->_basisActs;
    }

    /**
     * @return bool
     */
    public function getLocked()
    {
        return $this->_locked;
    }

    /**
     * @return string
     */
    public function getNickname()
    {
        return $this->_nickname;
    }

    /**
     * @return string
     */
    public function getAdditionalInformation()
    {
        return $this->_additionalInformation;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->_city;
    }

    /**
     * @return string
     */
    public function getRegion()
    {
        return $this->_region;
    }

    /**
     * @return int
     */
    public function getCityId()
    {
        return $this->_cityId;
    }

    /**
     * @return int
     */
    public function getCountryId()
    {
        return $this->_countryId;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->_country;
    }

    /**
     * @return int
     */
    public function getZipCode()
    {
        return $this->_zipCode;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->_address;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->_lastName;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->_firstName;
    }

    /**
     * @return string
     */
    public function getMiddleName()
    {
        return $this->_middleName;
    }

    /**
     * @return int
     */
    public function getPassportNum()
    {
        return $this->_passportNum;
    }

    /**
     * @return string
     */
    public function getPassportDate()
    {
        return $this->_passportDate;
    }

    /**
     * @return int
     */
    public function getPassportDay()
    {
        return $this->_passportDay;
    }

    /**
     * @return int
     */
    public function getPassportMonth()
    {
        return $this->_passportMonth;
    }

    /**
     * @return int
     */
    public function getPassportYear()
    {
        return $this->_passportYear;
    }

    /**
     * @return string
     */
    public function getPassportFormattedDate()
    {
        return $this->_passportFormattedDate;
    }

    /**
     * @return int
     */
    public function getPassportCountryId()
    {
        return $this->_passportCountryId;
    }

    /**
     * @return string
     */
    public function getPassportCountry()
    {
        return $this->_passportCountry;
    }

    /**
     * @return string
     */
    public function getPassportCity()
    {
        return $this->_passportCity;
    }

    /**
     * @return int
     */
    public function getPassportCityId()
    {
        return $this->_passportCityId;
    }

    /**
     * @return string
     */
    public function getPassportPlace()
    {
        return $this->_passportPlace;
    }

    /**
     * @return int
     */
    public function getNCountryId()
    {
        return $this->_nCountryId;
    }

    /**
     * @return string
     */
    public function getNCountry()
    {
        return $this->_nCountry;
    }

    /**
     * @return int
     */
    public function getNType()
    {
        return $this->_nType;
    }

    /**
     * @return int
     */
    public function getResidenceCountryId()
    {
        return $this->_residenceCountryId;
    }

    /**
     * @return string
     */
    public function getResidenceCountry()
    {
        return $this->_residenceCountry;
    }

    /**
     * @return string
     */
    public function getResidenceCity()
    {
        return $this->_residenceCity;
    }

    /**
     * @return int
     */
    public function getResidenceCityId()
    {
        return $this->_residenceCityId;
    }

    /**
     * @return string
     */
    public function getResidenceAddress()
    {
        return $this->_residenceAddress;
    }

    /**
     * @return string
     */
    public function getBirthPlace()
    {
        return $this->_birthPlace;
    }

    /**
     * @return int
     */
    public function getBirthDay()
    {
        return $this->_birthDay;
    }

    /**
     * @return int
     */
    public function getBirthMonth()
    {
        return $this->_birthMonth;
    }

    /**
     * @return int
     */
    public function getBirthYear()
    {
        return $this->_birthYear;
    }

    /**
     * @return string
     */
    public function getOrganizationName()
    {
        return $this->_organizationName;
    }

    /**
     * @return string
     */
    public function getDirectorFullName()
    {
        return $this->_directorFullName;
    }

    /**
     * @return string
     */
    public function getChiefAccountantFullName()
    {
        return $this->_chiefAccountantFullName;
    }

    /**
     * @return string
     */
    public function getTin()
    {
        return $this->_tin;
    }

    /**
     * @return string
     */
    public function getOkpo()
    {
        return $this->_okpo;
    }

    /**
     * @return string
     */
    public function getOkved()
    {
        return $this->_okved;
    }

    /**
     * @return string
     */
    public function getLegalAddress()
    {
        return $this->_legalAddress;
    }

    /**
     * @return string
     */
    public function getLegalCountry()
    {
        return $this->_legalCountry;
    }

    /**
     * @return int
     */
    public function getLegalCountryId()
    {
        return $this->_legalCountryId;
    }

    /**
     * @return string
     */
    public function getLegalCity()
    {
        return $this->_legalCity;
    }

    /**
     * @return int
     */
    public function getLegalZipCode()
    {
        return $this->_legalZipCode;
    }

    /**
     * @return string
     */
    public function getBankName()
    {
        return $this->_bankName;
    }

    /**
     * @return string
     */
    public function getBic()
    {
        return $this->_bic;
    }

    /**
     * @return string
     */
    public function getCorrAccount()
    {
        return $this->_corrAccount;
    }

    /**
     * @return string
     */
    public function getCurrentAccount()
    {
        return $this->_currentAccount;
    }

    /**
     * @return string
     */
    public function getHomePhone()
    {
        return $this->_homePhone;
    }

    /**
     * @return string
     */
    public function getMobilePhone()
    {
        return $this->_mobilePhone;
    }

    /**
     * @return string
     */
    public function getIcq()
    {
        return $this->_icq;
    }

    /**
     * @return string
     */
    public function getFax()
    {
        return $this->_fax;
    }

    /**
     * @return string
     */
    public function getContactPhone()
    {
        return $this->_contactPhone;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->_url;
    }

    /**
     * @return string
     */
    public function getCapitallerFounderWmid()
    {
        return $this->_capitallerFounderWmid;
    }

    /**
     * @return bool
     */
    public function getPassportVerification()
    {
        return $this->_passportVerification;
    }

    /**
     * @return bool
     */
    public function getTinVerification()
    {
        return $this->_tinVerification;
    }

    /**
     * @return string
     */
    public function getJabberId()
    {
        return $this->_jabberId;
    }

    /**
     * @return string
     */
    public function getSex()
    {
        return $this->_sex;
    }

    /**
     * @return string
     */
    public function getPermis()
    {
        return $this->_permis;
    }

    /**
     * @return string
     */
    public function getRegCheck()
    {
        return $this->_regCheck;
    }
}

class WMX11ResponseCheckLock
{
    /** @var string ctype */
    private $_certificateTypeId;

    /** @var string jstatus */
    private $_legalPositionStatusId;

    /** @var string osnovainfo */
    private $_basisActs;

    /** @var string nickname */
    private $_nickName;

    /** @var string infoopen */
    private $_additionalInformation;

    /** @var string city */
    private $_city;

    /** @var string region */
    private $_region;

    /** @var string country */
    private $_country;

    /** @var string adres */
    private $_address;

    /** @var string zipcode */
    private $_zipCode;

    /** @var string fname */
    private $_lastName;

    /** @var string iname */
    private $_firstName;

    /** @var string oname */
    private $_middleName;

    /** @var string pnomer */
    private $_passportNum;

    /** @var string pdate */
    private $_passportDate;

    /** @var string pbywhom */
    private $_passportIssuePlace;

    /** @var string pcountry */
    private $_passportIssueCountry;

    /** @var string pcity */
    private $_passportIssueCity;

    /** @var string ncountryid */
    private $_nCountryId;

    /** @var string ncountry */
    private $_nCountry;

    /** @var string rcountry */
    private $_residenceCountry;

    /** @var string rcity */
    private $_residenceCity;

    /** @var string radres */
    private $_residenceAddress;

    /** @var string bplace */
    private $_birthPlace;

    /** @var string bday */
    private $_birthday;

    /** @var string inn */
    private $_tin;

    /** @var string name */
    private $_organizationName;

    /** @var string dirfio */
    private $_directorFullName;

    /** @var string buhfio */
    private $_chiefAccountantFullName;

    /** @var string okpo */
    private $_okpo;

    /** @var string okonx */
    private $_okved;

    /** @var string jadres */
    private $_legalAddress;

    /** @var string jcountry */
    private $_legalCountry;

    /** @var string jzipcode */
    private $_legalZipCode;

    /** @var string bankname */
    private $_bankName;

    /** @var string bik */
    private $_bic;

    /** @var string ks */
    private $_corrAccount;

    /** @var string rs */
    private $_currentAccount;

    /** @var string fax */
    private $_fax;

    /** @var string email */
    private $_email;

    /** @var string web */
    private $_url;

    /** @var string phone */
    private $_contactPhone;

    /** @var string phonehome */
    private $_homePhone;

    /** @var string phonemobile */
    private $_mobilePhone;

    /** @var string icq */
    private $_icq;

    /** @var string jabberid */
    private $_jabberId;

    /** @var string sex */
    private $_sex;

    /**
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->_certificateTypeId = $params['ctype'];
        $this->_legalPositionStatusId = $params['jstatus'];
        $this->_basisActs = $params['osnovainfo'];
        $this->_nickName = $params['nickname'];
        $this->_additionalInformation = $params['infoopen'];
        $this->_city = $params['city'];
        $this->_region = $params['region'];
        $this->_country = $params['country'];
        $this->_address = $params['adres'];
        $this->_zipCode = $params['zipcode'];
        $this->_lastName = $params['fname'];
        $this->_firstName = $params['iname'];
        $this->_middleName = $params['oname'];
        $this->_passportNum = $params['pnomer'];
        $this->_passportDate = $params['pdate'];
        $this->_passportIssuePlace = $params['pbywhom'];
        $this->_passportIssueCountry = $params['pcountry'];
        $this->_passportIssueCity = $params['pcity'];
        $this->_nCountryId = $params['ncountryid'];
        $this->_nCountry = $params['ncountry'];
        $this->_residenceCountry = $params['rcountry'];
        $this->_residenceCity = $params['rcity'];
        $this->_residenceAddress = $params['radres'];
        $this->_birthPlace = $params['bplace'];
        $this->_birthday = $params['bday'];
        $this->_tin = $params['inn'];
        $this->_organizationName = $params['name'];
        $this->_directorFullName = $params['dirfio'];
        $this->_chiefAccountantFullName = $params['buhfio'];
        $this->_okpo = $params['okpo'];
        $this->_okved = $params['okonx'];
        $this->_legalAddress = $params['jadres'];
        $this->_legalCountry = $params['jcountry'];
        $this->_legalZipCode = $params['jzipcode'];
        $this->_bankName = $params['bankname'];
        $this->_bic = $params['bik'];
        $this->_corrAccount = $params['ks'];
        $this->_currentAccount = $params['rs'];
        $this->_fax = $params['fax'];
        $this->_email = $params['email'];
        $this->_url = $params['web'];
        $this->_contactPhone = $params['phone'];
        $this->_homePhone = $params['phonehome'];
        $this->_mobilePhone = $params['phonemobile'];
        $this->_icq = $params['icq'];
        $this->_jabberId = $params['jabberid'];
        $this->_sex = $params['sex'];
    }

    /**
     * @return string
     */
    public function getCertificateTypeId()
    {
        return $this->_certificateTypeId;
    }

    /**
     * @return string
     */
    public function getLegalPositionStatusId()
    {
        return $this->_legalPositionStatusId;
    }

    /**
     * @return string
     */
    public function getBasisActs()
    {
        return $this->_basisActs;
    }

    /**
     * @return string
     */
    public function getNickName()
    {
        return $this->_nickName;
    }

    /**
     * @return string
     */
    public function getAdditionalInformation()
    {
        return $this->_additionalInformation;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->_city;
    }

    /**
     * @return string
     */
    public function getRegion()
    {
        return $this->_region;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->_country;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->_address;
    }

    /**
     * @return string
     */
    public function getZipCode()
    {
        return $this->_zipCode;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->_lastName;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->_firstName;
    }

    /**
     * @return string
     */
    public function getMiddleName()
    {
        return $this->_middleName;
    }

    /**
     * @return string
     */
    public function getPassportNum()
    {
        return $this->_passportNum;
    }

    /**
     * @return string
     */
    public function getPassportDate()
    {
        return $this->_passportDate;
    }

    /**
     * @return string
     */
    public function getPassportIssuePlace()
    {
        return $this->_passportIssuePlace;
    }

    /**
     * @return string
     */
    public function getPassportIssueCountry()
    {
        return $this->_passportIssueCountry;
    }

    /**
     * @return string
     */
    public function getPassportIssueCity()
    {
        return $this->_passportIssueCity;
    }

    /**
     * @return string
     */
    public function getNCountryId()
    {
        return $this->_nCountryId;
    }

    /**
     * @return string
     */
    public function getNCountry()
    {
        return $this->_nCountry;
    }

    /**
     * @return string
     */
    public function getResidenceCountry()
    {
        return $this->_residenceCountry;
    }

    /**
     * @return string
     */
    public function getResidenceCity()
    {
        return $this->_residenceCity;
    }

    /**
     * @return string
     */
    public function getResidenceAddress()
    {
        return $this->_residenceAddress;
    }

    /**
     * @return string
     */
    public function getBirthPlace()
    {
        return $this->_birthPlace;
    }

    /**
     * @return string
     */
    public function getBirthday()
    {
        return $this->_birthday;
    }

    /**
     * @return string
     */
    public function getTin()
    {
        return $this->_tin;
    }

    /**
     * @return string
     */
    public function getOrganizationName()
    {
        return $this->_organizationName;
    }

    /**
     * @return string
     */
    public function getDirectorFullName()
    {
        return $this->_directorFullName;
    }

    /**
     * @return string
     */
    public function getChiefAccountantFullName()
    {
        return $this->_chiefAccountantFullName;
    }

    /**
     * @return string
     */
    public function getOkpo()
    {
        return $this->_okpo;
    }

    /**
     * @return string
     */
    public function getOkved()
    {
        return $this->_okved;
    }

    /**
     * @return string
     */
    public function getLegalAddress()
    {
        return $this->_legalAddress;
    }

    /**
     * @return string
     */
    public function getLegalCountry()
    {
        return $this->_legalCountry;
    }

    /**
     * @return string
     */
    public function getLegalZipCode()
    {
        return $this->_legalZipCode;
    }

    /**
     * @return string
     */
    public function getBankName()
    {
        return $this->_bankName;
    }

    /**
     * @return string
     */
    public function getBic()
    {
        return $this->_bic;
    }

    /**
     * @return string
     */
    public function getCorrAccount()
    {
        return $this->_corrAccount;
    }

    /**
     * @return string
     */
    public function getCurrentAccount()
    {
        return $this->_currentAccount;
    }

    /**
     * @return string
     */
    public function getFax()
    {
        return $this->_fax;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->_url;
    }

    /**
     * @return string
     */
    public function getContactPhone()
    {
        return $this->_contactPhone;
    }

    /**
     * @return string
     */
    public function getHomePhone()
    {
        return $this->_homePhone;
    }

    /**
     * @return string
     */
    public function getMobilePhone()
    {
        return $this->_mobilePhone;
    }

    /**
     * @return string
     */
    public function getIcq()
    {
        return $this->_icq;
    }

    /**
     * @return string
     */
    public function getJabberId()
    {
        return $this->_jabberId;
    }

    /**
     * @return string
     */
    public function getSex()
    {
        return $this->_sex;
    }
}

class WMX11ResponseWebList
{
    /** @var string url */
    private $_url;

    /** @var string check-lock */
    private $_checkLock;

    /** @var bool ischeck */
    private $_isCheck;

    /** @var bool islock */
    private $_isLock;

    /**
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->_url = $params['url'];
        $this->_checkLock = $params['check-lock'];
        $this->_isCheck = $params['ischeck'];
        $this->_isLock = $params['islock'];
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->_url;
    }

    /**
     * @return string
     */
    public function getCheckLock()
    {
        return $this->_checkLock;
    }

    /**
     * @return boolean
     */
    public function getIsCheck()
    {
        return $this->_isCheck;
    }

    /**
     * @return boolean
     */
    public function getIsLock()
    {
        return $this->_isLock;
    }
}

class WMX11ResponseExtendedData
{
    /** @var string type */
    private $_type;

    /** @var string account */
    private $_account;

    /** @var string check-lock */
    private $_checkLock;

    /**
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->_type = $params['type'];
        $this->_account = $params['account'];
        $this->_checkLock = $params['check-lock'];
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * @return string
     */
    public function getAccount()
    {
        return $this->_account;
    }

    /**
     * @return string
     */
    public function getCheckLock()
    {
        return $this->_checkLock;
    }
}
