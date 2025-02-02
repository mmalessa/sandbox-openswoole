<?php

declare(strict_types=1);

namespace Mmalessa\Hermes\Console;

use Mmalessa\Hermes\Options;
use Mmalessa\Hermes\Receiver\HttpReceiver;
use Mmalessa\Hermes\Receiver\ReceiverFactory;
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
        private readonly array $hermesConfiguration,
    ) {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->addArgument('receiver', InputArgument::REQUIRED, 'Receiver name (hermes.receivers.*)')
        ;
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $receiverName = $input->getArgument('receiver');
        $receiverType = $this->getReceiverType($receiverName);
        $options = $this->getOptions($receiverName);
        $receiver = ReceiverFactory::create($receiverType, $options);

        $this->logger->info('Start receiver: ' . $receiverName);

        $receiver->receive();

        return Command::SUCCESS;
    }

    private function getReceiverType(string $receiverName): string
    {
        if (!isset($this->hermesConfiguration['receivers'][$receiverName]['type'])) {
            throw new \InvalidArgumentException("Unknown receiver type for receiver '{$receiverName}'");
        }
        return $this->hermesConfiguration['receivers'][$receiverName]['type'];
    }


    private function getOptions(string $receiverName): Options
    {
        if (!isset($this->hermesConfiguration['receivers'][$receiverName])) {
            throw new \InvalidArgumentException("Receiver '{$receiverName}' is not defined");
        }
        $receiversConfiguration = $this->hermesConfiguration['receivers'];
        $receiverConfiguration = $receiversConfiguration[$receiverName];

        return Options::createFromArray($receiverConfiguration['options']);
    }
}
