<?php

class WMApiRequestValidator
{
    const TYPE_REQUIRED = 1;
    const TYPE_DEPEND_REQUIRED = 2;
    const TYPE_RANGE = 3;
    const TYPE_CONDITIONAL = 4;

    /** @var array */
    protected $_values;

    /** @var array */
    protected $_errors = array();

    /**
     * @param array $values
     */
    public function __construct(array $values)
    {
        $this->_values = $values;
    }

    /**
     * @param $rules
     *
     * @return array
     * @throws WMException
     */
    public function validate($rules)
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
                    default:
                        throw new WMException('Wrong validation type: ' . $type);
                }
            }
        }

        return $this->_errors;
    }

    /**
     * @param $paramName
     *
     * @return bool
     */
    protected function _validateRequired($paramName)
    {
        if (empty($this->_values[$paramName])) {
            $this->_addError(self::TYPE_REQUIRED, $paramName);

            return false;
        }

        return true;
    }

    /**
     * @param $paramName
     * @param $rule
     *
     * @return bool
     * @throws WMException
     */
    protected function _validateDependRequired($paramName, $rule)
    {
        $dependName = key($rule);
        $dependValue = current($rule);
        if (!is_array($dependValue)) {
            throw new WMException('DependValue should be an array.');
        }

        if ($this->_validateRequired($dependName)) {
            $hasErrors = false;
            foreach ($dependValue as $value) {
                if ($this->_values[$dependName] == $value && empty($this->_values[$paramName])) {
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
     * @param $paramName
     * @param $range
     *
     * @throws WMException
     */
    protected function _validateRange($paramName, $range)
    {
        if (!is_array($range)) {
            throw new WMException('Range should be an array: ' . print_r($range, true));
        }

        if (empty($this->_values[$paramName])) {
            return;
        }

        if (!in_array($this->_values[$paramName], $range)) {
            $this->_addError(self::TYPE_RANGE, $paramName);
        }
    }

    /**
     * @param $paramName
     * @param $rule
     *
     * @return bool
     * @throws WMException
     */
    protected function _validateConditional($paramName, $rule)
    {
        if (empty($this->_values[$paramName])) {
            return null;
        }

        foreach ($rule as $item) {
            if (!isset($item['value']) && !isset($item['conditional'])) {
                throw new WMException('Wrong rule data: ' . print_r($item, true));
            }

            if ($this->_values[$paramName] == $item['value']) {
                $hasErrors = false;
                foreach ($item['conditional'] as $conditionalParam => $conditionalValue) {
                    if (empty($this->_values[$conditionalParam])) {
                        $hasErrors = true;
                        break;
                    }

                    if ($this->_values[$conditionalParam] != $conditionalValue) {
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
