<?php

namespace OxErpTestTest\Service\Converter;

class CallConverterTest extends \PHPUnit_Framework_TestCase
{
    public function testConvertMethodName()
    {
        $xmlString = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:oxer="OXERPService">
                                <soapenv:Header/>
                                <soapenv:Body>
                                   <oxer:OXERPLogin>
                                      <!--Optional:-->
                                      <oxer:sUserName>foo@bar.de</oxer:sUserName>
                                      <!--Optional:-->
                                      <oxer:sPassword>foobar</oxer:sPassword>
                                      <oxer:iShopID>1</oxer:iShopID>
                                      <oxer:iLanguage>0</oxer:iLanguage>
                                   </oxer:OXERPLogin>
                                </soapenv:Body>
                             </soapenv:Envelope>';

        $converter = new \OxErpTest\Services\Converter\CallConverter([]);

        /** @var \OxErpTest\Structs\OxidXmlCall $call */
        $call = $converter->convert($xmlString);

        $this->assertInstanceOf('OxErpTest\Structs\OxidXmlCall', $call);
        $this->assertEquals('OXERPLogin', $call->methodName);
        $this->assertEquals($xmlString, $call->xml);

    }

    public function testConverterReplacement()
    {
        $xmlString = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:oxer="OXERPService">
                            <soapenv:Header/>
                            <soapenv:Body>
                                <oxer:OXERPGetOrder>
                                    <!--Optional:-->
                                    <oxer:sSessionID>##SESSIONID##</oxer:sSessionID>
                                    <!--Optional:-->
                                    <oxer:sOrderID>fancyOrderId</oxer:sOrderID>
                                </oxer:OXERPGetOrder>
                            </soapenv:Body>
                        </soapenv:Envelope>
                        ';

        $converter = new \OxErpTest\Services\Converter\CallConverter(
            [
                '##SESSIONID##' => 'foo'
            ]
        );

        /** @var \OxErpTest\Structs\OxidXmlCall $call */
        $call = $converter->convert($xmlString);

        $this->assertInstanceOf('OxErpTest\Structs\OxidXmlCall', $call);
        $this->assertEquals('OXERPGetOrder', $call->methodName);
        $this->assertEquals(str_replace('##SESSIONID##', 'foo', $xmlString), $call->xml);

    }
}
