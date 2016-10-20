<?php

namespace OxErpTest\Services;

use OxErpTest\Services\Collectors\XmlResponseCollector;

class ResponseInspector
{
    /**
     * @var array
     */
    private $responses;

    /**
     * @param $callResponse
     * @param $methodName
     * @return bool
     * @throws \Exception
     */
    public function inspect($callResponse, $methodName)
    {
        $responseName = $methodName . 'Response';
        $responseFiles = $this->getResponseCollection();

        if (!array_key_exists($responseName, $responseFiles)) {
            throw new \Exception(
                'could not find response file for [' . $methodName . ']. missing file ' .
                $responseName . 'in var/responses'
            );
        }

        // Todo compore the soap calls

        return true;
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
