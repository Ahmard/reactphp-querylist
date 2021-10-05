<?php

namespace ReactphpQuerylist;

use Psr\Http\Message\ResponseInterface;
use React\Http\Browser;
use React\Promise\Deferred;
use React\Promise\PromiseInterface;
use React\Stream\ReadableStreamInterface;

class Client
{
    /**
     * @param string $requestMethod
     * @param string $url
     * @param array $headers
     * @param ReadableStreamInterface|string $body
     * @return PromiseInterface
     */
    public function execute(
        string $requestMethod,
        string $url,
        array  $headers = [],
               $body = ''
    ): PromiseInterface
    {
        return $this->prepareQueryable(
            (new Browser())->request($requestMethod, $url, $headers, $body)
        );
    }

    /**
     * Construct QueryList object from response body
     *
     * @param PromiseInterface $promise
     * @return PromiseInterface
     */
    protected function prepareQueryable(PromiseInterface $promise): PromiseInterface
    {
        $deferred = new Deferred();

        // Construct queryable object when request is success
        $promise->then(function (ResponseInterface $response) use ($deferred) {
            $deferred->resolve(new Queryable($response));
        });

        // Forward any error to child promise
        $promise->otherwise(fn($reason) => $deferred->reject($reason));

        return $deferred->promise();
    }

    /**
     * Send http GET request
     *
     * @param string $url
     * @param array $headers
     * @return PromiseInterface
     */
    public static function get(string $url, array $headers = []): PromiseInterface
    {
        return (new static())->execute('GET', $url, $headers);
    }

    /**
     * Send http POST request
     *
     * @param string $url
     * @param array $headers
     * @param ReadableStreamInterface|string $body
     * @return PromiseInterface
     */
    public static function post(string $url, array $headers = [], $body = ''): PromiseInterface
    {
        return (new static())->execute('POST', $url, $headers, $body);
    }

    /**
     * Send http HEAD request
     *
     * @param string $url
     * @param array $headers
     * @return PromiseInterface
     */
    public static function head(string $url, array $headers = []): PromiseInterface
    {
        return (new static())->execute('HEAD', $url, $headers);
    }

    /**
     * Send http PATCH request
     *
     * @param string $url
     * @param array $headers
     * @param ReadableStreamInterface|string $body
     * @return PromiseInterface
     */
    public static function patch(string $url, array $headers = [], $body = ''): PromiseInterface
    {
        return (new static())->execute('PATCH', $url, $headers, $body);
    }

    /**
     * Send http PUT request
     *
     * @param string $url
     * @param array $headers
     * @param ReadableStreamInterface|string $body
     * @return PromiseInterface
     */
    public static function put(string $url, array $headers = [], $body = ''): PromiseInterface
    {
        return (new static())->execute('PUT', $url, $headers, $body);
    }

    /**
     * Send http DELETE request
     *
     * @param string $url
     * @param array $headers
     * @return PromiseInterface
     */
    public static function delete(string $url, array $headers = []): PromiseInterface
    {
        return (new static())->execute('DELETE', $url, $headers);
    }

    /**
     * Submit post request with json body
     *
     * @param string $url
     * @param array $payload ['key' => 'value']
     * @param array $headers
     * @return PromiseInterface
     */
    public static function postJson(string $url, array $payload, array $headers = []): PromiseInterface
    {
        return self::post(
            $url,
            array_merge(['Content-Type' => 'application/json'], $headers),
            json_encode($payload)
        );
    }

    /**
     * Submit form
     *
     * @param string $url
     * @param array $fields ['name' => 'John Doe']
     * @param array $headers
     * @return PromiseInterface
     */
    public static function postForm(string $url, array $fields, array $headers = []): PromiseInterface
    {
        return self::post(
            $url,
            array_merge(['Content-Type' => 'application/x-www-form-urlencoded'], $headers),
            http_build_query($fields)
        );
    }
}