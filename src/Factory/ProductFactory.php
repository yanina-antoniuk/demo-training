<?php

namespace App\Factory;

use App\Entity\CsvProduct;
use App\Entity\ProductInterface;

class ProductFactory
{
    /**
     * @param array $arguments
     * @return ProductInterface
     */
    public function create(array $arguments): ProductInterface
    {
        return new CsvProduct($arguments[0], $arguments[1], $arguments[2]);
    }
}