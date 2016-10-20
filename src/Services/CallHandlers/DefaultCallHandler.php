<?php

namespace OxErpTest\Services\CallHandlers;

class DefaultCallHandler
{
    /**
     * @var \SoapClient
     */
    private $client;

    /**
     * @param \SoapClient $client
     */
    public function setClient($client)
    {
        $this->client = $client;
    }

    /**
     * @param $method string
     * @param array $parameters
     */
    public function call($method, array $parameters)
    {
        return $this->client->$method(!empty($parameters) ? $parameters : '');
    }
}
