<?php

declare(strict_types=1);

namespace Mmalessa\Hermes\Receiver\KafkaReceiver;

use Mmalessa\Hermes\IncomingMessageHandlerInterface;
use Mmalessa\Hermes\Receiver\ReceiverInterface;

class KafkaReceiver implements ReceiverInterface
{
    public function receive(): void
    {
        // TODO: Implement receive() method.
    }

    public function setHandler(IncomingMessageHandlerInterface $handler): void
    {
        // TODO: Implement setHandler() method.
    }
}
