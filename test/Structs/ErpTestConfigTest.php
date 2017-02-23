<?php

namespace OxErpTestTest\Structs;


use OxErpTest\Structs\ErpTestConfig;

class ErpTestConfigTest extends \PHPUnit_Framework_TestCase
{
    public function testCanInstantiateClass()
    {
        $config = new ErpTestConfig();

        $this->assertInstanceOf(ErpTestConfig::class, $config);
    }

    public function testGetWSDLPath()
    {
        $config = new ErpTestConfig(
            [
                'userName' => 'foo',
                'password' => 'bar',
                'shopUrl' => 'http://www.patrick-blom.de',
                'shopId' => 1,
                'languageId' => 0,
                'erpVersion' => '2.14',
            ]
        );

        $this->assertSame('http://www.patrick-blom.de/modules/erp/oxerpservice.php?wsdl&version=2.14', $config->getWSDLUrl());
        $this->assertSame('http://www.patrick-blom.de/modules/erp/oxerpservice.php?version=2.14', $config->getSoapLoacation());

    }
}
