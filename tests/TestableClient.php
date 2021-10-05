<?php

namespace ReactphpQuerylist\Tests;

use ReactphpQuerylist\Client;
use React\Http\Message\Response;
use React\Promise\Deferred;
use React\Promise\PromiseInterface;

class TestableClient extends Client
{
    public function execute(string $requestMethod, string $url, array $headers = [], $body = ''): PromiseInterface
    {
        $deferred = new Deferred();

        $deferred->resolve(new Response(200, [], uniqid()));

        return $this->prepareQueryable($deferred->promise());
    }
}