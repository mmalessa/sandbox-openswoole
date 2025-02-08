<?php

declare(strict_types=1);

namespace Mmalessa\Hermes\Receiver;

use Mmalessa\Hermes\IncomingMessageHandlerInterface;

interface ReceiverInterface
{
    public function receive(): void;
    public function setHandler(IncomingMessageHandlerInterface $handler): void;
}
