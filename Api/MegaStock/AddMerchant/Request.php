<?php

namespace baibaratsky\WebMoney\Api\MegaStock\AddMerchant;

use baibaratsky\WebMoney\Api\MegaStock;
use baibaratsky\WebMoney\Exception\ApiException;
use baibaratsky\WebMoney\Request\RequestSigner;
use baibaratsky\WebMoney\Request\RequestValidator;

/**
 * Class Request
 *
 * @link http://www.megastock.ru/Doc/AddIntMerchant.aspx?lang=en
 */
class Request extends MegaStock\Request
{
    const BENEFICIARY_TYPE_CONTRACT = 1;
    const BENEFICIARY_TYPE_WEBMONEY = 2;

    const ABOUT_LANGUAGE_RU = 'ru';
    const ABOUT_LANGUAGE_EN = 'en';

    /** @var int int_id */
    protected $integratorId;

    /** @var string int_wmid */
    protected $integratorWmid;

    /** @var int beneficiary/@type */
    protected $beneficiaryType;

    /** @var string beneficiary/legalname */
    protected $beneficiaryLegalName;

    /** @var int beneficiary/legalnumber */
    protected $beneficiaryLegalOgrn;

    /** @var string beneficiary/wmid */
    protected $beneficiaryWmid;

    /** @var string url */
    protected $merchantUrl;

    /** @var int group */
    protected $categoryId;

    /** @var string keywords */
    protected $keywords;

    /** @var string logourl */
    protected $logoUrl;

    /** @var string about/@lang */
    protected $aboutLanguage;

    /** @var string about/name */
    protected $aboutName;

    /** @var string about/descr */
    protected $aboutDescription;

    /** @var string nameincomment */
    protected $merchantNameInComment;

    /** @var array geobindings */
    protected $geoBindings;

    public function __construct($loginType = self::LOGIN_TYPE_PROCESSING, $salt = null)
    {
        parent::__construct($loginType, $salt);

        $this->url = 'https://www.megastock.ru/xml/int/AddMerchant.ashx';
    }

    /**
     * @return array
     */
    protected function getValidationRules()
    {
        return array(
            RequestValidator::TYPE_REQUIRED => array(
                'integratorId', 'integratorWmid', 'url', 'categoryId', 'aboutLanguage', 'aboutName', 'aboutDescription',
                'merchantNameInComment', 'geoBindings',
            ),
            RequestValidator::TYPE_ARRAY => array('about', 'geoBindings'),
            RequestValidator::TYPE_DEPEND_REQUIRED => array(
                'beneficiaryLegalName' => array('loginType' => array(self::LOGIN_TYPE_KEEPER)),
                'beneficiaryLegalOgrn' => array('loginType' => array(self::LOGIN_TYPE_KEEPER)),
                'beneficiaryWmid' => array('loginType' => array(self::LOGIN_TYPE_PROCESSING)),
            ),
            RequestValidator::TYPE_CONDITIONAL => array(
                'beneficiaryType' => array(
                    array('value' => self::BENEFICIARY_TYPE_CONTRACT, 'conditional' => array('loginType' => self::LOGIN_TYPE_KEEPER)),
                    array('value' => self::BENEFICIARY_TYPE_WEBMONEY, 'conditional' => array('loginType' => self::LOGIN_TYPE_PROCESSING))
                ),
            ),
        );
    }

    /**
     * @return string
     */
    public function getData()
    {
        $xml = '<ms.request>';
        $xml .= '<login type="' . $this->loginType . '"></login>';
        $xml .= self::xmlElement('int_id', $this->integratorId);
        $xml .= self::xmlElement('int_wmid', $this->integratorWmid);

        $xml .= '<beneficiary type="' . $this->beneficiaryType . '">';
        $xml .= self::xmlElement('legalname', $this->beneficiaryLegalName);
        $xml .= self::xmlElement('legalnumber', $this->beneficiaryLegalOgrn);
        $xml .= self::xmlElement('wmid', $this->beneficiaryWmid);
        $xml .= '</beneficiary>';

        $xml .= self::xmlElement('url', $this->url);
        $xml .= self::xmlElement('group', $this->categoryId);
        $xml .= self::xmlElement('keywords', $this->keywords);
        $xml .= self::xmlElement('logourl', $this->logoUrl);

        $xml .= '<about lang="' . $this->aboutLanguage . '">';
        $xml .= self::xmlElement('name', $this->aboutName);
        $xml .= self::xmlElement('descr', $this->aboutDescription);
        $xml .= '</about>';

        $xml .= self::xmlElement('nameincomment', $this->merchantNameInComment);
        if (count($this->geoBindings) > 0) {
            $xml .= '<geobindings>';
            foreach ($this->geoBindings as $country) {
                $xml .= '<country id="' . strtoupper($country) . '"></country>';
            }
            $xml .= '</geobindings>';
        }
        $xml .= self::xmlElement('sign', $this->signature);

        $xml .= '</ms.request>';

        return $xml;
    }

