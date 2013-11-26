<?php
namespace Baibaratsky\WebMoney\Api;

abstract class XmlApiRequest extends ApiRequest
{
    /**
     * @return string
     */
    abstract public function getXml();

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
