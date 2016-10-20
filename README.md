##OxERPTest
Test your OXID ERP in a automated way.

OxERPTest is a CLI Tool based on Symfony2 which calls the OXID ERP and compares the result.

##Installation
1. Install the dependencies using composer
2. Create the calls you want to test in `var/calls/` as xml files. Use the name given by the OXID ERP naming convention 
e.g. OXERPGetOrder.xml . 
3. Create the equivalent response xml files for your tests in `var/responses`. Append the term Response to the call name
 e.g. OXERPGetOrderResponse.xml.
 
##Usage
###The test all command
Test all your calls using the command
```
php bin/oxerptest test:all https://www.my-oxidshop.com username password

 // authorizing against the erp                                                                                         

 // collection calls                                                                                                    

 // got 2 calls start testing...                                                                                        

                                                                                                                        
 [OK] OXERPGetArticle: test passed                                                                                      
                                                                                                                                                                                                                                                
 [OK] OXERPGetOrder: test passed                                                                                        
```

You can use the optional commands to modify the default behavior:
```
Options:
      --shopId=SHOPID            the shopId you want to test [default: "1"]
      --languageId=LANGUAGEID    the languageId of the shop you want to test [default: "0"]
      --wsdlversion=WSDLVERSION  the version number of the wsdl [default: "2.12"]
```

###The test on command
Test one specific call
```
php bin/oxerptest test:one https://www.my-oxidshop.com username password OXREPGetOrder.xml

 // authorizing against the erp                                                                                         
                                                                                                                                                                                                                                                
 [OK] OXERPGetOrder: test passed                                                                                        
```

You can use the optional commands to modify the default behavior:
```
Options:
      --shopId=SHOPID            the shopId you want to test [default: "1"]
      --languageId=LANGUAGEID    the languageId of the shop you want to test [default: "0"]
      --wsdlversion=WSDLVERSION  the version number of the wsdl [default: "2.12"]
```

##Tests
You can test OxERPTest using `php vendor/bin/phpunit tests/`
