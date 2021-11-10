<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Factory;

use App\Entity\CsvProduct;
use App\Entity\ProductInterface;

class ProductFactory
{
    public function create(array $arguments): ProductInterface
    {
        return new CsvProduct($arguments[0], $arguments[1], $arguments[2]);
    }
}
