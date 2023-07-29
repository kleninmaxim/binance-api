<?php

namespace BinanceApi\Tests;

use BinanceApi\Binance;
use BinanceApi\Docs\MarketDataEndpoint\OrderBook;
use BinanceApi\Exception\BinanceResponseException;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class BinanceTest extends TestCase
{
    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->client = $this->createMock(Client::class);

        $this->binance = new Binance(client: $this->client);
    }

    public function test_throw_exception_when_get_error_message()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->will($this->returnValueMap([[
                'GET',
                'https://api.binance.com/api/v3/ping',
                [],
                new Response(body: json_encode(['msg' => 'some error from binance', 'code' => '-1123']))
            ]]));

        $this->expectException(BinanceResponseException::class);

        $this->binance->ping();
    }

    public function test_return_message_when_get_error_message()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->will($this->returnValueMap([[
                'GET',
                'https://api.binance.com/api/v3/ping',
                [],
                new Response(body: json_encode(['msg' => 'some error from binance', 'code' => '-1123']))
            ]]));

        $this->binance->disableBinanceExceptions();

        $this->assertEquals(
            ['msg' => 'some error from binance', 'code' => '-1123'],
            $this->binance->ping()['response']['data']
        );
    }

    public function test_it_get_full_output_without_callback()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('GET'),
                $this->equalTo('https://api.binance.com/api/v3/depth'),
                $this->callback(function ($options) {
                    return $options['query']['symbol'] == 'BTCUSDT' && $options['query']['limit'] == 100;
                }),
            )
            ->willReturn(new Response(headers: ['x-example' => 'header'], body: OrderBook::exampleResponse()));

        $result = json_decode(OrderBook::exampleResponse(), true);

        $result['bids'] = array_map(
            function ($bid) {
                [$price, $amount] = $bid;
                return ['price' => $price, 'amount' => $amount];
            },
            $result['bids']
        );

        $result['asks'] = array_map(
            function ($ask) {
                [$price, $amount] = $ask;
                return ['price' => $price, 'amount' => $amount];
            },
            $result['asks']
        );

        $this->assertEquals(
            [
                'request' => [
                    'url' => '/api/v3/depth',
                    'headers' => [],
                    'query' => ['symbol' => 'BTCUSDT', 'limit' => 100],
                    'body' => [],
                ],
                'response' => [
                    'data' => $result,
                    'info' => [
                        'statusCode' => 200,
                        'reasonPhrase' => 'OK',
                        'headers' => [
                            'x-example' => ['header']
                        ]
                    ]
                ]
            ],
            $this->binance->orderbook('BTCUSDT')
        );
    }

    public function test_it_get_output_with_callback()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('GET'),
                $this->equalTo('https://api.binance.com/api/v3/depth'),
                $this->callback(function ($options) {
                    return $options['query']['symbol'] == 'BTCUSDT' && $options['query']['limit'] == 100;
                }),
            )
            ->willReturn(new Response(body: OrderBook::exampleResponse()));

        $result = json_decode(OrderBook::exampleResponse(), true);

        $result['bids'] = array_map(
            function ($bid) {
                [$price, $amount] = $bid;
                return ['price' => $price, 'amount' => $amount];
            },
            $result['bids']
        );

        $result['asks'] = array_map(
            function ($ask) {
                [$price, $amount] = $ask;
                return ['price' => $price, 'amount' => $amount];
            },
            $result['asks']
        );

        $this->binance->setOutputCallback(function ($output) {
            return $output['response']['data'];
        });

        $this->assertEquals($result, $this->binance->orderbook('BTCUSDT'));
    }

    public function test_it_has_additions()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('GET'),
                $this->equalTo('https://api.binance.com/api/v3/depth'),
                $this->callback(function ($options) {
                    return $options['query']['symbol'] == 'BTCUSDT' && $options['query']['limit'] == 100;
                }),
            )
            ->willReturn(new Response(headers: ['x-mbx-used-weight-1m' => '50', 'Date' => '2023-07-24 22:22:22'], body: OrderBook::exampleResponse()));

        $this->binance->orderbook('BTCUSDT');

        $this->assertEquals(
            [
                'limits' => [
                    'IP' => [
                        'api' => [
                            'used' => 50,
                            'lastRequest' => '2023-07-24 22:22:22',
                        ],
                        'sapi' => [
                            'used' => 0,
                            'lastRequest' => '',
                        ]
                    ],
                    'Account' => [
                        'count' => 0,
                        'lastRequest' => '',
                    ]
                ]
            ],
            $this->binance->getAdditional()
        );
    }
}