    /**
     * @return string
     */
    public function getResponseClassName()
    {
        return 'baibaratsky\WebMoney\Api\MegaStock\AddMerchant\Response';
    }

    /**
     * @param \baibaratsky\WebMoney\Request\RequestSigner $requestSigner
     *
     * @throws ApiException
     */
    public function sign(RequestSigner $requestSigner = null)
    {
        $signString = $this->loginType . $this->integratorId . $this->integratorWmid .
                      $this->merchantNameInComment . $this->categoryId;
        if ($this->loginType == self::LOGIN_TYPE_KEEPER) {
            if ($requestSigner === null) {
                throw new ApiException('This type of login requires the request signer.');
            }
            $this->signature = $requestSigner->sign($signString);
        } else {
            $this->signature = base64_encode(sha1($signString . $this->salt));
        }
    }

    /**
     * @return int
     */
    public function getIntegratorId()
    {
        return $this->integratorId;
    }

    /**
     * @param int $integratorId
     */
    public function setIntegratorId($integratorId)
    {
        $this->integratorId = $integratorId;
    }

    /**
     * @return string
     */
    public function getIntegratorWmid()
    {
        return $this->integratorWmid;
    }

    /**
     * @param string $integratorWmid
     */
    public function setIntegratorWmid($integratorWmid)
    {
        $this->integratorWmid = $integratorWmid;
    }

    /**
     * @return int
     */
    public function getBeneficiaryType()
    {
        return $this->beneficiaryType;
    }

    /**
     * @param int $beneficiaryType
     */
    public function setBeneficiaryType($beneficiaryType)
    {
        $this->beneficiaryType = $beneficiaryType;
    }

    /**
     * @return string
     */
    public function getBeneficiaryLegalName()
    {
        return $this->beneficiaryLegalName;
    }

    /**
     * @param string $beneficiaryLegalName
     */
    public function setBeneficiaryLegalName($beneficiaryLegalName)
    {
        $this->beneficiaryLegalName = $beneficiaryLegalName;
    }

    /**
     * @return int
     */
    public function getBeneficiaryLegalOgrn()
    {
        return $this->beneficiaryLegalOgrn;
    }

    /**
     * @param int $beneficiaryLegalOgrn
     */
    public function setBeneficiaryLegalOgrn($beneficiaryLegalOgrn)
    {
        $this->beneficiaryLegalOgrn = $beneficiaryLegalOgrn;
    }

    /**
     * @return string
     */
    public function getBeneficiaryWmid()
    {
        return $this->beneficiaryWmid;
    }

    /**
     * @param string $beneficiaryWmid
     */
    public function setBeneficiaryWmid($beneficiaryWmid)
    {
        $this->beneficiaryWmid = $beneficiaryWmid;
    }

    /**
     * @return string
     */
    public function getMerchantUrl()
    {
        return $this->merchantUrl;
    }

    /**
     * @param $merchantUrl
     */
    public function setMerchantUrl($merchantUrl)
    {
        $this->merchantUrl = $merchantUrl;
    }

    /**
     * @return int
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * @param int $categoryId
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
    }

    /**
     * @return string
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * @param string $keywords
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
    }

    /**
     * @return string
     */
    public function getLogoUrl()
    {
        return $this->logoUrl;
    }

    /**
     * @param string $logoUrl
     */
    public function setLogoUrl($logoUrl)
    {
        $this->logoUrl = $logoUrl;
    }

    /**
     * @return string
     */
    public function getAboutLanguage()
    {
        return $this->aboutLanguage;
    }

    /**
     * @param string $aboutLanguage
     */
    public function setAboutLanguage($aboutLanguage)
    {
        $this->aboutLanguage = $aboutLanguage;
    }

    /**
     * @return string
     */
    public function getAboutName()
    {
        return $this->aboutName;
    }

    /**
     * @param string $aboutName
     */
    public function setAboutName($aboutName)
    {
        $this->aboutName = $aboutName;
    }

    /**
     * @return string
     */
    public function getAboutDescription()
    {
        return $this->aboutDescription;
    }

    /**
     * @param string $aboutDescription
     */
    public function setAboutDescription($aboutDescription)
    {
        $this->aboutDescription = $aboutDescription;
    }

    /**
     * @return string
     */
    public function getMerchantNameInComment()
    {
        return $this->merchantNameInComment;
    }

    /**
     * @param string $merchantNameInComment
     */
    public function setMerchantNameInComment($merchantNameInComment)
    {
        $this->merchantNameInComment = $merchantNameInComment;
    }

    /**
     * @return array
     */
    public function getGeoBindings()
    {
        return $this->geoBindings;
    }

    /**
     * @param array $geoBindings
     */
    public function setGeoBindings(array $geoBindings)
    {
        $this->geoBindings = $geoBindings;
    }
}
