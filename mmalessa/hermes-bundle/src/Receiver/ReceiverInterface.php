<?php

declare(strict_types=1);

namespace Mmalessa\Hermes\Receiver;

interface ReceiverInterface
{
    public function receive(): void;
}
