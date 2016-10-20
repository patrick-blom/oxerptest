<?php

namespace OxErpTest\Services\Converter;

use OxErpTest\Structs\OxidXmlCall;

class CallConverter
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
     * @param $callString
     * @return OxidXmlCall
     */
    public function convert($callString)
    {
        $methodName =
            substr(
                strstr(
                    strstr($callString, '<oxer:'),
                    '>',
                    true
                ), 6
            );

        foreach ($this->replacements as $key => $replacement) {
            str_replace($key, $replacement, $callString);
        }

        return new OxidXmlCall(
            [
                'methodName' => $methodName,
                'xml' => $callString
            ]
        );
    }
}
