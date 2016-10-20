<?php

namespace OxErpTest\Commands;

use OxErpTest\Services\AuthorizationManager;
use OxErpTest\Services\CallHandlerFactory;
use OxErpTest\Services\Collectors\XmlCallCollector;
use OxErpTest\Services\Converter\CallConverter;
use OxErpTest\Services\ResponseValidator;
use OxErpTest\Structs\ErpTestConfig;
use OxErpTest\Structs\OxidXmlCall;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Finder\Finder;

class TestSingleCallCommand extends Command
{
    protected function configure()
    {
        $this->setName('test:one')
            ->setDescription('Runs a single tests against the ERP')
            ->addArgument(
                'shopurl',
                InputArgument::REQUIRED,
                'the oxid shop url'
            )->addArgument(
                'username',
                InputArgument::REQUIRED,
                'the username with access to the erp'
            )->addArgument(
                'password',
                InputArgument::REQUIRED,
                'the password of the user'
            )->addArgument(
                'callfile',
                InputArgument::REQUIRED,
                'the filename of the call you want to test'
            )->addOption(
                'shopId',
                null,
                InputArgument::OPTIONAL,
                'the shopId you want to test',
                '1'
            )->addOption(
                'languageId',
                null,
                InputArgument::OPTIONAL,
                'the languageId of the shop you want to test',
                '0'
            )->addOption(
                'wsdlversion',
                null,
                InputArgument::OPTIONAL,
                'the version number of the wsdl',
                '2.12'
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $config = new ErpTestConfig([
                'userName' => $input->getArgument('username'),
                'password' => $input->getArgument('password'),
                'shopUrl' => $input->getArgument('shopurl'),
                'shopId' => $input->getOption('shopId'),
                'languageId' => $input->getOption('languageId'),
                'erpVersion' => $input->getOption('wsdlversion'),
            ]
        );

        $path = __DIR__ . '/../../var/calls/' . $input->getArgument('callfile');
        if (!is_file($path)) {
            $io->error('could not load file: ' . $path);
            return 1;
        }

        $io->comment('authorizing against the erp');
        $callHandlerFactory = new CallHandlerFactory($config);
        $authorizationManger = new AuthorizationManager($callHandlerFactory, $config);
        $sessionId = $authorizationManger->authorize();

        $converter = new CallConverter(
            [
                '##SESSIONID##' => $sessionId
            ]
        );

        $oxidXmlCall = $converter->convert(file_get_contents($path));

        try {
            $customCallHandler = $callHandlerFactory->getCustomCallHandler();
            $response = $customCallHandler->call($oxidXmlCall);

            $responseValidator = new ResponseValidator();
            $result = $responseValidator->validate($response, $oxidXmlCall->methodName);

            if ($result) {
                $io->success($oxidXmlCall->methodName . ': test passed');
            } else {
                $io->note($oxidXmlCall->methodName . ': call ok, but content compare faild');
            }

        } catch (\Exception $exc) {
            $io->warning($oxidXmlCall->methodName . ": test faild with exception " . $exc->getMessage());
        }

        return 0;
    }

}
