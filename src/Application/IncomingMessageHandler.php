<?php

declare(strict_types=1);

namespace App\Application;

use Mmalessa\Hermes\IncomingMessageHandlerInterface;

class IncomingMessageHandler implements IncomingMessageHandlerInterface
{

    public function __construct(
        private string $test
    ) {}

    public function handle(string $body, array $stamps)
    {
        echo "BODY: $body\n";
        print_r($stamps);
    }
}
