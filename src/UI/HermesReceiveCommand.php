<?php

declare(strict_types=1);

namespace App\UI;

use Mmalessa\Hermes\Options;
use Mmalessa\Hermes\Receiver\HttpReceiver;
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
        $this->logger->info('Start receiver: ' . $receiverName);

        $receiversConfiguration = $this->hermesConfiguration['receivers'];
        $receiverConfiguration = $receiversConfiguration[$receiverName];

        $options = Options::createFromArray($receiverConfiguration['options']);
        $receiver = new HttpReceiver($options);
        $receiver->runServer();

        return Command::SUCCESS;
    }
}
