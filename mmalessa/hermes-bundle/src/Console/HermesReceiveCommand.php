<?php

declare(strict_types=1);

namespace Mmalessa\Hermes\Console;

use OpenSwoole\Http\Server;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'hermes:receive', description: 'Hermes receive')]
class HermesReceiveCommand extends Command
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly ContainerInterface $container,
    ) {
        parent::__construct();
    }

    protected function configure()
    {
        $this->addArgument('receiver', InputArgument::REQUIRED, 'Receiver name');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // TODO - handle Ctrl+C

        $this->logger->info("START");
        $receiverName = $input->getArgument('receiver');
        $receiver = $this->container->get(sprintf('hermes.receiver.%s', $receiverName));
        $receiver->receive();

        return Command::SUCCESS;
    }
}
