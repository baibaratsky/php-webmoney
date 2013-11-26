<?php
namespace Baibaratsky\WebMoney\Api\MegaStock;

use Baibaratsky\WebMoney\Exception\ApiException;
use Baibaratsky\WebMoney\Signer\RequestSigner;
use Baibaratsky\WebMoney\Validator\RequestValidator;

/**
 * Class AddMerchantRequest
 *
 * @link http://www.megastock.ru/Doc/AddIntMerchant.aspx?lang=en
 */
class AddMerchantRequest extends ApiRequest
{
    const BENEFICIARY_TYPE_CONTRACT = 1;
    const BENEFICIARY_TYPE_WEBMONEY = 2;

    const ABOUT_LANGUAGE_RU = 'ru';
    const ABOUT_LANGUAGE_EN = 'en';

    /** @var int int_id */
    protected $_integratorId;

    /** @var string int_wmid */
    protected $_integratorWmid;

    /** @var int beneficiary@type */
    protected $_beneficiaryType;

    /** @var string beneficiary/legalname */
    protected $_beneficiaryLegalName;

    /** @var int beneficiary/legalnumber */
    protected $_beneficiaryLegalOgrn;

    /** @var string beneficiary/wmid */
    protected $_beneficiaryWmid;

    /** @var string url */
    protected $_merchantUrl;

    /** @var int group */
    protected $_categoryId;

    /** @var string keywords */
    protected $_keywords;

    /** @var string logourl */
    protected $_logoUrl;

    /** @var AddMerchantRequestAbout[] about */
    protected $_about;

    /** @var string nameincomment */
    protected $_merchantNameInComment;

    /** @var array geobindings */
    protected $_geoBindings;

    public function __construct($loginType = self::LOGIN_TYPE_PROCESSING, $salt = null)
    {
        parent::__construct($loginType, $salt);

        $this->_url = 'https://www.megastock.ru/xml/int/AddMerchant.ashx';
    }

