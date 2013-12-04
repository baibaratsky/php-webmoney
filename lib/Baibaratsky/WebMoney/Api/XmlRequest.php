<?php
namespace Baibaratsky\WebMoney\Api;

abstract class XmlRequest extends Request
{
    /**
     * @return string
     */
    abstract public function getData();

    /**
     * @param string $name
     * @param string|int|float $value
     *
     * @return string
     */
    protected static function _xmlElement($name, $value)
    {
        return !empty($value) ? '<' . $name . '>' . $value . '</' . $name . '>' : '';
    }
}
