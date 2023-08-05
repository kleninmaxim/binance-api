<?php

namespace BinanceApi\Tests;

use BinanceApi\App\ResponseHandler\GuzzlePsr7ResponseHandler;
use BinanceApi\Exception\MethodNotExistException;
use BinanceApi\Spot\BinanceSpotOriginal;
use BinanceApi\Spot\Docs\Const\BinanceApi\Endpoint;
use BinanceApi\Spot\Docs\MarketDataEndpoint\CheckServerTime;
use BinanceApi\Spot\Docs\MarketDataEndpoint\CompressedAggregateTradesList;
use BinanceApi\Spot\Docs\MarketDataEndpoint\CurrentAveragePrice;
use BinanceApi\Spot\Docs\MarketDataEndpoint\ExchangeInformation;
use BinanceApi\Spot\Docs\MarketDataEndpoint\KlineCandlestickData;
use BinanceApi\Spot\Docs\MarketDataEndpoint\OldTradeLookup;
use BinanceApi\Spot\Docs\MarketDataEndpoint\OrderBook;
use BinanceApi\Spot\Docs\MarketDataEndpoint\RecentTradesList;
use BinanceApi\Spot\Docs\MarketDataEndpoint\SymbolOrderBookTicker;
use BinanceApi\Spot\Docs\MarketDataEndpoint\SymbolPriceTicker;
use BinanceApi\Spot\Docs\MarketDataEndpoint\TestConnectivity;
use BinanceApi\Spot\Docs\MarketDataEndpoint\TickerPriceChangeStatistics24hr;
use BinanceApi\Spot\Docs\MarketDataEndpoint\UIKlines;
use BinanceApi\Spot\Docs\WalletEndpoints\SwitchOnOffBusdAndStableCoinsConversion;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class BinanceOriginalTest extends TestCase
{
    public function test_check_class_is_resolved()
    {
        $binance = new BinanceSpotOriginal();

        $resolvedAlias = $binance->resolveAlias('ping');

        $this->assertInstanceOf(TestConnectivity::class, $resolvedAlias);
    }

    public function test_check_class_is_throw_exception_when_resolved_with_non_existing_alias()
    {
        $binance = new BinanceSpotOriginal();

        $this->expectException(MethodNotExistException::class);

        $binance->resolveAlias('nonExistingResolvedAlias');
    }

    /**
     * @throws Exception|MethodNotExistException
     */
    public function test_add_new_alias_for_class()
    {
        $binance = new BinanceSpotOriginal();

        $nonExistingResolvedAlias = $this->createMock(Endpoint::class);

        $binance->addAlias('nonExistingResolvedAlias', $nonExistingResolvedAlias::class);

        $this->assertInstanceOf($nonExistingResolvedAlias::class, $binance->resolveAlias('nonExistingResolvedAlias'));
    }

    public function test_expect_error_for_non_existing_method()
    {
        $binance = new BinanceSpotOriginal();

        $this->expectException(MethodNotExistException::class);

        $binance->nonExistingMethod();
    }

    /**
     * @throws Exception
     */
    public function test_binance_return_with_null()
    {
        $client = $this->createMock(Client::class);

        $client->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('POST'),
                $this->equalTo('https://api.binance.com/sapi/v1/capital/contract/convertible-coins'),
                $this->callback(function ($options) {
                    return $options['headers']['X-MBX-APIKEY'] == 'apiKey' &&
                        $options['form_params']['coin'] == 'USDT' &&
                        $options['form_params']['enable'] == false &&
                        $options['form_params']['timestamp'] == 1499865549590 &&
                        $options['form_params']['signature'] == 'some-random-signature';
                }),
            )
            ->willReturn(new Response(body: SwitchOnOffBusdAndStableCoinsConversion::exampleResponse()));

        $binance = new BinanceSpotOriginal(client: $client);

        $this->assertEquals(
            SwitchOnOffBusdAndStableCoinsConversion::exampleResponse(),
            $binance->switchCapitalContractConvertibleCoins(
                ['X-MBX-APIKEY' => 'apiKey'],
                body: ['coin' => 'USDT', 'enable' => false, 'timestamp' => 1499865549590, 'signature' => 'some-random-signature']
            )
        );
    }

    public function test_it_make_http_request()
    {
        $container = [];
        $handlerStack = HandlerStack::create(new MockHandler([
            new Response(body: json_encode([])),
        ]));
        $handlerStack->push(Middleware::history($container));

        $binance = new BinanceSpotOriginal(client: new Client(['handler' => $handlerStack]));

        $result = $binance->ping();

        $this->assertEmpty($result);
        $this->assertIsArray($result);

        foreach ($container as $transaction) {
            $request = $transaction['request'];

            $this->assertEquals('api.binance.com', $request->getUri()->getHost());
            $this->assertEquals('/api/v3/ping', $request->getUri()->getPath());
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEmpty($request->getUri()->getQuery());
            $this->assertEmpty($request->getBody()->getContents());
        }
    }

    public function test_it_return_result_in_guzzle_response()
    {
        $container = [];
        $handlerStack = HandlerStack::create(new MockHandler([
            new Response(body: json_encode([])),
        ]));
        $handlerStack->push(Middleware::history($container));

        $binance = new BinanceSpotOriginal(new GuzzlePsr7ResponseHandler(), client: new Client(['handler' => $handlerStack]));

        $this->assertInstanceOf(ResponseInterface::class, $binance->ping());
    }

    public function test_binance_class_has_necessary_methods()
    {
        $methods = [
            'ping' => json_decode(TestConnectivity::exampleResponse(), true),
            'time' => json_decode(CheckServerTime::exampleResponse(), true),
            'exchangeInfo' => json_decode(ExchangeInformation::exampleResponse(), true),
            'depth' => json_decode(OrderBook::exampleResponse(), true),
            'trades' => json_decode(RecentTradesList::exampleResponse(), true),
            'historicalTrades' => json_decode(OldTradeLookup::exampleResponse(), true),
            'aggTrades' => json_decode(CompressedAggregateTradesList::exampleResponse(), true),
            'klines' => json_decode(KlineCandlestickData::exampleResponse(), true),
            'avgPrice' => json_decode(UIKlines::exampleResponse(), true),
            'ticker24hr' => json_decode(CurrentAveragePrice::exampleResponse(), true),
            'tickerPrice' => json_decode(TickerPriceChangeStatistics24hr::exampleResponse(), true),
            'tickerBookTicker' => json_decode(SymbolPriceTicker::exampleResponse()['secondVersion'], true),
            'ticker' => json_decode(SymbolOrderBookTicker::exampleResponse()['secondVersion'], true),
        ];

        $handlerStack = HandlerStack::create(new MockHandler([
            new Response(body: TestConnectivity::exampleResponse()),
            new Response(body: CheckServerTime::exampleResponse()),
            new Response(body: ExchangeInformation::exampleResponse()),
            new Response(body: OrderBook::exampleResponse()),
            new Response(body: RecentTradesList::exampleResponse()),
            new Response(body: OldTradeLookup::exampleResponse()),
            new Response(body: CompressedAggregateTradesList::exampleResponse()),
            new Response(body: KlineCandlestickData::exampleResponse()),
            new Response(body: UIKlines::exampleResponse()),
            new Response(body: CurrentAveragePrice::exampleResponse()),
            new Response(body: TickerPriceChangeStatistics24hr::exampleResponse()),
            new Response(body: SymbolPriceTicker::exampleResponse()['secondVersion']),
            new Response(body: SymbolOrderBookTicker::exampleResponse()['secondVersion']),
        ]));

        $binance = new BinanceSpotOriginal(client: new Client(['handler' => $handlerStack]));

        foreach ($methods as $method => $response) {
            $this->assertEquals($response, $binance->{$method}());
        }
    }
}
