<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service;

use App\Factory\ProductFactory;
use Symfony\Component\Finder\Finder;

class CsvParser
{
    private string $productsFileDir;

    private string $productsFileName;

    private const FILE_EXT = '.csv';

    private Finder $finder;

    private ProductFactory $productFactory;

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

    public function getParsedProducts(): array
    {
        $files = $this->finder->in($this->productsFileDir);

        $csvStrings = [];

        foreach ($files as $file) {
            if ($file->getFilename() === $this->productsFileName.self::FILE_EXT) {
                $csvStrings = explode(\PHP_EOL, $file->getContents());
            }
        }

        unset($csvStrings[0]);

        $products = [];

        foreach ($csvStrings as $string) {
            if ($string) {
                $data = str_getcsv($string);
                $products[] = $this->productFactory->create($data[0], $data[1], $data[2]);
            }
        }

        return $products;
    }
}
