<?php

namespace OxErpTest\Services\Collectors;

use OxErpTest\Services\CollectorInterface;
use Symfony\Component\Finder\Finder;

final class XmlResponseCollector extends AbstractCollector implements CollectorInterface
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
        if ($this->checkPaths() && empty($this->collection)) {
            $finder = new Finder();

            foreach ($finder->files()->in($this->responsePath)->name('*.xml') as $file) {
                $responseString = $file->getContents();

                $this->collection[substr($file->getFilename(), 0, -4)] = $responseString;
            }
        }

        return $this->collection;
    }
}
