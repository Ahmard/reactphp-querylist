<?php

namespace ReactphpQuerylist\Tests;

use ReactphpQuerylist\Queryable;
use Exception;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use QL\QueryList;
use React\EventLoop\Loop;
use React\Promise\PromiseInterface;
use function Clue\React\Block\await;

class ClientTest extends TestCase
{
    public function testRequestMethods(): void
    {
        self::assertInstanceOf(PromiseInterface::class, TestableClient::get('/'));
        self::assertInstanceOf(PromiseInterface::class, TestableClient::post('/'));
        self::assertInstanceOf(PromiseInterface::class, TestableClient::head('/'));
        self::assertInstanceOf(PromiseInterface::class, TestableClient::delete('/'));
        self::assertInstanceOf(PromiseInterface::class, TestableClient::put('/'));
        self::assertInstanceOf(PromiseInterface::class, TestableClient::patch('/'));
    }

    /**
     * @throws Exception
     */
    public function testQueryAble(): void
    {
        $queryAble = await(TestableClient::get('/'), Loop::get());

        self::assertInstanceOf(Queryable::class, $queryAble);
        self::assertInstanceOf(ResponseInterface::class, $queryAble->response());
        self::assertInstanceOf(QueryList::class, $queryAble->queryList());
    }
}
