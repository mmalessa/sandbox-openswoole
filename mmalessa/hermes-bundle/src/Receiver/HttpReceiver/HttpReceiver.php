<?php

declare(strict_types=1);

namespace Mmalessa\Hermes\Receiver\HttpReceiver;

use Mmalessa\Hermes\IncomingMessageHandlerInterface;
use Mmalessa\Hermes\Receiver\ReceiverInterface;
use OpenSwoole\Http\Request;
use OpenSwoole\Http\Response;
use OpenSwoole\Http\Server;

class HttpReceiver implements ReceiverInterface
{
    private ?IncomingMessageHandlerInterface $incommingMessageHandler = null;

    public function __construct(
        private readonly array $options,
    ) {}

    public function receive(): void
    {
        $server = new Server(
            $this->options['host'],
            $this->options['port'],
            $this->options['mode']
        );
        $server->set($this->options['settings']);


        $server->on('Request', function(Request $request, Response $response)
        {
            if ($this->incommingMessageHandler === null) {
                printf("NO HANDLER - GET: %s\n", json_encode($request->get));
                $response->end("NO HANDLER");
            }
            printf("GET AND HANDLE: %s\n", json_encode($request->get));

            // FIXME - add try/catch and so on...
            $this->incommingMessageHandler->handle('some body', ['key' => 'value']);

            $response->end('HANDLED');
        });

        $server->on('WorkerStart', function (Server $server, int $workerId) {
            printf("Worker#%d start\n", $workerId);
        });

        $server->on('Start', function (Server $server) {
            printf("Server %s:%d start\n", $server->host, $server->port);
        });

        $server->on('Shutdown', function (Server $server) {
            printf("Server %s:%d shutdown\n", $server->host, $server->port);
        });

        $server->on('WorkerStop', function (Server $server, int $workerId) {
            printf("Worker #%d shutdown\n", $workerId);
        });

        $server->start();
    }

    public function setHandler(IncomingMessageHandlerInterface $handler): void
    {
        $this->incommingMessageHandler = $handler;
    }
}
