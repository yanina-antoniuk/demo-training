<?php

namespace App\Command;

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StartChainCommand extends Command
{
    private LoggerInterface $logger;

    private const CHAIN_INFO = '%s registered as a member of %s command chain';

    public const EXECUTE_INFO = 'Executing %s from chain members';

    protected static $defaultName = 'app:start-chain';

    protected static $defaultDescription = 'Runs chain of commands';

    private string $commandChainId;

    public function __construct(string $commandChainId, LoggerInterface $logger, string $name = null)
    {
        $this->commandChainId = $commandChainId;
        $this->logger = $logger;

        parent::__construct($name);
    }

    public function configure()
    {
        parent::configure();
        $this->setDescription(
            '%s is a master command of a command chain that has registered member commands'
        );
    }

    /**
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->logger->info(sprintf(
            $this->getDescription(),
            $this->getName()
        ));
        $firstCommandName = 'chain:first';

        $this->logger->info(sprintf(
            self::CHAIN_INFO,
            $firstCommandName,
            $this->getName()
        ));

        $this->logger->info(sprintf(
            self::EXECUTE_INFO,
            $this->getName()
        ));

        $message = "Hello from Foo!\n";
        $output->write($message);

        $this->logger->info($message);

        $command = $this->getApplication()->find($firstCommandName);

        $arguments = [
            'command' => $firstCommandName,
            'chainId' => $this->commandChainId
        ];
        $subCommandInput = new ArrayInput($arguments);

        return $command->run($subCommandInput, $output);
    }
}
