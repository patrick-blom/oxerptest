<?php

namespace OxErpTest\Commands;

use OxErpTest\Services\Collectors\XmlCallCollector;
use OxErpTest\Services\Collectors\XmlResponseCollector;
use OxErpTest\Structs\OxidXmlCall;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ListTestsCommand extends Command
{

    protected function configure()
    {
        $this->setName('list:tests')
            ->setDescription('List all available tests');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $callCollector = new XmlCallCollector('fakeId');
        $responseCollector = new XmlResponseCollector();

        $io->comment('collecting calls');
        try {
            $callCollection = $callCollector->collect();
        } catch (\Exception $exception) {
            $io->warning($exception->getMessage());
        }

        if (empty($callCollection)) {
            $io->warning('could not find calls to test, plz create some');
        } else {
            $io->note('found ' . count($callCollection) . ' call(s)...');
        }

        $io->comment('collecting responses');
        try {
            $responseCollection = $responseCollector->collect();
        } catch (\Exception $exception) {
            $io->warning($exception->getMessage());
        }

        if (empty($responseCollection)) {
            $io->warning('could not find responses to test');
        } else {
            $io->note('found ' . count($responseCollection) . ' response(s)...');
        }

        $io->comment('creating summary');

        if (empty($callCollection) && empty($responseCollection)) {
            $io->warning('could not find any further data for the summary');
            return 1;
        }

        $callTableHead = [
            'Number',
            'Name of the call',
            'Responsefile available?'
        ];

        $callTableData = [];
        $availableCalls = [];
        /** @var OxidXmlCall $call */
        $iterator = 1;
        foreach ($callCollection as $call) {
            array_push($availableCalls, $call->methodName);
            array_push(
                $callTableData,
                [
                    $iterator,
                    $call->methodName,
                    array_key_exists($call->methodName . 'Response', $responseCollection) ? 'yes' : 'no'
                ]
            );
            $iterator++;
        }

        $io->table(
            $callTableHead,
            $callTableData
        );

        $responseTableHead = [
            'Number',
            'Name of the Response',
            'Callfile available?'
        ];

        $responseTableData = [];
        $iterator = 1;
        foreach ($responseCollection as $responseKey => $response) {
            array_push(
                $responseTableData,
                [
                    $iterator,
                    $responseKey,
                    in_array(str_replace('Response', '', $responseKey), $availableCalls) ? 'yes' : 'no'
                ]
            );
            $iterator++;
        }

        $io->table(
            $responseTableHead,
            $responseTableData
        );

        return 0;
    }


}