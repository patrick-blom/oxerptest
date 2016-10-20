<?php

namespace OxErpTest\Services\Converter;

use OxErpTest\Services\ConverterInterface;

class ResponseConverter implements ConverterInterface
{

    /**
     * @param $string
     * @return mixed
     */
    public function convert($string)
    {
        return $string;
    }
}
