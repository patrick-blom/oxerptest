<?php

namespace OxErpTest\Services\Collectors;

use OxErpTest\Services\CollectorInterface;
use Symfony\Component\Finder\Finder;

class XmlResponseCollector implements CollectorInterface
{
    /**
     * @var array
     */
    private $collection = [];

    /**
     * @return mixed
     */
    public function collect()
    {
        if (empty($this->collection)) {

            $finder = new Finder();
            $path = __DIR__ . '/../../../var/responses';

            foreach ($finder->files()->in($path)->name('*.xml') as $file) {
                $responseString = $file->getContents();

                $this->collection[substr($file->getFilename(), 0, -4)] = $responseString;
            }
        }

        return $this->collection;
    }
}
