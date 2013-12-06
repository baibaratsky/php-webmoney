<?php
namespace Baibaratsky\WebMoney\Api\X\X11;

class UserInfo
{
    /** @var int ctype */
    private $_legalStatus;

    /** @var int jstatus */
    private $_legalPositionStatus;

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
        $this->_legalStatus = (int)$params['ctype'];
        $this->_legalPositionStatus = (int)$params['jstatus'];
        $this->_basisActs = $params['osnovainfo'];
        $this->_locked = (bool)$params['locked'];
        $this->_nickname = $params['nickname'];
        $this->_additionalInformation = $params['infoopen'];
        $this->_city = $params['city'];
        $this->_region = $params['region'];
        if (isset($params['citid'])) {
            $this->_cityId = (int)$params['citid'];
        }
        $this->_countryId = (int)$params['countryid'];
        $this->_country = $params['country'];
        $this->_zipCode = (int)$params['zipcode'];
        $this->_address = $params['adres'];
        $this->_lastName = $params['fname'];
        $this->_firstName = $params['iname'];
        $this->_middleName = $params['oname'];
        $this->_passportNum = (int)$params['pnomer'];
        $this->_passportDate = $params['pdate'];
        if (isset($params['pday'])) {
            $this->_passportDay = (int)$params['pday'];
        }
        if (isset($params['pmonth'])) {
            $this->_passportMonth = (int)$params['pmonth'];
        }
        if (isset($params['pyear'])) {
            $this->_passportYear = (int)$params['pyear'];
        }
        if (isset($params['pdateMMDDYYYY'])) {
            $this->_passportFormattedDate = $params['pdateMMDDYYYY'];
        }
        $this->_passportCountryId = (int)$params['pcountryid'];
        $this->_passportCountry = $params['pcountry'];
        $this->_passportCity = $params['pcity'];
        if (isset($params['pcitid'])) {
            $this->_passportCityId = (int)$params['pcitid'];
        }
        $this->_passportPlace = $params['pbywhom'];
        if (isset($params['ncountryid'])) {
            $this->_nCountryId = (int)$params['ncountryid'];
        }
        if (isset($params['ncountry'])) {
            $this->_nCountry = $params['ncountry'];
        }
        if (isset($params['ntype'])) {
            $this->_nType = (int)$params['ntype'];
        }
        $this->_residenceCountryId = (int)$params['rcountryid'];
        $this->_residenceCountry = $params['rcountry'];
        $this->_residenceCity = $params['rcity'];
        if (isset($params['rcitid'])) {
            $this->_residenceCityId = (int)$params['rcitid'];
        }
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
        if (isset($params['pasdoc'])) {
            $this->_passportVerification = (bool)$params['pasdoc'];
        }
        if (isset($params['inndoc'])) {
            $this->_tinVerification = (bool)$params['inndoc'];
        }
        $this->_jabberId = $params['jabberid'];
        $this->_sex = $params['sex'];
        if (isset($params['permis'])) {
            $this->_permis = $params['permis'];
        }
        if (isset($params['regcheck'])) {
            $this->_regCheck = $params['regcheck'];
        }
    }

    /**
     * @return int
     */
    public function getLegalStatus()
    {
        return $this->_legalStatus;
    }

    /**
     * @return int
     */
    public function getLegalPositionStatus()
    {
        return $this->_legalPositionStatus;
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
