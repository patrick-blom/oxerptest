<?php

namespace OxErpTest\Services\Collectors;

use OxErpTest\Services\CollectorInterface;
use OxErpTest\Services\Converter\ResponseConverter;
use Symfony\Component\Finder\Finder;

class XmlResponseCollector implements CollectorInterface
{
    /**
     * @var array
     */
    private $collection = [];


    /** @var  ResponseConverter */
    private $converter;

    /**
     * @return mixed
     */
    public function collect()
    {
        if (empty($this->collection)) {

            $finder = new Finder();
            $path = __DIR__ . '/../../../var/responses';

            foreach ($finder->files()->in($path)->name('*.xml') as $file) {
                $responseString = $this->getConverter()->convert(
                    $file->getContents()
                );

                $this->collection[substr($file->getFilename(), 0, -4)] = $responseString;
            }
        }

        return $this->collection;
    }

    private function getConverter()
    {
        if ($this->converter === null) {
            $this->converter = new ResponseConverter();
        }

        return $this->converter;
    }
}
