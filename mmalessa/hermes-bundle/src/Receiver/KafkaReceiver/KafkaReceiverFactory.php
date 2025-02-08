<?php

declare(strict_types=1);

namespace Mmalessa\Hermes\Receiver\KafkaReceiver;

use Mmalessa\Hermes\Receiver\ReceiverFactoryInterface;
use Mmalessa\Hermes\Receiver\ReceiverInterface;

class KafkaReceiverFactory implements ReceiverFactoryInterface
{
    public static function type(): string
    {
        return 'kafka';
    }

    public function create(string $name, array $options): ReceiverInterface
    {
        return new KafkaReceiver($options);
    }
}
