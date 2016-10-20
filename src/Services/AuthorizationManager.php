<?php

namespace OxErpTest\Services;


use OxErpTest\Structs\ErpTestConfig;

class AuthorizationManager
{
    /**
     * @var CallHandlerFactory
     */
    private $callHandlerFactory;

    /**
     * @var ErpTestConfig
     */
    private $config;

    /**
     * AuthorizationManager constructor.
     * @param CallHandlerFactory $callHandlerFactory
     * @param ErpTestConfig $config
     */
    public function __construct(CallHandlerFactory $callHandlerFactory, ErpTestConfig $config)
    {
        $this->callHandlerFactory = $callHandlerFactory;
        $this->config = $config;
    }


    /**
     * @return mixed
     * @throws \Exception
     */
    public function authorize()
    {
        $response = $this->callHandlerFactory->getDefaultCallHandler()->call(
            'OXERPLogin',
            [
                'sUserName' => $this->config->userName,
                'sPassword' => $this->config->password,
                'iShopID' => $this->config->shopId,
                'iLanguage' => $this->config->languageId
            ]

        );

        if (!property_exists($response, 'OXERPLoginResult') || !$response->OXERPLoginResult->blResult) {
            throw new \Exception('Login Failed! Plz check the credentials');
        }

        return $response->OXERPLoginResult->sMessage;
    }

}
