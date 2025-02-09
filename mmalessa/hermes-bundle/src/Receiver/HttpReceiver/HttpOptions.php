<?php

declare(strict_types=1);

namespace Mmalessa\Hermes\Receiver\HttpReceiver;

use InvalidArgumentException;
use OpenSwoole\Server;

class HttpOptions
{
    public const SIMPLE_MODE = 'simple';
    public const POOL_MODE = 'pool';

    public string $host = '0.0.0.0';
    public int $port = 80;
    public int $mode = Server::SIMPLE_MODE;
    public array $settings = [];

    public static function createFromArray(array $options): self
    {
        $self = new self();

        foreach ($options as $key => $value) {
            switch ($key) {
                case 'host':
                    $self->host = self::getHost($value);
                    break;
                case 'port':
                    $self->port = self::getPort($value);
                    break;
                case 'mode':
                    $self->mode = self::getMode($value);
                    break;
                case 'settings':
                    $self->settings = self::getSettings($value);
                    break;
            }
        }
        return $self;
    }

    private static function getHost(string $host): string
    {
        return $host;
    }

    private static function getPort(int $port): int
    {
        if ($port < 1 || $port > 65535) {
            throw new InvalidArgumentException(sprintf('Invalid port" %d', $port));
        }
        return $port;
    }

    private static function getMode(string|int $mode): int
    {
        try {
            return match (gettype($mode)) {
                'integer' => (int) $mode,
                'string' => match ($mode) {
                    'simple' => Server::SIMPLE_MODE,
                    'pool' => Server::POOL_MODE,
                }
            };
        } catch (\UnhandledMatchError $e) {
            throw new InvalidArgumentException(sprintf('Invalid mode: %s (%s)', $mode, $e->getMessage()));
        }
    }

    private static function getSettings(array $settings): array
    {
        return $settings;
    }
}
