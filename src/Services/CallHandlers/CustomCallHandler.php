<?php

namespace OxErpTest\Services\CallHandlers;

use OxErpTest\Structs\ErpTestConfig;
use OxErpTest\Structs\OxidXmlCall;

class CustomCallHandler
{

    /**
     * @var \SoapClient
     */
    private $client;

    /**
     * @var ErpTestConfig
     */
    private $config;

    /**
     * CustomCallHandler constructor.
     * @param \SoapClient $client
     * @param ErpTestConfig $config
     */
    public function __construct(\SoapClient $client, ErpTestConfig $config)
    {
        $this->client = $client;
        $this->config = $config;
    }

    /**
     * @param OxidXmlCall $xmlCall
     * @return string
     */
    public function call(OxidXmlCall $xmlCall)
    {
        return $this->client->__doRequest(
            $xmlCall->xml,
            $this->config->getSoapLoacation(),
            $xmlCall->methodName,
            SOAP_1_1
        );
    }
}
