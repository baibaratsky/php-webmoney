<?php

namespace baibaratsky\WebMoney\Request;

abstract class XmlRequest extends AbstractRequest
{
    /**
     * @return string
     */
    abstract public function getData();

    /**
     * @param string $name
     * @param string|int|float $value
     * @param bool $allowEmpty
     *
     * @return string
     */
    protected static function xmlElement($name, $value, $allowEmpty = false)
    {
        return !empty($value) || is_numeric($value) || $allowEmpty ?
                '<' . $name . '>' . $value . '</' . $name . '>'
                :
                '';
    }
}
