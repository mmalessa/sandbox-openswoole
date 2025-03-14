<?php

declare(strict_types=1);

// Test server

$server = new OpenSwoole\Http\Server("0.0.0.0", 80);
$server->on('Start', function (OpenSwoole\Http\Server $server) {
    echo "OpenSwoole http server is started at http://0.0.0.0:8080\n";
});
$server->on("request", function ($req, $res) {
    echo "OpenSwoole http request\n";
    $res->end("Server is working");
});
$server->start();
