<?php

namespace baibaratsky\WebMoney\Request;

use baibaratsky\WebMoney\Exception\RequestValidatorException;

class RequestValidator
{
    const TYPE_REQUIRED = 1;
    const TYPE_DEPEND_REQUIRED = 2;
    const TYPE_RANGE = 3;
    const TYPE_CONDITIONAL = 4;
    const TYPE_ARRAY = 5;

    /** @var \baibaratsky\WebMoney\Request\AbstractRequest */
    protected $request;

    /** @var array */
    protected $errors = array();

    /**
     * @param \baibaratsky\WebMoney\Request\AbstractRequest $request
     */
    public function __construct(AbstractRequest $request)
    {
        $this->request = $request;
    }

    /**
     * @param array $rules
     *
     * @return array
     * @throws RequestValidatorException
     */
    public function validate(array $rules)
    {
        foreach ($rules as $type => $rule) {
            foreach ($rule as $key => $param) {
                switch ($type) {
                    case self::TYPE_REQUIRED:
                        $this->validateRequired($param);
                        break;
                    case self::TYPE_DEPEND_REQUIRED:
                        $this->validateDependRequired($key, $param);
                        break;
                    case self::TYPE_RANGE:
                        $this->validateRange($key, $param);
                        break;
                    case self::TYPE_CONDITIONAL:
                        $this->validateConditional($key, $param);
                        break;
                    case self::TYPE_ARRAY:
                        $this->validateArray($key);
                        break;
                    default:
                        throw new RequestValidatorException('Wrong validation type: ' . $type);
                }
            }
        }

        return $this->errors;
    }

    /**
     * @param string $paramName
     *
     * @return bool
     */
    protected function validateRequired($paramName)
    {
        $paramValue = call_user_func(array($this->request, 'get' . ucfirst($paramName)));
        if (empty($paramValue) && !is_numeric($paramValue) && !is_bool($paramValue)) {
            $this->addError(self::TYPE_REQUIRED, $paramName);

            return false;
        }

        return true;
    }

    /**
     * @param string $paramName
     * @param array $rule
     *
     * @return bool
     * @throws RequestValidatorException
     */
    protected function validateDependRequired($paramName, array $rule)
    {
        $dependName = key($rule);
        $dependValue = current($rule);
        if (!is_array($dependValue)) {
            throw new RequestValidatorException('DependValue should be an array.');
        }

        $propertyDependValue = call_user_func(array($this->request, 'get' . ucfirst($dependName)));
        $propertyParamValue = call_user_func(array($this->request, 'get' . ucfirst($paramName)));
        if ($this->validateRequired($dependName)) {
            $hasErrors = false;
            foreach ($dependValue as $value) {
                if ($propertyDependValue == $value && empty($propertyParamValue)) {
                    $hasErrors = true;
                }
            }

            if ($hasErrors) {
                $this->addError(self::TYPE_DEPEND_REQUIRED, $paramName);

                return false;
            }
        }

        return true;
    }

    /**
     * @param string $paramName
     * @param array $range
     */
    protected function validateRange($paramName, array $range)
    {
        $propertyValue = call_user_func(array($this->request, 'get' . ucfirst($paramName)));
        if (empty($propertyValue)) {
            return;
        }

        if (!in_array($propertyValue, $range)) {
            $this->addError(self::TYPE_RANGE, $paramName);
        }
    }

    /**
     * @param $paramName
     * @param array $rule
     *
     * @return bool|null
     * @throws RequestValidatorException
     */
    protected function validateConditional($paramName, array $rule)
    {
        $propertyValue = call_user_func(array($this->request, 'get' . ucfirst($paramName)));
        if (empty($propertyValue)) {
            return null;
        }

        foreach ($rule as $item) {
            if (!isset($item['value']) && !isset($item['conditional'])) {
                throw new RequestValidatorException('Wrong rule data: ' . var_export($item, true));
            }

            if ($propertyValue == $item['value']) {
                $hasErrors = false;
                foreach ($item['conditional'] as $conditionalParam => $conditionalValue) {
                    $propertyConditionalValue =
                            call_user_func(array($this->request, 'get' . ucfirst($conditionalParam)));
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
                    $this->addError(self::TYPE_CONDITIONAL, $paramName);

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
    protected function validateArray($paramName)
    {
        $paramValue = call_user_func(array($this->request, 'get' . ucfirst($paramName)));
        if (!is_array($paramValue)) {
            $this->addError(self::TYPE_ARRAY, $paramName);

            return false;
        }

        return true;
    }

    /**
     * @param string $type
     * @param string $param
     */
    protected function addError($type, $param)
    {
        if (!isset($this->errors[$type])) {
            $this->errors[$type] = array();
        }

        if (!$this->hasError($type, $param)) {
            $this->errors[$type][] = $param;
        }
    }

    /**
     * @param string $type
     * @param string $param
     *
     * @return bool
     */
    protected function hasError($type, $param)
    {
        foreach ($this->errors[$type] as $errorParam) {
            if ($errorParam == $param) {
                return true;
            }
        }

        return false;
    }
}
