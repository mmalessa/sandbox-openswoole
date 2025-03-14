<?php

declare(strict_types=1);

namespace App\Tests\Manual\Console;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(name: 'test:http-request', description: 'Hello PhpStorm')]
class DemoHttpRequestCommand extends Command
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly string $hermesApiUrl,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $response = $this->httpClient->request(
            'POST',
            rtrim($this->hermesApiUrl, '/') . '/demo/test/?a=b',
            [
//                'headers' => [],
                'json' => ['some' => 'data'],
            ]
        );
        $output->writeln(sprintf('<info>%s</info> %s', $response->getStatusCode(), $response->getContent()));
        return Command::SUCCESS;
    }
}
