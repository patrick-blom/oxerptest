<?php

namespace OxErpTest\Services\Converter;

use OxErpTest\Services\ConverterInterface;
use OxErpTest\Structs\OxidXmlCall;

class CallConverter implements ConverterInterface
{
    /**
     * @var array
     */
    private $replacements;

    /**
     * CallConverter constructor.
     * @param array $replacements
     */
    public function __construct(array $replacements)
    {
        $this->replacements = $replacements;
    }

    /**
     * @param $string
     * @return OxidXmlCall
     */
    public function convert($string)
    {
        $methodName =
            substr(
                strstr(
                    strstr($string, '<oxer:'),
                    '>',
                    true
                ), 6
            );

        if($this->replacements){
            foreach ($this->replacements as $key => $replacement) {
                $string = str_replace($key, $replacement, $string);
            }
        }

        return new OxidXmlCall(
            [
                'methodName' => $methodName,
                'xml' => $string
            ]
        );
    }
}
