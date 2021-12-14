<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Command;

use App\Entity\Product;
use App\Entity\ProductImage;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProductDataLoadCommand extends Command
{
    private Factory $faker;

    private EntityManagerInterface $entityManager;

    protected static $defaultName = 'app:data:load';

    public function __construct(Factory $faker, EntityManagerInterface $entityManager, string $name = null)
    {
        $this->faker = $faker;
        $this->entityManager = $entityManager;

        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $products = $this->generateItems(500);
        $productImages = $this->generateItems(100);
        $productImagesArray = [];

        foreach ($productImages as $title) {
            $productImage = new ProductImage($title);
            $productImagesArray[] = $productImage;
            $this->entityManager->persist($productImage);
        }

        $this->entityManager->flush();

        foreach ($products as $title) {
            $product = new Product($title);
            $product->setProductImage($productImagesArray[rand(0, \count($productImagesArray) - 1)]);
            $this->entityManager->persist($product);
        }

        $this->entityManager->flush();

        return Command::SUCCESS;
    }

    private function generateItems(int $amount): ?array
    {
        $generator = $this->faker->create();

        $products = [];

        for ($i = 0; $i < $amount; ++$i) {
            $products[] = $generator->word;
        }

        return $products;
    }
}
