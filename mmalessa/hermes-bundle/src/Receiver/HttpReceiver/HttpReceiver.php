<?php

declare(strict_types=1);

namespace Mmalessa\Hermes\Receiver\HttpReceiver;

use Mmalessa\Hermes\IncomingMessageHandlerInterface;
use Mmalessa\Hermes\Receiver\ReceiverInterface;
use OpenSwoole\Http\Request;
use OpenSwoole\Http\Response;
use OpenSwoole\Http\Server;
use OpenSwoole\Server as OpenSwooleServer;
use Psr\Log\LoggerInterface;

class HttpReceiver implements ReceiverInterface
{
    private ?IncomingMessageHandlerInterface $incommingMessageHandler = null;

    public function __construct(
        private readonly array $options,
        private readonly LoggerInterface $logger,
    ) {}

    public function receive(): void
    {
        $serverMode = match (gettype($this->options['mode'])) {
            'integer' => (int) $this->options['mode'],
            'string' => match ($this->options['mode']) {
                'simple' => OpenSwooleServer::SIMPLE_MODE,
                'pool' => OpenSwooleServer::POOL_MODE,
            }
        };

        $server = new Server(
            $this->options['host'],
            $this->options['port'],
            $serverMode,
        );
        $server->set($this->options['settings']);

        $server->on('Request', function(Request $request, Response $response)
        {
            if ($this->incommingMessageHandler === null) {
                $message = "No handler set";
                $this->logger->critical($message);
                $response->status(500);
                $response->end($message);
                return false;
            }
            return $this->handleRequest($request, $response);
        });

        $server->on('Start', function (Server $server) {
            $this->logger->info(sprintf("Server %s:%d start\n", $server->host, $server->port));
        });

        $server->on('Shutdown', function (Server $server) {
            $this->logger->info(sprintf("Server %s:%d shutdown\n", $server->host, $server->port));
        });

//        $server->on('WorkerStart', function (Server $server, int $workerId) {
//            printf("Worker#%d start\n", $workerId);
//        });
//
//        $server->on('WorkerStop', function (Server $server, int $workerId) {
//            printf("Worker #%d shutdown\n", $workerId);
//        });

        $server->start();
    }

    public function setHandler(IncomingMessageHandlerInterface $handler): void
    {
        $this->incommingMessageHandler = $handler;
    }

    private function handleRequest(Request $request, Response $response): bool
    {
        $this->logger->info(
            "Handle HTTP Request",
            [
                'path' => $request->server['request_uri'],
                'method' => $request->server['request_method'],
                'headers' => $request->header,
                'body' => $request->getContent(),
            ]
        );
        // FIXME - add try/catch and so on...
        // TODO handle all types - POST, GET, DELETE...
        $result = $this->incommingMessageHandler->handle(
            $request->getContent(),
            $request->header,
        );
        $this->logger->info("HTTP Request handled");
        $response->end($result);
        return true;
    }
}
