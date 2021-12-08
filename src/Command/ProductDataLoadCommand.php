<?php

namespace App\Command;


use Faker\Factory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProductDataLoadCommand extends Command
{
    private Factory $faker;

    protected static $defaultName = 'app:data:load';

    public function __construct(Factory $faker, string $name = null)
    {
        $this->faker = $faker;
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $generator = $this->faker->create();

        return Command::SUCCESS;
    }
}
