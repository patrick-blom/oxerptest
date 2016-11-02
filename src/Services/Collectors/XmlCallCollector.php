<?php

namespace OxErpTest\Services\Collectors;

use OxErpTest\Services\CollectorInterface;
use OxErpTest\Services\Converter\CallConverter;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class XmlCallCollector extends AbstractCollector implements CollectorInterface
{

    /**
     * @var array
     */
    private $collection = [];

    /**
     * @var string
     */
    private $sessionId;

    /** @var  CallConverter */
    private $converter;

    /**
     * XmlCallCollector constructor.
     * @param $sessionId
     */
    public function __construct($sessionId)
    {
        $this->sessionId = $sessionId;
    }

    /**
     * @return mixed
     */
    public function collect()
    {
        if ($this->checkPaths() && empty($this->collection)) {
            $finder = new Finder();

            /** @var SplFileInfo $file */
            foreach ($finder->files()->in($this->callPath)->name('*.xml') as $file) {
                $oxidXmlCall = $this->getConverter()->convert(
                    $file->getContents()
                );

                array_push($this->collection, $oxidXmlCall);
            }
        }

        return $this->collection;
    }

    private function getConverter()
    {
        if ($this->converter === null) {
            $this->converter = new CallConverter(
                [
                    '##SESSIONID##' => $this->sessionId
                ]
            );
        }

        return $this->converter;
    }
}
