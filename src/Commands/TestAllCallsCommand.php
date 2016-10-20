<?php

namespace OxErpTest\Commands;

use OxErpTest\Container;
use OxErpTest\Services\AuthorizationManager;
use OxErpTest\Services\CallHandlerFactory;
use OxErpTest\Structs\ErpTestConfig;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class TestAllCallsCommand extends Command
{
    protected function configure()
    {
        $this->setName('test:all')
            ->setDescription('Runs all tests against the ERP')
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

        $authorizationManger = new AuthorizationManager(
            new CallHandlerFactory($config),
            $config
        );

        $sessionId = $authorizationManger->authorize();



        return 0;
    }

}
