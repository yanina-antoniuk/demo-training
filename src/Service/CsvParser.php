<?php

namespace App\Service;

use App\Factory\ProductFactory;
use Symfony\Component\Finder\Finder;

class CsvParser
{
    private $productsFileDir;
    private $productsFileName;
    private const FILE_EXT = '.csv';
    /**
     * @var Finder
     */
    private $finder;
    /**
     * @var ProductFactory
     */
    private $productFactory;

    public function __construct(
        string $productsFileDir,
        string $productsFileName,
        Finder $finder,
        ProductFactory $productFactory
    ) {
        $this->productsFileDir = $productsFileDir;
        $this->productsFileName = $productsFileName;
        $this->finder = $finder;
        $this->productFactory = $productFactory;
    }

    /**
     * @return array
     */
    public function getParsedProducts(): array
    {
        $files = $this->finder->in($this->productsFileDir);

        $csvStrings = [];

        foreach ($files as $file) {
            if ($file->getFilename() == $this->productsFileName . self::FILE_EXT) {
                $csvStrings = explode(PHP_EOL, $file->getContents());
            }
        }

        unset($csvStrings[0]);

        $products = [];

        foreach ($csvStrings as $string) {
            if ($string) {
                $products[] = $this->productFactory->create(str_getcsv($string));
            }
        }

        return $products;
    }
}