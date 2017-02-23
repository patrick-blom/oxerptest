<?php

namespace OxErpTest\Services;

use OxErpTest\Services\CallHandlers\CustomCallHandler;
use OxErpTest\Services\CallHandlers\DefaultCallHandler;
use OxErpTest\Structs\ErpTestConfig;

final class CallHandlerFactory
{
    /**
     * @var ErpTestConfig
     */
    private $config;

    /**
     * @var \SoapClient
     */
    private $client;

    /**
     * CallHandlerFactory constructor.
     * @param ErpTestConfig $config
     */
    public function __construct(ErpTestConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @return CustomCallHandler
     */
    public function getCustomCallHandler()
    {
        return new CustomCallHandler(
            $this->getClient(),
            $this->config
        );
    }

    /**
     * @return DefaultCallHandler
     */
    public function getDefaultCallHandler()
    {
        $callHandler = new DefaultCallHandler();
        $callHandler->setClient($this->getClient());

        return $callHandler;
    }

    /**
     * @return \SoapClient
     */
    private function getClient()
    {
        if ($this->client === null) {
            $this->client = new \SoapClient(
                $this->config->getWSDLUrl(),
                [
                    'trace' => 1,
                    'exceptions' => true,
                    'cache_wsdl' => WSDL_CACHE_NONE,
                ]
            );
        }

        return $this->client;
    }
}
