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

interface ProductInterface
{
    public function getSku(): string;

    public function getName(): string;

    public function getDescription(): string;

    public function getType(): string;

    public function getProductLink(string $absolutePath): string;
}
