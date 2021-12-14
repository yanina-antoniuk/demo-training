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

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FirstChainCommand extends Command
{
    private LoggerInterface $logger;

    protected static $defaultName = 'chain:first';

    private const EXCEPTION_MESSAGE = '%s command is a member of command chain and cannot be executed on its own.';

    private string $commandChainId;

    public function __construct(string $commandChainId, LoggerInterface $logger, string $name = null)
    {
        $this->commandChainId = $commandChainId;
        $this->logger = $logger;

        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->setHidden(true)->addArgument('chainId');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if ($input->getArgument('chainId') !== $this->commandChainId) {
            $this->logger->log(LogLevel::ERROR, self::EXCEPTION_MESSAGE, [$this->getName()]);

            return Command::INVALID;
        }
        $message = "Hello from Bar!\n";
        $this->logger->log(LogLevel::INFO, StartChainCommand::EXECUTE_INFO, [$this->getName()]);
        $output->write($message);
        $this->logger->log(LogLevel::INFO, $message);
        $this->logger->log(LogLevel::INFO, 'Execution of foo:hello chain completed!');

        return Command::SUCCESS;
    }
}
