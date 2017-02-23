<?php

namespace OxErpTestTest\Services;

use OxErpTest\Services\CallHandlerFactory;
use OxErpTest\Structs\ErpTestConfig;

class CallHandlerFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCanInstantiateFactory()
    {
        $factory = new CallHandlerFactory(
            new ErpTestConfig()
        );

        $this->assertInstanceOf(CallHandlerFactory::class, $factory);
    }

}
