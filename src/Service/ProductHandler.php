<?php

namespace App\Service;

use App\Entity\ProductInterface;

class ProductHandler
{
    /**
     * @param $products
     * @param $absolutePath
     * @return array
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

    /**
     * @param string $productSku
     * @param array $productArray
     * @return object|null
     */
    public function getProductInfo(string $productSku, array $productArray): ?object
    {
        foreach ($productArray as $product) {
            /** @var ProductInterface */
            if ($product->getSku() === $productSku) {
                return json_decode(json_encode($product->serialize()));
            }
        }

        return null;
    }
}