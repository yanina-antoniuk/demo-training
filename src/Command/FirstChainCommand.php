<?php

namespace App\Command;

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\CommandNotFoundException;
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
            throw new CommandNotFoundException(sprintf(self::EXCEPTION_MESSAGE, $this->getName()));
        }
        $message = "Hello from Bar!\n";
        $this->logger->info(sprintf(StartChainCommand::EXECUTE_INFO, $this->getName()));
        $output->write($message);
        $this->logger->info($message);
        $this->logger->info('Execution of foo:hello chain completed!');

        return Command::SUCCESS;
    }
}
