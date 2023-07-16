<?php

namespace BinanceApi\Tests\Helper;

use BinanceApi\Helper\Http;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class HttpTest extends TestCase
{
    public function test_it_has_http_methods()
    {
        $container = [];
        $handlerStack = HandlerStack::create(new MockHandler([
            new Response(),
            new Response(),
            new Response(),
            new Response(),
        ]));
        $handlerStack->push(Middleware::history($container));

        $http = new Http(new Client(['handler' => $handlerStack]));

        $http->get('https://example.com/get', ['HEADER' => 'header-get'], ['query' => 'get']);
        $http->post('https://example.com/post', ['HEADER' => 'header-post'], body: ['body' => 'post']);
        $http->put('https://example.com/put', ['HEADER' => 'header-put'], body: ['body' => 'put']);
        $http->delete('https://example.com/delete', ['HEADER' => 'header-delete'], body: ['body' => 'delete']);

        $expected = [
            ['host' => 'example.com', 'path' => '/get', 'method' => 'GET', 'header' => ['HEADER' => ['header-get']], 'query' => 'query=get', 'body' => ''],
            ['host' => 'example.com', 'path' => '/post', 'method' => 'POST', 'header' => ['HEADER' => ['header-post']], 'query' => '', 'body' => 'body=post'],
            ['host' => 'example.com', 'path' => '/put', 'method' => 'PUT', 'header' => ['HEADER' => ['header-put']], 'query' => '', 'body' => 'body=put'],
            ['host' => 'example.com', 'path' => '/delete', 'method' => 'DELETE', 'header' => ['HEADER' => ['header-delete']], 'query' => '', 'body' => 'body=delete'],
        ];

        foreach ($container as $key => $transaction) {
            $request = $transaction['request'];

            $this->assertEquals($expected[$key]['host'], $request->getUri()->getHost());
            $this->assertEquals($expected[$key]['path'], $request->getUri()->getPath());
            $this->assertEquals($expected[$key]['method'], $request->getMethod());
            $this->assertEquals($expected[$key]['header']['HEADER'], $request->getHeader('HEADER'));
            $this->assertEquals($expected[$key]['query'], $request->getUri()->getQuery());
            $this->assertEquals($expected[$key]['body'], $request->getBody()->getContents());
        }
    }

    public function test_it_throw_error_for_unaccounted_requests()
    {
        $http = new Http(new Client(['handler' => HandlerStack::create(new MockHandler([new Response(200)]))]));

        $this->expectException(Exception::class);

        $http->patch('https://example.com/post', ['HEADER' => 'header-post'], body: ['body' => 'post']);
    }
}
