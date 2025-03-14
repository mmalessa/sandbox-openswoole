<?php

declare(strict_types=1);

namespace App\Application;

use Mmalessa\Hermes\IncomingMessageHandlerInterface;
use Psr\Log\LoggerInterface;

class IncomingMessageHandler implements IncomingMessageHandlerInterface
{
    private const string SUCCESS_STRING = 'OK';

    public function __construct(
        private readonly LoggerInterface $logger,
    ) {}

    public function handle(string $body, array $headers): string
    {
        $this->logger->info(
            "Incoming message received",
            [
                "headers" => $headers,
                "body" => $body,
            ]
        );
        return self::SUCCESS_STRING;
    }
}
