<?php
namespace Baibaratsky\WebMoney\Validator;

use Baibaratsky\WebMoney\Api\ApiRequest;
use Baibaratsky\WebMoney\Exception\ValidatorException;

class RequestValidator
{
    const TYPE_REQUIRED = 1;
    const TYPE_DEPEND_REQUIRED = 2;
    const TYPE_RANGE = 3;
    const TYPE_CONDITIONAL = 4;
    const TYPE_ARRAY = 5;

    /** @var ApiRequest */
    protected $_request;

    /** @var array */
    protected $_errors = array();

    /**
     * @param ApiRequest $request
     */
    public function __construct(ApiRequest $request)
    {
        $this->_request = $request;
    }

    /**
     * @param array $rules
     *
     * @return array
     * @throws ValidatorException
     */
    public function validate(array $rules)
    {
        foreach ($rules as $type => $rule) {
            foreach ($rule as $key => $param) {
                switch ($type) {
                    case self::TYPE_REQUIRED:
                        $this->_validateRequired($param);
                        break;
                    case self::TYPE_DEPEND_REQUIRED:
                        $this->_validateDependRequired($key, $param);
                        break;
                    case self::TYPE_RANGE:
                        $this->_validateRange($key, $param);
                        break;
                    case self::TYPE_CONDITIONAL:
                        $this->_validateConditional($key, $param);
                        break;
                    case self::TYPE_ARRAY:
                        $this->_validateArray($key, $param);
                        break;
                    default:
                        throw new ValidatorException('Wrong validation type: ' . $type);
                }
            }
        }

        return $this->_errors;
    }

    /**
     * @param string $paramName
     *
     * @return bool
     */
    protected function _validateRequired($paramName)
    {
        $paramValue = call_user_func(array($this->_request, 'get' . ucfirst($paramName)));
        if (empty($paramValue)) {
            $this->_addError(self::TYPE_REQUIRED, $paramName);

            return false;
        }

        return true;
    }

    /**
     * @param string $paramName
     * @param array $rule
     *
     * @return bool
     * @throws ValidatorException
     */
    protected function _validateDependRequired($paramName, array $rule)
    {
        $dependName = key($rule);
        $dependValue = current($rule);
        if (!is_array($dependValue)) {
            throw new ValidatorException('DependValue should be an array.');
        }

        $propertyDependValue = call_user_func(array($this->_request, 'get' . ucfirst($dependName)));
        $propertyParamValue = call_user_func(array($this->_request, 'get' . ucfirst($paramName)));
        if ($this->_validateRequired($dependName)) {
            $hasErrors = false;
            foreach ($dependValue as $value) {
                if ($propertyDependValue == $value && empty($propertyParamValue)) {
                    $hasErrors = true;
                }
            }

            if ($hasErrors) {
                $this->_addError(self::TYPE_DEPEND_REQUIRED, $paramName);

                return false;
            }
        }

        return true;
    }

    /**
     * @param string $paramName
     * @param array $range
     */
    protected function _validateRange($paramName, array $range)
    {
        $propertyValue = call_user_func(array($this->_request, 'get' . ucfirst($paramName)));
        if (empty($propertyValue)) {
            return;
        }

        if (!in_array($propertyValue, $range)) {
            $this->_addError(self::TYPE_RANGE, $paramName);
        }
    }

    /**
     * @param $paramName
     * @param array $rule
     *
     * @return bool|null
     * @throws ValidatorException
     */
    protected function _validateConditional($paramName, array $rule)
    {
        $propertyValue = call_user_func(array($this->_request, 'get' . ucfirst($paramName)));
        if (empty($propertyValue)) {
            return null;
        }

        foreach ($rule as $item) {
            if (!isset($item['value']) && !isset($item['conditional'])) {
                throw new ValidatorException('Wrong rule data: ' . var_export($item, true));
            }

            if ($propertyValue == $item['value']) {
                $hasErrors = false;
                foreach ($item['conditional'] as $conditionalParam => $conditionalValue) {
                    $propertyConditionalValue =
                            call_user_func(array($this->_request, 'get' . ucfirst($conditionalParam)));
                    if (empty($propertyConditionalValue)) {
                        $hasErrors = true;
                        break;
                    }

                    if ($propertyConditionalValue != $conditionalValue) {
                        $hasErrors = true;
                        break;
                    }
                }

                if ($hasErrors) {
                    $this->_addError(self::TYPE_CONDITIONAL, $paramName);

                    return false;
                }
            }
        }

        return true;
    }

    /**
     * @param string $paramName
     *
     * @return bool
     */
    protected function _validateArray($paramName)
    {
        $paramValue = call_user_func(array($this->_request, 'get' . ucfirst($paramName)));
        if (!is_array($paramValue)) {
            $this->_addError(self::TYPE_ARRAY, $paramName);

            return false;
        }

        return true;
    }

    /**
     * @param string $type
     * @param string $param
     */
    protected function _addError($type, $param)
    {
        if (!isset($this->_errors[$type])) {
            $this->_errors[$type] = array();
        }

        if (!$this->_hasError($type, $param)) {
            $this->_errors[$type][] = $param;
        }
    }

    /**
     * @param string $type
     * @param string $param
     *
     * @return bool
     */
    protected function _hasError($type, $param)
    {
        foreach ($this->_errors[$type] as $errorParam) {
            if ($errorParam == $param) {
                return true;
            }
        }

        return false;
    }
}
