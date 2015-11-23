<?php

namespace baibaratsky\WebMoney\Api\X\X11;

class UserInfo
{
    /** @var int ctype */
    private $legalStatus;

    /** @var int jstatus */
    private $legalPositionStatus;

    /** @var string osnovainfo */
    private $basisActs;

    /** @var bool locked */
    private $locked;

    /** @var string nickname */
    private $nickname;

    /** @var string infoopen */
    private $additionalInformation;

    /** @var string city */
    private $city;

    /** @var string region */
    private $region;

    /** @var int citid */
    private $cityId;

    /** @var int countryid */
    private $countryId;

    /** @var string country */
    private $country;

    /** @var int zipcode */
    private $zipCode;

    /** @var string adres */
    private $address;

    /** @var string fname */
    private $lastName;

    /** @var string iname */
    private $firstName;

    /** @var string oname */
    private $middleName;

    /** @var string pnomer */
    private $passportNum;

    /** @var string pdate */
    private $passportDate;

    /** @var string pdateend */
    private $passportDateEnd;

    /** @var int pday */
    private $passportDay;

    /** @var int pmonth */
    private $passportMonth;

    /** @var int pyear */
    private $passportYear;

    /** @var string pdateMMDDYYYY */
    private $passportFormattedDate;

    /** @var int pcountryid */
    private $passportCountryId;

    /** @var string pcountry */
    private $passportCountry;

    /** @var string pcity */
    private $passportCity;

    /** @var int pcitid */
    private $passportCityId;

    /** @var string pbywhom */
    private $passportPlace;

    /** @var int ncountryid */
    private $nCountryId;

    /** @var string ncountry */
    private $nCountry;

    /** @var int ntype */
    private $nType;

    /** @var int rcountryid */
    private $residenceCountryId;

    /** @var string rcountry */
    private $residenceCountry;

    /** @var string rcity */
    private $residenceCity;

    /** @var int rcitid */
    private $residenceCityId;

    /** @var string radres */
    private $residenceAddress;

    /** @var string bplace */
    private $birthPlace;

    /** @var int bday */
    private $birthDay;

    /** @var int bmonth */
    private $birthMonth;

    /** @var int byear */
    private $birthYear;

    /** @var string name */
    private $organizationName;

    /** @var string dirfio */
    private $directorFullName;

    /** @var string buhfio */
    private $chiefAccountantFullName;

    /** @var string inn */
    private $tin;

    /** @var string okpo */
    private $okpo;

    /** @var string okonx */
    private $okved;

    /** @var string jadres */
    private $legalAddress;

    /** @var string jcountry */
    private $legalCountry;

    /** @var int jcountryid */
    private $legalCountryId;

    /** @var string jcity */
    private $legalCity;

    /** @var int jzipcode */
    private $legalZipCode;

    /** @var string bankname */
    private $bankName;

    /** @var string bik */
    private $bic;

    /** @var string ks */
    private $corrAccount;

    /** @var string rs */
    private $currentAccount;

    /** @var string phonehome */
    private $homePhone;

    /** @var string phonemobile */
    private $mobilePhone;

    /** @var string icq */
    private $icq;

    /** @var string fax */
    private $fax;

    /** @var string phone */
    private $contactPhone;

    /** @var string email */
    private $email;

    /** @var string web */
    private $url;

    /** @var string cap_owner */
    private $capitallerFounderWmid;

    /** @var bool pasdoc */
    private $passportVerification;

    /** @var bool regdoc */
    private $regVerification;

    /** @var bool inndoc */
    private $tinVerification;

    /** @var string jabberid */
    private $jabberId;

    /** @var string sex */
    private $sex;

    /** @var string permis */
    private $permis;

    /** @var string regcheck */
    private $regCheck;

    /** @var bool photoid */
    private $photoId;

