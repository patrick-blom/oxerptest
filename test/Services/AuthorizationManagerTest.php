<?php

namespace OxErpTestTest\Services;

use OxErpTest\Services\AuthorizationManager;
use OxErpTest\Services\CallHandlerFactory;
use OxErpTest\Structs\ErpTestConfig;

class AuthorizationManagerTest extends \PHPUnit_Framework_TestCase
{

    public function testCanInstantiateAuthorizationManager()
    {
        $config = new ErpTestConfig();
        $authorizationManager = new AuthorizationManager(
            new CallHandlerFactory(
                $config
            ),
            $config
        );

        $this->assertInstanceOf(AuthorizationManager::class, $authorizationManager);
    }
}
