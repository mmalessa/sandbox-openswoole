<?php

declare(strict_types=1);

namespace Mmalessa\Hermes\Receiver;

use InvalidArgumentException;
use Mmalessa\Hermes\Options;
use Mmalessa\Hermes\Receiver\HttpReceiver\HttpReceiver;

class ReceiverFactory
{
    public static function create(string $type, Options $options): ReceiverInterface
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