    /**
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->legalStatus = (int)$params['ctype'];
        $this->legalPositionStatus = (int)$params['jstatus'];
        $this->basisActs = $params['osnovainfo'];
        $this->locked = (bool)$params['locked'];
        $this->nickname = $params['nickname'];
        $this->additionalInformation = $params['infoopen'];
        $this->city = $params['city'];
        $this->region = $params['region'];
        if (isset($params['citid'])) {
            $this->cityId = (int)$params['citid'];
        }
        $this->countryId = (int)$params['countryid'];
        $this->country = $params['country'];
        $this->zipCode = (int)$params['zipcode'];
        $this->address = $params['adres'];
        $this->lastName = $params['fname'];
        $this->firstName = $params['iname'];
        $this->middleName = $params['oname'];
        $this->passportNum = $params['pnomer'];
        $this->passportDate = $params['pdate'];
        if (isset($params['pdateend'])) {
            $this->passportDateEnd = $params['pdateend'];
        }
        if (isset($params['pday'])) {
            $this->passportDay = (int)$params['pday'];
        }
        if (isset($params['pmonth'])) {
            $this->passportMonth = (int)$params['pmonth'];
        }
        if (isset($params['pyear'])) {
            $this->passportYear = (int)$params['pyear'];
        }
        if (isset($params['pdateMMDDYYYY'])) {
            $this->passportFormattedDate = $params['pdateMMDDYYYY'];
        }
        $this->passportCountryId = (int)$params['pcountryid'];
        $this->passportCountry = $params['pcountry'];
        $this->passportCity = $params['pcity'];
        if (isset($params['pcitid'])) {
            $this->passportCityId = (int)$params['pcitid'];
        }
        $this->passportPlace = $params['pbywhom'];
        if (isset($params['ncountryid'])) {
            $this->nCountryId = (int)$params['ncountryid'];
        }
        if (isset($params['ncountry'])) {
            $this->nCountry = $params['ncountry'];
        }
        if (isset($params['ntype'])) {
            $this->nType = (int)$params['ntype'];
        }
        $this->residenceCountryId = (int)$params['rcountryid'];
        $this->residenceCountry = $params['rcountry'];
        $this->residenceCity = $params['rcity'];
        if (isset($params['rcitid'])) {
            $this->residenceCityId = (int)$params['rcitid'];
        }
        $this->residenceAddress = $params['radres'];
        $this->birthPlace = $params['bplace'];
        $this->birthDay = (int)$params['bday'];
        $this->birthMonth = (int)$params['bmonth'];
        $this->birthYear = (int)$params['byear'];
        $this->organizationName = $params['name'];
        $this->directorFullName = $params['dirfio'];
        $this->chiefAccountantFullName = $params['buhfio'];
        $this->tin = $params['inn'];
        $this->okpo = $params['okpo'];
        $this->okved = $params['okonx'];
        $this->legalAddress = $params['jadres'];
        $this->legalCountry = $params['jcountry'];
        $this->legalCountryId = (int)$params['jcountryid'];
        $this->legalCity = $params['jcity'];
        $this->legalZipCode = $params['jzipcode'];
        $this->bankName = $params['bankname'];
        $this->bic = $params['bik'];
        $this->corrAccount = $params['ks'];
        $this->currentAccount = $params['rs'];
        $this->homePhone = $params['phonehome'];
        $this->mobilePhone = $params['phonemobile'];
        $this->icq = $params['icq'];
        $this->fax = $params['fax'];
        $this->contactPhone = $params['phone'];
        $this->email = $params['email'];
        $this->url = $params['web'];
        $this->capitallerFounderWmid = $params['cap_owner'];
        if (isset($params['pasdoc'])) {
            $this->passportVerification = (bool)$params['pasdoc'];
        }
        if (isset($params['regdoc'])) {
            $this->regVerification = (bool)$params['regdoc'];
        }
        if (isset($params['inndoc'])) {
            $this->tinVerification = (bool)$params['inndoc'];
        }
        $this->jabberId = $params['jabberid'];
        $this->sex = $params['sex'];
        if (isset($params['permis'])) {
            $this->permis = $params['permis'];
        }
        if (isset($params['regcheck'])) {
            $this->regCheck = $params['regcheck'];
        }
        if (isset($params['photoid'])) {
            $this->photoId = (bool)$params['photoid'];
        }
    }

    /**
     * @return int
     */
    public function getLegalStatus()
    {
        return $this->legalStatus;
    }

    /**
     * @return int
     */
    public function getLegalPositionStatus()
    {
        return $this->legalPositionStatus;
    }

    /**
     * @return string
     */
    public function getBasisActs()
    {
        return $this->basisActs;
    }

    /**
     * @return bool
     */
    public function getLocked()
    {
        return $this->locked;
    }

