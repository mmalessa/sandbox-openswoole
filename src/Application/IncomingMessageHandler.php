<?php

declare(strict_types=1);

namespace App\Application;

use Mmalessa\Hermes\IncomingMessageHandlerInterface;

class IncomingMessageHandler implements IncomingMessageHandlerInterface
{

    public function __construct(
        private string $test
    ) {}

    public function handle(string $body, array $headers): string
    {
        printf("BODY: %s\n", $body);
        printf("HEADERS: %s\n", json_encode($headers));
        return 'OK';
    }
}
