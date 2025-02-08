<?php

declare(strict_types=1);

namespace Mmalessa\Hermes\Receiver;

interface ReceiverFactoryInterface
{
    public static function type(): string;
    public function create(string $name, array $options): ReceiverInterface;
}