    /**
     * @return string
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * @return string
     */
    public function getAdditionalInformation()
    {
        return $this->additionalInformation;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @return int
     */
    public function getCityId()
    {
        return $this->cityId;
    }

    /**
     * @return int
     */
    public function getCountryId()
    {
        return $this->countryId;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return int
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getMiddleName()
    {
        return $this->middleName;
    }

    /**
     * @return string
     */
    public function getPassportNum()
    {
        return $this->passportNum;
    }

    /**
     * @return string
     */
    public function getPassportDate()
    {
        return $this->passportDate;
    }

    /**
     * @return string
     */
    public function getPassportDateEnd()
    {
        return $this->passportDateEnd;
    }

    /**
     * @return int
     */
    public function getPassportDay()
    {
        return $this->passportDay;
    }

    /**
     * @return int
     */
    public function getPassportMonth()
    {
        return $this->passportMonth;
    }

    /**
     * @return int
     */
    public function getPassportYear()
    {
        return $this->passportYear;
    }

    /**
     * @return string
     */
    public function getPassportFormattedDate()
    {
        return $this->passportFormattedDate;
    }

    /**
     * @return int
     */
    public function getPassportCountryId()
    {
        return $this->passportCountryId;
    }

    /**
     * @return string
     */
    public function getPassportCountry()
    {
        return $this->passportCountry;
    }

    /**
     * @return string
     */
    public function getPassportCity()
    {
        return $this->passportCity;
    }

    /**
     * @return int
     */
    public function getPassportCityId()
    {
        return $this->passportCityId;
    }

    /**
     * @return string
     */
    public function getPassportPlace()
    {
        return $this->passportPlace;
    }

    /**
     * @return int
     */
    public function getNCountryId()
    {
        return $this->nCountryId;
    }

    /**
     * @return string
     */
    public function getNCountry()
    {
        return $this->nCountry;
    }

    /**
     * @return int
     */
    public function getNType()
    {
        return $this->nType;
    }

    /**
     * @return int
     */
    public function getResidenceCountryId()
    {
        return $this->residenceCountryId;
    }

    /**
     * @return string
     */
    public function getResidenceCountry()
    {
        return $this->residenceCountry;
    }

    /**
     * @return string
     */
    public function getResidenceCity()
    {
        return $this->residenceCity;
    }

    /**
     * @return int
     */
    public function getResidenceCityId()
    {
        return $this->residenceCityId;
    }

    /**
     * @return string
     */
    public function getResidenceAddress()
    {
        return $this->residenceAddress;
    }

    /**
     * @return string
     */
    public function getBirthPlace()
    {
        return $this->birthPlace;
    }

    /**
     * @return int
     */
    public function getBirthDay()
    {
        return $this->birthDay;
    }

    /**
     * @return int
     */
    public function getBirthMonth()
    {
        return $this->birthMonth;
    }

    /**
     * @return int
     */
    public function getBirthYear()
    {
        return $this->birthYear;
    }

    /**
     * @return string
     */
    public function getOrganizationName()
    {
        return $this->organizationName;
    }

    /**
     * @return string
     */
    public function getDirectorFullName()
    {
        return $this->directorFullName;
    }

    /**
     * @return string
     */
    public function getChiefAccountantFullName()
    {
        return $this->chiefAccountantFullName;
    }

    /**
     * @return string
     */
    public function getTin()
    {
        return $this->tin;
    }

    /**
     * @return string
     */
    public function getOkpo()
    {
        return $this->okpo;
    }

    /**
     * @return string
     */
    public function getOkved()
    {
        return $this->okved;
    }

    /**
     * @return string
     */
    public function getLegalAddress()
    {
        return $this->legalAddress;
    }

    /**
     * @return string
     */
    public function getLegalCountry()
    {
        return $this->legalCountry;
    }

    /**
     * @return int
     */
    public function getLegalCountryId()
    {
        return $this->legalCountryId;
    }

    /**
     * @return string
     */
    public function getLegalCity()
    {
        return $this->legalCity;
    }

    /**
     * @return int
     */
    public function getLegalZipCode()
    {
        return $this->legalZipCode;
    }

    /**
     * @return string
     */
    public function getBankName()
    {
        return $this->bankName;
    }

    /**
     * @return string
     */
    public function getBic()
    {
        return $this->bic;
    }

    /**
     * @return string
     */
    public function getCorrAccount()
    {
        return $this->corrAccount;
    }

    /**
     * @return string
     */
    public function getCurrentAccount()
    {
        return $this->currentAccount;
    }

    /**
     * @return string
     */
    public function getHomePhone()
    {
        return $this->homePhone;
    }

    /**
     * @return string
     */
    public function getMobilePhone()
    {
        return $this->mobilePhone;
    }

    /**
     * @return string
     */
    public function getIcq()
    {
        return $this->icq;
    }

    /**
     * @return string
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * @return string
     */
    public function getContactPhone()
    {
        return $this->contactPhone;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getCapitallerFounderWmid()
    {
        return $this->capitallerFounderWmid;
    }

    /**
     * @return bool
     */
    public function getPassportVerification()
    {
        return $this->passportVerification;
    }

    /**
     * @return bool
     */
    public function getRegVerification()
    {
        return $this->regVerification;
    }

    /**
     * @return bool
     */
    public function getTinVerification()
    {
        return $this->tinVerification;
    }

    /**
     * @return string
     */
    public function getJabberId()
    {
        return $this->jabberId;
    }

    /**
     * @return string
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * @return string
     */
    public function getPermis()
    {
        return $this->permis;
    }

    /**
     * @return string
     */
    public function getRegCheck()
    {
        return $this->regCheck;
    }

	/**
	 * @return bool
	 */
	public function getPhotoId()
	{
		return $this->photoId;
	}
}
