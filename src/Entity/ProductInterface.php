<?php

namespace App\Entity;

interface ProductInterface
{
    public const CSV_PRODUCT_TYPE = 'csv';

    /**
     * @return string
     */
    public function getSku(): string;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getDescription(): string;

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @param string $absolutePath
     * @return string
     */
    public function getProductLink(string $absolutePath): string;
}