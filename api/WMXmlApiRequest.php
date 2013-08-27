<?php

abstract class WMXmlApiRequest extends WMApiRequest
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
