<?php

declare(strict_types=1);

namespace Mmalessa\Hermes\Receiver;

class Receivers
{
    private array $receivers;

    public function register(string $name, ReceiverInterface $receiver): void
    {
        $this->receivers[$name] = $receiver;
    }

    public function debug(): void{
//        var_dump($this->receivers);
    }
}
