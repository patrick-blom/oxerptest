<?php

namespace OxErpTest\Services\Collectors;

abstract class AbstractCollector
{
    const VAR_PATH = __DIR__ . '/../../../var';
    const CALL_PATH = self::VAR_PATH . '/calls';
    const RESPONSES_PATH = self::VAR_PATH . '/responses';

    /**
     * @return bool
     * @throws \Exception
     */
    protected function ensurePath()
    {
        if (!is_dir(self::VAR_PATH)) {
            throw new \Exception('could not find ./var directory plz create it');
        }

        if (!is_dir(self::CALL_PATH)) {
            throw new \Exception('could not find ./var/calls directory plz create it, and add some calls');
        }

        if (!is_dir(self::RESPONSES_PATH)) {
            throw new \Exception('could not find ./var/responses directory plz create it, and add some responses');
        }

        return true;
    }
}