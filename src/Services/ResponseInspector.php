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
     * @param $response
     * @param $methodName
     * @return bool
     */
    public function inspect($response, $methodName)
    {


    }

    /**
     * @return array
     * @throws \Exception
     */
    private function getResponseCollection()
    {
        if($this->responses === null){
            $responseCollector = new XmlResponseCollector();
            $responseCollection = $responseCollector->collect();

            if(empty($responseCollection)){
                throw new \Exception('missing responses! check filen ames or count');
            }

            $this->responses = $responseCollection;
        }
        return $this->responses;
    }

}
