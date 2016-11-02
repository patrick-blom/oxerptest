<?php

namespace OxErpTest\Services\Collectors;

abstract class AbstractCollector
{
    /**
     * @var string
     */
    protected $callPath;

    /**
     * @var string
     */
    protected $responsePath;

    /**
     * @return bool
     * @throws \Exception
     */
    protected function checkPaths()
    {
        $baseDir = '';
        if (!\Phar::running()) {
            $baseDir = __DIR__ . '/../../../';
        } else {
            $outerBaseDir = dirname(\Phar::running(false));
            try {
                if (!is_dir($outerBaseDir . '/var/calls/')) {
                    \Phar::mount('var/calls/', $outerBaseDir . '/var/calls/');
                }
                if (!is_dir($outerBaseDir . '/var/responses/')) {
                    \Phar::mount('var/responses/', $outerBaseDir . '/var/responses/');
                }
            } catch (\PharException $e) {
                throw new \Exception(
                    'It seems that you are using a phar. Please create ./var/calls and ./var/responses directory'
                );
            }
        }

        $this->callPath = $baseDir . 'var/calls/';
        $this->responsePath = $baseDir . 'var/responses/';

        // check not necessary in phar
        if (!\Phar::running() && (!is_dir($this->callPath) || !is_dir($this->responsePath))) {
            throw new \Exception(
                'Please create ./var/calls and ./var/responses directory'
            );
        }

        return true;
    }
}