<?php

namespace baibaratsky\WebMoney\Api\X\X11;

class CheckLock
{
    /** @var string ctype */
    private $passportType;

    /** @var string jstatus */
    private $legalPositionStatus;

    /** @var string osnovainfo */
    private $basisActs;

    /** @var string nickname */
    private $nickName;

    /** @var string infoopen */
    private $additionalInformation;

    /** @var string city */
    private $city;

    /** @var string region */
    private $region;

    /** @var string country */
    private $country;

    /** @var string adres */
    private $address;

    /** @var string zipcode */
    private $zipCode;

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

    /** @var string pbywhom */
    private $passportIssuePlace;

    /** @var string pcountry */
    private $passportIssueCountry;

    /** @var string pcity */
    private $passportIssueCity;

    /** @var string ncountryid */
    private $nCountryId;

    /** @var string ncountry */
    private $nCountry;

    /** @var string rcountry */
    private $residenceCountry;

    /** @var string rcity */
    private $residenceCity;

    /** @var string radres */
    private $residenceAddress;

    /** @var string bplace */
    private $birthPlace;

    /** @var string bday */
    private $birthday;

    /** @var string inn */
    private $tin;

    /** @var string name */
    private $organizationName;

    /** @var string dirfio */
    private $directorFullName;

    /** @var string buhfio */
    private $chiefAccountantFullName;

    /** @var string okpo */
    private $okpo;

    /** @var string okonx */
    private $okved;

    /** @var string jadres */
    private $legalAddress;

    /** @var string jcountry */
    private $legalCountry;

    /** @var string jzipcode */
    private $legalZipCode;

    /** @var string bankname */
    private $bankName;

    /** @var string bik */
    private $bic;

    /** @var string ks */
    private $corrAccount;

    /** @var string rs */
    private $currentAccount;

    /** @var string fax */
    private $fax;

    /** @var string email */
    private $email;

    /** @var string web */
    private $url;

    /** @var string phone */
    private $contactPhone;

    /** @var string phonehome */
    private $homePhone;

    /** @var string phonemobile */
    private $mobilePhone;

    /** @var string icq */
    private $icq;

    /** @var string jabberid */
    private $jabberId;

    /** @var string sex */
    private $sex;

    /**
     * @param array $params
     */
    public function __construct(array $params)
    {
        if (isset($params['ctype'])) {
            $this->passportType = $params['ctype'];
        }
        $this->legalPositionStatus = $params['jstatus'];
        $this->basisActs = $params['osnovainfo'];
        $this->nickName = $params['nickname'];
        $this->additionalInformation = $params['infoopen'];
        $this->city = $params['city'];
        $this->region = $params['region'];
        $this->country = $params['country'];
        $this->address = $params['adres'];
        $this->zipCode = $params['zipcode'];
        $this->lastName = $params['fname'];
        $this->firstName = $params['iname'];
        $this->middleName = $params['oname'];
        $this->passportNum = $params['pnomer'];
        $this->passportDate = $params['pdate'];
        $this->passportIssuePlace = $params['pbywhom'];
        $this->passportIssueCountry = $params['pcountry'];
        $this->passportIssueCity = $params['pcity'];
        if (isset($params['ncountryid'])) {
            $this->nCountryId = $params['ncountryid'];
        }
        if (isset($params['ncountry'])) {
            $this->nCountry = $params['ncountry'];
        }
        $this->residenceCountry = $params['rcountry'];
        $this->residenceCity = $params['rcity'];
        $this->residenceAddress = $params['radres'];
        $this->birthPlace = $params['bplace'];
        $this->birthday = $params['bday'];
        $this->tin = $params['inn'];
        $this->organizationName = $params['name'];
        $this->directorFullName = $params['dirfio'];
        $this->chiefAccountantFullName = $params['buhfio'];
        $this->okpo = $params['okpo'];
        $this->okved = $params['okonx'];
        $this->legalAddress = $params['jadres'];
        $this->legalCountry = $params['jcountry'];
        $this->legalZipCode = $params['jzipcode'];
        $this->bankName = $params['bankname'];
        $this->bic = $params['bik'];
        $this->corrAccount = $params['ks'];
        $this->currentAccount = $params['rs'];
        $this->fax = $params['fax'];
        $this->email = $params['email'];
        $this->url = $params['web'];
        $this->contactPhone = $params['phone'];
        $this->homePhone = $params['phonehome'];
        $this->mobilePhone = $params['phonemobile'];
        $this->icq = $params['icq'];
        $this->jabberId = $params['jabberid'];
        $this->sex = $params['sex'];
    }

    /**
     * @return string
     */
    public function getPassportType()
    {
        return $this->passportType;
    }

    /**
     * @return string
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
     * @return string
     */
    public function getNickName()
    {
        return $this->nickName;
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
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
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
    public function getZipCode()
    {
        return $this->zipCode;
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
    public function getPassportIssuePlace()
    {
        return $this->passportIssuePlace;
    }

    /**
     * @return string
     */
    public function getPassportIssueCountry()
    {
        return $this->passportIssueCountry;
    }

    /**
     * @return string
     */
    public function getPassportIssueCity()
    {
        return $this->passportIssueCity;
    }

    /**
     * @return string
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
     * @return string
     */
    public function getBirthday()
    {
        return $this->birthday;
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
     * @return string
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
    public function getFax()
    {
        return $this->fax;
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
    public function getContactPhone()
    {
        return $this->contactPhone;
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
}