    /**
     * @return array
     */
    protected function _getValidationRules()
    {
        return array(
            RequestValidator::TYPE_REQUIRED => array('integratorId', 'integratorWmid', 'url', 'categoryId', 'about', 'merchantNameInComment', 'geoBindings'),
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
    public function getXml()
    {
        $xml = '<ms.request>';
        $xml .= '<login type="' . $this->_loginType . '"></login>';
        $xml .= self::_xmlElement('int_id', $this->_integratorId);
        $xml .= self::_xmlElement('int_wmid', $this->_integratorWmid);

        $xml .= '<beneficiary type="' . $this->_beneficiaryType . '">';
        $xml .= self::_xmlElement('legalname', $this->_beneficiaryLegalName);
        $xml .= self::_xmlElement('legalnumber', $this->_beneficiaryLegalOgrn);
        $xml .= self::_xmlElement('wmid', $this->_beneficiaryWmid);
        $xml .= '</beneficiary>';

        $xml .= self::_xmlElement('url', $this->_url);
        $xml .= self::_xmlElement('group', $this->_categoryId);
        $xml .= self::_xmlElement('keywords', $this->_keywords);
        $xml .= self::_xmlElement('logourl', $this->_logoUrl);

        foreach ($this->_about as $about) {
            $xml .= '<about lang="' . $about->getLanguage() . '">';
            $xml .= self::_xmlElement('name', $about->getName());
            $xml .= self::_xmlElement('descr', $about->getDescription());
            $xml .= '</about>';
        }

        $xml .= self::_xmlElement('nameincomment', $this->_merchantNameInComment);
        if (count($this->_geoBindings) > 0) {
            $xml .= '<geobindings>';
            foreach ($this->_geoBindings as $country) {
                $xml .= '<country id="' . strtoupper($country) . '"></country>';
            }
            $xml .= '</geobindings>';
        }
        $xml .= self::_xmlElement('sign', $this->_signature);

        $xml .= '</ms.request>';

        return $xml;
    }

    /**
     * @return string
     */
    public function getResponseClassName()
    {
        return 'AddMerchantResponse';
    }

    /**
     * @param RequestSigner $requestSigner
     *
     * @throws ApiException
     */
    public function sign(RequestSigner $requestSigner = null)
    {
        $signString = $this->_loginType . $this->_integratorId . $this->_integratorWmid .
                      $this->_merchantNameInComment . $this->_categoryId;
        if ($this->_loginType == self::LOGIN_TYPE_KEEPER) {
            if ($requestSigner === null) {
                throw new ApiException('This type of login requires the request signer.');
            }
            $this->_signature = $requestSigner->sign($signString);
        } else {
            $this->_signature = base64_encode(sha1($signString . $this->_salt));
        }
    }

    /**
     * @return int
     */
    public function getIntegratorId()
    {
        return $this->_integratorId;
    }

    /**
     * @param int $integratorId
     */
    public function setIntegratorId($integratorId)
    {
        $this->_integratorId = $integratorId;
    }

    /**
     * @return string
     */
    public function getIntegratorWmid()
    {
        return $this->_integratorWmid;
    }

    /**
     * @param string $integratorWmid
     */
    public function setIntegratorWmid($integratorWmid)
    {
        $this->_integratorWmid = $integratorWmid;
    }

    /**
     * @return int
     */
    public function getBeneficiaryType()
    {
        return $this->_beneficiaryType;
    }

    /**
     * @param int $beneficiaryType
     */
    public function setBeneficiaryType($beneficiaryType)
    {
        $this->_beneficiaryType = $beneficiaryType;
    }

    /**
     * @return string
     */
    public function getBeneficiaryLegalName()
    {
        return $this->_beneficiaryLegalName;
    }

    /**
     * @param string $beneficiaryLegalName
     */
    public function setBeneficiaryLegalName($beneficiaryLegalName)
    {
        $this->_beneficiaryLegalName = $beneficiaryLegalName;
    }

    /**
     * @return int
     */
    public function getBeneficiaryLegalOgrn()
    {
        return $this->_beneficiaryLegalOgrn;
    }

    /**
     * @param int $beneficiaryLegalOgrn
     */
    public function setBeneficiaryLegalOgrn($beneficiaryLegalOgrn)
    {
        $this->_beneficiaryLegalOgrn = $beneficiaryLegalOgrn;
    }

    /**
     * @return string
     */
    public function getBeneficiaryWmid()
    {
        return $this->_beneficiaryWmid;
    }

    /**
     * @param string $beneficiaryWmid
     */
    public function setBeneficiaryWmid($beneficiaryWmid)
    {
        $this->_beneficiaryWmid = $beneficiaryWmid;
    }

    /**
     * @return string
     */
    public function getMerchantUrl()
    {
        return $this->_merchantUrl;
    }

    /**
     * @param $merchantUrl
     */
    public function setMerchantUrl($merchantUrl)
    {
        $this->_merchantUrl = $merchantUrl;
    }

    /**
     * @return int
     */
    public function getCategoryId()
    {
        return $this->_categoryId;
    }

    /**
     * @param int $categoryId
     */
    public function setCategoryId($categoryId)
    {
        $this->_categoryId = $categoryId;
    }

    /**
     * @return string
     */
    public function getKeywords()
    {
        return $this->_keywords;
    }

    /**
     * @param string $keywords
     */
    public function setKeywords($keywords)
    {
        $this->_keywords = $keywords;
    }

    /**
     * @return string
     */
    public function getLogoUrl()
    {
        return $this->_logoUrl;
    }

    /**
     * @param string $logoUrl
     */
    public function setLogoUrl($logoUrl)
    {
        $this->_logoUrl = $logoUrl;
    }

    /**
     * @return AddMerchantRequestAbout[]
     */
    public function getAbout()
    {
        return $this->_about;
    }

    /**
     * @param AddMerchantRequestAbout[] $about
     */
    public function setAbout(array $about)
    {
        $this->_about = $about;
    }

    /**
     * @return string
     */
    public function getMerchantNameInComment()
    {
        return $this->_merchantNameInComment;
    }

    /**
     * @param string $merchantNameInComment
     */
    public function setMerchantNameInComment($merchantNameInComment)
    {
        $this->_merchantNameInComment = $merchantNameInComment;
    }

    /**
     * @return array
     */
    public function getGeoBindings()
    {
        return $this->_geoBindings;
    }

    /**
     * @param array $geoBindings
     */
    public function setGeoBindings(array $geoBindings)
    {
        $this->_geoBindings = $geoBindings;
    }
}

class AddMerchantRequestAbout
{
    const LANGUAGE_RU = 'ru';
    const LANGUAGE_EN = 'en';

    /** @var string @lang */
    private $_language;

    /** @var string name */
    private $_name;

    /** @var string descr */
    private $_description;

    public function __construct($language, $name, $description)
    {
        if ($language != self::LANGUAGE_RU && $language != self::LANGUAGE_EN) {
            throw new ApiException('About doesn\'t support the language given.');
        }

        $this->_language = $language;
        $this->_name = $name;
        $this->_description = $description;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->_language;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->_description;
    }
}
