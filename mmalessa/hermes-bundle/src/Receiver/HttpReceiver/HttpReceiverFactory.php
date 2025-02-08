<?php

declare(strict_types=1);

namespace Mmalessa\Hermes\Receiver\HttpReceiver;

use Mmalessa\Hermes\Receiver\ReceiverFactoryInterface;
use Mmalessa\Hermes\Receiver\ReceiverInterface;

class HttpReceiverFactory implements ReceiverFactoryInterface
{
    public static function type(): string
    {
        return 'http';
    }

    public function create(string $name, array $options): ReceiverInterface
    {
        return new HttpReceiver($options);
    }
}
