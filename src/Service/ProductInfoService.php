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

use App\Entity\ProductInterface;

class ProductInfoService
{
    public function getProductsLinksList(array $products, string $absolutePath): array
    {
        $links = [];

        foreach ($products as $product) {
            if ($product instanceof ProductInterface) {
                $links[] = $absolutePath . '/' . $product->getSku();
            }
        }

        return $links;
    }

    public function getProductInfo(string $productSku, array $products)
    {
        foreach ($products as $product) {
            /* @var ProductInterface */
            if ($product->getSku() === $productSku) {
                return $product->serialize();
            }
        }

        return null;
    }
}
