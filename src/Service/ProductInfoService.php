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
    /**
     * @param array $products
     * @param string $absolutePath
     * @return array
     */
    public function getProductsLinksList(array $products,string $absolutePath): array
    {
        $links = [];

        foreach ($products as $product) {
            if ($product instanceof ProductInterface) {
                $links[] = $product->getProductLink($absolutePath);
            }
        }

        return $links;
    }

    /**
     * @param string $productSku
     * @param array $products
     * @return object|null
     */
    public function getProductInfo(string $productSku, array $products): ?object
    {
        foreach ($products as $product) {
            /* @var ProductInterface */
            if ($product->getSku() === $productSku) {
                return json_decode(json_encode($product->serialize()));
            }
        }

        return null;
    }
}
