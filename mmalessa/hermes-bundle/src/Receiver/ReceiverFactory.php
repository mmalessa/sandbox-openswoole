<?php

declare(strict_types=1);

namespace Mmalessa\Hermes\Receiver;

use InvalidArgumentException;
use Mmalessa\Hermes\Receiver\HttpReceiver\HttpReceiver;
use Mmalessa\Hermes\Receiver\HttpReceiver\HttpOptions;

class ReceiverFactory
{
    public static function create(string $type, HttpOptions $options): ReceiverInterface
    {
        $receiverClassName = self::getReceiverClassName($type);
        return new $receiverClassName($options);

    }

    public static function getReceiverClassName(string $type): string
    {
        switch ($type) {
            case 'http':
                return HttpReceiver::class;
        }
        throw new InvalidArgumentException(sprintf('Receiver type "%s" is not supported.', $type));
    }
}
