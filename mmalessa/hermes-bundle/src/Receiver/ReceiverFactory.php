<?php

declare(strict_types=1);

namespace Mmalessa\Hermes\Receiver;

use InvalidArgumentException;
use Mmalessa\Hermes\Options;

class ReceiverFactory
{
    public static function create(string $type, Options $options): ReceiverInterface
    {
        switch ($type) {
            case 'http':
                return new HttpReceiver($options);
        }
        throw new InvalidArgumentException(sprintf('Receiver type "%s" is not supported.', $type));
    }
}
