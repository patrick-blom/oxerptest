<?php

namespace OxErpTest\Services;

use OxErpTest\Services\Collectors\XmlResponseCollector;

class ResponseValidator
{
    /**
     * @var array
     */
    private $responses;

    /**
     * @param $callResponse
     * @param $methodName
     * @return boolean
     * @throws \Exception
     */
    public function validate($callResponse, $methodName)
    {
        $responseName = $methodName . 'Response';
        $responseFiles = $this->getResponseCollection();

        if (!array_key_exists($responseName, $responseFiles)) {
            throw new \Exception(
                'could not find response file for [' . $methodName . ']. missing file ' .
                $responseName . 'in var/responses'
            );
        }

        if (sha1($callResponse) == sha1($responseFiles[$responseName])) {
            return true;
        }

        return false;
    }

    /**
     * @return array
     * @throws \Exception
     */
    private function getResponseCollection()
    {
        if ($this->responses === null) {
            $responseCollector = new XmlResponseCollector();
            $responseCollection = $responseCollector->collect();

            if (empty($responseCollection)) {
                throw new \Exception('missing responses! check filen ames or count');
            }

            $this->responses = $responseCollection;
        }
        return $this->responses;
    }
}
