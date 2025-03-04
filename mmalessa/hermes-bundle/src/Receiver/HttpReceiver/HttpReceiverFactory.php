<?php

declare(strict_types=1);

namespace Mmalessa\Hermes\Receiver\HttpReceiver;

use Mmalessa\Hermes\Receiver\ReceiverFactoryInterface;
use Mmalessa\Hermes\Receiver\ReceiverInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class HttpReceiverFactory implements ReceiverFactoryInterface
{
    public function __construct(
//        private readonly LoggerInterface $logger,
    ) {}

    public static function type(): string
    {
        return 'http';
    }

    public function create(string $name, array $options): ReceiverInterface
    {
        // TODO - implement logger
        return new HttpReceiver($options, new NullLogger());
    }
}
