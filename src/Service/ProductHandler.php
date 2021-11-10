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

class ProductHandler
{
    /**
     * @param $products
     * @param $absolutePath
     */
    public function getProductsLinksList($products, $absolutePath): array
    {
        $links = [];

        foreach ($products as $product) {
            if ($product instanceof ProductInterface) {
                $links[] = $product->getProductLink($absolutePath);
            }
        }

        return $links;
    }

    public function getProductInfo(string $productSku, array $productArray): ?object
    {
        foreach ($productArray as $product) {
            /* @var ProductInterface */
            if ($product->getSku() === $productSku) {
                return json_decode(json_encode($product->serialize()));
            }
        }

        return null;
    }
}
