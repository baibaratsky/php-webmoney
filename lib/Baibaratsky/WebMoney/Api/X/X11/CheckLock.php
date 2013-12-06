<?php
namespace Baibaratsky\WebMoney\Api\X\X11;

class CheckLock
{
    /** @var string ctype */
    private $_passportType;

    /** @var string jstatus */
    private $_legalPositionStatus;

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
        if (isset($params['ctype'])) {
            $this->_passportType = $params['ctype'];
        }
        $this->_legalPositionStatus = $params['jstatus'];
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
        if (isset($params['ncountryid'])) {
            $this->_nCountryId = $params['ncountryid'];
        }
        if (isset($params['ncountry'])) {
            $this->_nCountry = $params['ncountry'];
        }
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
    public function getPassportType()
    {
        return $this->_passportType;
    }

    /**
     * @return string
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
