<?php

declare(strict_types=1);

namespace Mmalessa\Hermes\Receiver;

use Mmalessa\Hermes\Options;
use OpenSwoole\Http\Request;
use OpenSwoole\Http\Response;
use OpenSwoole\Http\Server;

class HttpReceiver implements ReceiverInterface
{
    public function __construct(
        private readonly Options $options,
    ) {}

    public function runServer()
    {
        $server = new Server(
            $this->options->host,
            $this->options->port,
            $this->options->mode
        );
        $server->set($this->options->settings);


        $server->on('Request', function(Request $request, Response $response)
        {
            printf("GET: %s\n", json_encode($request->get));
            $response->end('<h1>Hello World!</h1>' . date('Y-m-d H:i:s'));
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
}
