<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

class CsvProduct implements ProductInterface
{
    private string $sku;

    private string $name;

    private string $description;

    public function __construct(string $sku, string $name, string $description)
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->description = $description;
    }

    /**
     * {@inheritDoc}
     */
    public function getType(): string
    {
        return ProductInterface::CSV_PRODUCT_TYPE;
    }

    /**
     * {@inheritDoc}
     */
    public function getSku(): string
    {
        return $this->sku;
    }

    /**
     * {@inheritDoc}
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * {@inheritDoc}
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * {@inheritDoc}
     */
    public function getProductLink(string $absolutePath): string
    {
        return $absolutePath.'/'.$this->sku;
    }

    public function serialize(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'sku' => $this->sku,
        ];
    }
}
