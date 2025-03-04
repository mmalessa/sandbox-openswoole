<?php

declare(strict_types=1);

namespace Mmalessa\Hermes;

interface IncomingMessageHandlerInterface
{
    public function handle(string $body, array $headers): string;
}
