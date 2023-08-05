<?php

namespace BinanceApi\Tests\Binance\Analogs;

use BinanceApi\Spot\Binance;
use BinanceApi\Spot\Docs\MarketDataEndpoint\OrderBook;
use BinanceApi\Spot\Docs\MarketDataEndpoint\RecentTradesList;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class MarketDataEndpointTest extends TestCase
{
    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->client = $this->createMock(Client::class);

        $this->binance = new Binance(client: $this->client);
    }

    public function test_http_orderbook_analog()
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

        $this->binance->orderbook(symbol: 'BTCUSDT');
    }

    public function test_http_orderbookBTCUSDT_analog()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('GET'),
                $this->equalTo('https://api.binance.com/api/v3/depth'),
                $this->callback(function ($options) {
                    return $options['query']['symbol'] == 'BTCUSDT' && $options['query']['limit'] == 15;
                }),
            )
            ->willReturn(new Response(body: OrderBook::exampleResponse()));

        $this->binance->orderbookBTCUSDT(15);
    }

    public function test_http_tradesBTCUSDT_analog()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('GET'),
                $this->equalTo('https://api.binance.com/api/v3/trades'),
                $this->callback(function ($options) {
                    return $options['query']['symbol'] == 'BTCUSDT' && $options['query']['limit'] == 5;
                }),
            )
            ->willReturn(new Response(body: RecentTradesList::exampleResponse()));

        $this->binance->tradesBTCUSDT(5);
    }
}
