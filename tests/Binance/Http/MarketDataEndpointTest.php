<?php

namespace BinanceApi\Tests\Binance\Http;

use BinanceApi\Binance;
use BinanceApi\Docs\Const\BinanceApi\ProcessResponse;
use BinanceApi\Docs\Const\Exception\EndpointQueryException;
use BinanceApi\Docs\MarketDataEndpoint\CheckServerTime;
use BinanceApi\Docs\MarketDataEndpoint\CurrentAveragePrice;
use BinanceApi\Docs\MarketDataEndpoint\ExchangeInformation;
use BinanceApi\Docs\MarketDataEndpoint\KlineCandlestickData;
use BinanceApi\Docs\MarketDataEndpoint\OldTradeLookup;
use BinanceApi\Docs\MarketDataEndpoint\OrderBook;
use BinanceApi\Docs\MarketDataEndpoint\RecentTradesList;
use BinanceApi\Docs\MarketDataEndpoint\RollingWindowPriceChangeStatistics;
use BinanceApi\Docs\MarketDataEndpoint\SymbolOrderBookTicker;
use BinanceApi\Docs\MarketDataEndpoint\SymbolPriceTicker;
use BinanceApi\Docs\MarketDataEndpoint\TestConnectivity;
use BinanceApi\Docs\MarketDataEndpoint\TickerPriceChangeStatistics24hr;
use BinanceApi\Docs\MarketDataEndpoint\UIKlines;
use BinanceApi\Exception\BinanceException;
use BinanceApi\Helper\Carbon;
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

    public function test_http_test_connectivity()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->will($this->returnValueMap([[
                'GET',
                'https://api.binance.com/api/v3/ping',
                [],
                new Response(body: TestConnectivity::exampleResponse())
            ]]));

        $this->assertEquals(
            json_decode(TestConnectivity::exampleResponse(), true),
            $this->binance->ping()['response']['data']
        );
    }

    public function test_http_check_server_time()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->will($this->returnValueMap([[
                'GET',
                'https://api.binance.com/api/v3/time',
                [],
                new Response(body: CheckServerTime::exampleResponse())
            ]]));

        $result = json_decode(CheckServerTime::exampleResponse(), true);
        $result['customAdditional'] = ['serverTimeDate' => 'Wed, 12 Jul 2017 02:42:00 UTC'];

        $this->assertEquals($result, $this->binance->time()['response']['data']);
    }

    public function test_http_exchange_information()
    {
        $this->client
            ->expects($this->exactly(5))
            ->method('request')
            ->will($this->returnValueMap([
                [
                    'GET',
                    'https://api.binance.com/api/v3/exchangeInfo',
                    [],
                    new Response(body: ExchangeInformation::exampleResponse())
                ],
                [
                    'GET',
                    'https://api.binance.com/api/v3/exchangeInfo',
                    ['query' => ['symbol' => 'BTCUSDT']],
                    new Response(body: ExchangeInformation::exampleResponse())
                ],
                [
                    'GET',
                    'https://api.binance.com/api/v3/exchangeInfo',
                    ['query' => ['symbols' => '["BTCUSDT","ETHUSDT"]']],
                    new Response(body: ExchangeInformation::exampleResponse())
                ],
                [
                    'GET',
                    'https://api.binance.com/api/v3/exchangeInfo',
                    ['query' => ['permissions' => 'SPOT']],
                    new Response(body: ExchangeInformation::exampleResponse())
                ],
                [
                    'GET',
                    'https://api.binance.com/api/v3/exchangeInfo',
                    ['query' => ['permissions' => '["MARGIN","LEVERAGED"]']],
                    new Response(body: ExchangeInformation::exampleResponse())
                ],
            ]));

        $result = json_decode(ExchangeInformation::exampleResponse(), true);
        $result['customAdditional'] = ['serverTimeDate' => 'Thu, 08 Aug 2019 06:39:24 UTC'];

        $this->assertEquals($result, $this->binance->exchangeInfo()['response']['data']);
        $this->assertEquals($result, $this->binance->exchangeInfo(symbol: 'BTCUSDT')['response']['data']);
        $this->assertEquals($result, $this->binance->exchangeInfo(symbols: ['BTCUSDT', 'ETHUSDT'])['response']['data']);
        $this->assertEquals($result, $this->binance->exchangeInfo(permissions: 'SPOT')['response']['data']);
        $this->assertEquals($result, $this->binance->exchangeInfo(permissions: ['MARGIN', 'LEVERAGED'])['response']['data']);
    }

    public function test_http_order_book()
    {
        $this->client
            ->expects($this->exactly(3))
            ->method('request')
            ->will($this->returnValueMap([
                [
                    'GET',
                    'https://api.binance.com/api/v3/depth',
                    ['query' => ['symbol' => 'BTCUSDT', 'limit' => 100]],
                    new Response(body: OrderBook::exampleResponse())
                ],
                [
                    'GET',
                    'https://api.binance.com/api/v3/depth',
                    ['query' => ['symbol' => 'BTCUSDT', 'limit' => 1]],
                    new Response(body: OrderBook::exampleResponse())
                ],
                [
                    'GET',
                    'https://api.binance.com/api/v3/depth',
                    ['query' => ['symbol' => 'BTCUSDT', 'limit' => 5000]],
                    new Response(body: OrderBook::exampleResponse())
                ],
            ]));

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

        $this->assertEquals($result, $this->binance->depth(symbol: 'BTCUSDT')['response']['data']);
        $this->assertEquals($result, $this->binance->depth(symbol: 'BTCUSDT', limit: -10)['response']['data']);
        $this->assertEquals($result, $this->binance->depth(symbol: 'BTCUSDT', limit: 10000)['response']['data']);

        $this->expectException(EndpointQueryException::class);
        $this->binance->depth();
    }

    public function test_http_recent_trade_list()
    {
        $this->client
            ->expects($this->exactly(3))
            ->method('request')
            ->will($this->returnValueMap([
                [
                    'GET',
                    'https://api.binance.com/api/v3/trades',
                    ['query' => ['symbol' => 'BTCUSDT', 'limit' => 500]],
                    new Response(body: RecentTradesList::exampleResponse())
                ],
                [
                    'GET',
                    'https://api.binance.com/api/v3/trades',
                    ['query' => ['symbol' => 'BTCUSDT', 'limit' => 1]],
                    new Response(body: RecentTradesList::exampleResponse())
                ],
                [
                    'GET',
                    'https://api.binance.com/api/v3/trades',
                    ['query' => ['symbol' => 'BTCUSDT', 'limit' => 1000]],
                    new Response(body: RecentTradesList::exampleResponse())
                ],
            ]));

        $result = array_map(function ($item) {
            $item['customAdditional']['timeDate'] = 'Wed, 12 Jul 2017 13:19:10 UTC';

            return $item;
        }, json_decode(RecentTradesList::exampleResponse(), true));

        $this->assertEquals($result, $this->binance->trades(symbol: 'BTCUSDT')['response']['data']);
        $this->assertEquals($result, $this->binance->trades(symbol: 'BTCUSDT', limit: -10)['response']['data']);
        $this->assertEquals($result, $this->binance->trades(symbol: 'BTCUSDT', limit: 10000)['response']['data']);

        $this->expectException(EndpointQueryException::class);
        $this->binance->trades();
    }

    public function test_http_old_trade_lookup_without_keys()
    {
        $this->expectException(BinanceException::class);
        $this->binance->historicalTrades();
    }

    public function test_http_old_trade_lookup()
    {
        $this->client
            ->expects($this->exactly(4))
            ->method('request')
            ->will($this->returnValueMap([
                [
                    'GET',
                    'https://api.binance.com/api/v3/historicalTrades',
                    ['headers' => ['X-MBX-APIKEY' => 'apiKey'], 'query' => ['symbol' => 'BTCUSDT', 'limit' => 500]],
                    new Response(body: OldTradeLookup::exampleResponse())
                ],
                [
                    'GET',
                    'https://api.binance.com/api/v3/historicalTrades',
                    ['headers' => ['X-MBX-APIKEY' => 'apiKey'], 'query' => ['symbol' => 'BTCUSDT', 'limit' => 1]],
                    new Response(body: OldTradeLookup::exampleResponse())
                ],
                [
                    'GET',
                    'https://api.binance.com/api/v3/historicalTrades',
                    ['headers' => ['X-MBX-APIKEY' => 'apiKey'], 'query' => ['symbol' => 'BTCUSDT', 'limit' => 1000]],
                    new Response(body: OldTradeLookup::exampleResponse())
                ],
                [
                    'GET',
                    'https://api.binance.com/api/v3/historicalTrades',
                    ['headers' => ['X-MBX-APIKEY' => 'apiKey'], 'query' => ['symbol' => 'BTCUSDT', 'limit' => 10, 'fromId' => '19960']],
                    new Response(body: OldTradeLookup::exampleResponse())
                ],
            ]));

        $this->binance->setApiKeys('apiKey');

        $result = array_map(function ($item) {
            $item['customAdditional']['timeDate'] = 'Wed, 12 Jul 2017 13:19:10 UTC';

            return $item;
        }, json_decode(OldTradeLookup::exampleResponse(), true));

        $this->assertEquals($result, $this->binance->historicalTrades(symbol: 'BTCUSDT')['response']['data']);
        $this->assertEquals($result, $this->binance->historicalTrades(symbol: 'BTCUSDT', limit: -10)['response']['data']);
        $this->assertEquals($result, $this->binance->historicalTrades(symbol: 'BTCUSDT', limit: 10000)['response']['data']);
        $this->assertEquals($result, $this->binance->historicalTrades(symbol: 'BTCUSDT', limit: 10, fromId: 19960)['response']['data']);

        $this->expectException(EndpointQueryException::class);
        $this->binance->historicalTrades();
    }

    public function test_http_klines_data()
    {
        $this->client
            ->expects($this->exactly(4))
            ->method('request')
            ->will($this->returnValueMap([
                [
                    'GET',
                    'https://api.binance.com/api/v3/klines',
                    ['query' => ['symbol' => 'BTCUSDT', 'interval' => '1m', 'limit' => 500]],
                    new Response(body: KlineCandlestickData::exampleResponse())
                ],
                [
                    'GET',
                    'https://api.binance.com/api/v3/klines',
                    ['query' => ['symbol' => 'BTCUSDT', 'interval' => '1m', 'limit' => 1]],
                    new Response(body: KlineCandlestickData::exampleResponse())
                ],
                [
                    'GET',
                    'https://api.binance.com/api/v3/klines',
                    ['query' => ['symbol' => 'BTCUSDT', 'interval' => '1m', 'limit' => 1000]],
                    new Response(body: KlineCandlestickData::exampleResponse())
                ],
                [
                    'GET',
                    'https://api.binance.com/api/v3/klines',
                    ['query' => ['symbol' => 'BTCUSDT', 'interval' => '1m', 'limit' => 200, 'startTime' => '1689272940000', 'endTime' => '1689273059999']],
                    new Response(body: KlineCandlestickData::exampleResponse())
                ],
            ]));

        $result = array_map(/**
         * @throws \Exception
         */ function ($item) {
            return [
                'klineOpenTime' => $item[0],
                'openPrice' => $item[1],
                'highPrice' => $item[2],
                'lowPrice' => $item[3],
                'closePrice' => $item[4],
                'volume' => $item[5],
                'klineCloseTime' => $item[6],
                'quoteAssetVolume' => $item[7],
                'numberOfTrades' => $item[8],
                'takerBuyBaseAssetVolume' => $item[9],
                'takerBuyQuoteAssetVolume' => $item[10],
                'unusedField' => $item[11],
                'customAdditional' => [
                    'klineOpenTimeDate' => Carbon::getFullDate($item[0]),
                    'klineCloseTimeDate' => Carbon::getFullDate($item[6]),
                ],
            ];
        }, json_decode(KlineCandlestickData::exampleResponse(), true));

        $this->assertEquals($result, $this->binance->klines(symbol: 'BTCUSDT', interval: '1m')['response']['data']);
        $this->assertEquals($result, $this->binance->klines(symbol: 'BTCUSDT', interval: '1m', limit: -10)['response']['data']);
        $this->assertEquals($result, $this->binance->klines(symbol: 'BTCUSDT', interval: '1m', limit: 10000)['response']['data']);
        $this->assertEquals($result, $this->binance->klines(symbol: 'BTCUSDT', interval: '1m', startTime: '1689272940000', endTime: '1689273059999', limit: 200)['response']['data']);
    }

    public function test_http_klines_data_mandatory_symbol()
    {

        $this->expectException(EndpointQueryException::class);
        $this->binance->klines(interval: '1m', startTime: '1689272940000', endTime: '1689273059999');
    }

    public function test_http_klines_data_mandatory_interval()
    {
        $this->expectException(EndpointQueryException::class);
        $this->binance->klines(symbol: 'BTCUSDT');
    }

    public function test_http_uiklines_data()
    {
        $this->client
            ->expects($this->exactly(4))
            ->method('request')
            ->will($this->returnValueMap([
                [
                    'GET',
                    'https://api.binance.com/api/v3/uiKlines',
                    ['query' => ['symbol' => 'BTCUSDT', 'interval' => '1m', 'limit' => 500]],
                    new Response(body: UIKlines::exampleResponse())
                ],
                [
                    'GET',
                    'https://api.binance.com/api/v3/uiKlines',
                    ['query' => ['symbol' => 'BTCUSDT', 'interval' => '1m', 'limit' => 1]],
                    new Response(body: UIKlines::exampleResponse())
                ],
                [
                    'GET',
                    'https://api.binance.com/api/v3/uiKlines',
                    ['query' => ['symbol' => 'BTCUSDT', 'interval' => '1m', 'limit' => 1000]],
                    new Response(body: UIKlines::exampleResponse())
                ],
                [
                    'GET',
                    'https://api.binance.com/api/v3/uiKlines',
                    ['query' => ['symbol' => 'BTCUSDT', 'interval' => '1m', 'limit' => 200, 'startTime' => '1689272940000', 'endTime' => '1689273059999']],
                    new Response(body: UIKlines::exampleResponse())
                ],
            ]));

        $result = array_map(/**
         * @throws \Exception
         */ function ($item) {
            return [
                'klineOpenTime' => $item[0],
                'openPrice' => $item[1],
                'highPrice' => $item[2],
                'lowPrice' => $item[3],
                'closePrice' => $item[4],
                'volume' => $item[5],
                'klineCloseTime' => $item[6],
                'quoteAssetVolume' => $item[7],
                'numberOfTrades' => $item[8],
                'takerBuyBaseAssetVolume' => $item[9],
                'takerBuyQuoteAssetVolume' => $item[10],
                'unusedField' => $item[11],
                'customAdditional' => [
                    'klineOpenTimeDate' => Carbon::getFullDate($item[0]),
                    'klineCloseTimeDate' => Carbon::getFullDate($item[6]),
                ],
            ];
        }, json_decode(KlineCandlestickData::exampleResponse(), true));

        $this->assertEquals($result, $this->binance->uiKlines(symbol: 'BTCUSDT', interval: '1m')['response']['data']);
        $this->assertEquals($result, $this->binance->uiKlines(symbol: 'BTCUSDT', interval: '1m', limit: -10)['response']['data']);
        $this->assertEquals($result, $this->binance->uiKlines(symbol: 'BTCUSDT', interval: '1m', limit: 10000)['response']['data']);
        $this->assertEquals($result, $this->binance->uiKlines(symbol: 'BTCUSDT', interval: '1m', startTime: '1689272940000', endTime: '1689273059999', limit: 200)['response']['data']);
    }

    public function test_http_uiklines_data_mandatory_symbol()
    {

        $this->expectException(EndpointQueryException::class);
        $this->binance->uiKlines(interval: '1m', startTime: '1689272940000', endTime: '1689273059999');
    }

    public function test_http_uiklines_data_mandatory_interval()
    {
        $this->expectException(EndpointQueryException::class);
        $this->binance->uiKlines(symbol: 'BTCUSDT');
    }

    public function test_http_current_average_price()
    {
        $this->client
            ->expects($this->exactly(1))
            ->method('request')
            ->will($this->returnValueMap([
                [
                    'GET',
                    'https://api.binance.com/api/v3/avgPrice',
                    ['query' => ['symbol' => 'BTCUSDT']],
                    new Response(body: CurrentAveragePrice::exampleResponse())
                ],
            ]));

        $this->assertEquals(
            json_decode(CurrentAveragePrice::exampleResponse(), true),
            $this->binance->avgPrice(symbol: 'BTCUSDT')['response']['data']
        );

        $this->expectException(EndpointQueryException::class);
        $this->binance->avgPrice();
    }

    public function test_http_24_hr_ticker_price_change_statistic()
    {
        $this->client
            ->expects($this->exactly(3))
            ->method('request')
            ->will($this->returnValueMap([
                [
                    'GET',
                    'https://api.binance.com/api/v3/ticker/24hr',
                    ['query' => ['type' => 'FULL', 'symbol' => 'BTCUSDT']],
                    new Response(body: TickerPriceChangeStatistics24hr::exampleResponse())
                ],
                [
                    'GET',
                    'https://api.binance.com/api/v3/ticker/24hr',
                    ['query' => ['type' => 'FULL', 'symbols' => '["BTCUSDT","ETHUSDT"]']],
                    new Response(body: TickerPriceChangeStatistics24hr::exampleResponse())
                ],
                [
                    'GET',
                    'https://api.binance.com/api/v3/ticker/24hr',
                    ['query' => ['type' => 'MINI', 'symbol' => 'BTCUSDT']],
                    new Response(body: TickerPriceChangeStatistics24hr::exampleResponse())
                ],
            ]));

        $result = json_decode(TickerPriceChangeStatistics24hr::exampleResponse(), true);
        $result['customAdditional'] = [
            'openTimeDate' => 'Tue, 11 Jul 2017 14:31:39 UTC',
            'closeTimeDate' => 'Wed, 12 Jul 2017 14:31:39 UTC',
        ];

        $this->assertEquals($result, $this->binance->ticker24hr(symbol: 'BTCUSDT')['response']['data']);
        $this->assertEquals($result, $this->binance->ticker24hr(symbols: ['BTCUSDT', 'ETHUSDT'])['response']['data']);
        $this->assertEquals($result, $this->binance->ticker24hr(symbol: 'BTCUSDT', type: 'MINI')['response']['data']);
    }

    public function test_http_symbol_price_ticker()
    {
        $this->client
            ->expects($this->exactly(2))
            ->method('request')
            ->will($this->returnValueMap([
                [
                    'GET',
                    'https://api.binance.com/api/v3/ticker/price',
                    ['query' => ['symbol' => 'BTCUSDT']],
                    new Response(body: SymbolPriceTicker::exampleResponse()['firstVersion'])
                ],
                [
                    'GET',
                    'https://api.binance.com/api/v3/ticker/price',
                    ['query' => ['symbols' => '["BTCUSDT","ETHUSDT"]']],
                    new Response(body: SymbolPriceTicker::exampleResponse()['firstVersion'])
                ],
            ]));

        $result = json_decode(SymbolPriceTicker::exampleResponse()['firstVersion'], true);

        $this->assertEquals($result, $this->binance->tickerPrice(symbol: 'BTCUSDT')['response']['data']);
        $this->assertEquals($result, $this->binance->tickerPrice(symbols: ['BTCUSDT', 'ETHUSDT'])['response']['data']);
    }

    public function test_http_symbol_order_book_ticker()
    {
        $this->client
            ->expects($this->exactly(2))
            ->method('request')
            ->will($this->returnValueMap([
                [
                    'GET',
                    'https://api.binance.com/api/v3/ticker/bookTicker',
                    ['query' => ['symbol' => 'BTCUSDT']],
                    new Response(body: SymbolOrderBookTicker::exampleResponse()['firstVersion'])
                ],
                [
                    'GET',
                    'https://api.binance.com/api/v3/ticker/bookTicker',
                    ['query' => ['symbols' => '["BTCUSDT","ETHUSDT"]']],
                    new Response(body: SymbolOrderBookTicker::exampleResponse()['firstVersion'])
                ],
            ]));

        $result = json_decode(SymbolOrderBookTicker::exampleResponse()['firstVersion'], true);

        $this->assertEquals($result, $this->binance->tickerBookTicker(symbol: 'BTCUSDT')['response']['data']);
        $this->assertEquals($result, $this->binance->tickerBookTicker(symbols: ['BTCUSDT', 'ETHUSDT'])['response']['data']);
    }

    public function test_http_rolling_window_price_change_statistic()
    {
        $this->client
            ->expects($this->exactly(2))
            ->method('request')
            ->will($this->returnValueMap([
                [
                    'GET',
                    'https://api.binance.com/api/v3/ticker',
                    ['query' => ['windowSize' => '1d', 'type' => 'FULL', 'symbol' => 'BTCUSDT']],
                    new Response(body: RollingWindowPriceChangeStatistics::exampleResponse()['secondVersion'])
                ],
                [
                    'GET',
                    'https://api.binance.com/api/v3/ticker',
                    ['query' => ['windowSize' => '1h', 'type' => 'MINI', 'symbols' => '["BTCUSDT","ETHUSDT"]']],
                    new Response(body: RollingWindowPriceChangeStatistics::exampleResponse()['secondVersion'])
                ],
            ]));

        $result = array_map(/**
         * @throws \Exception
         */ function ($item) {
            $item[ProcessResponse::ADDITIONAL_FIELD] = [
                'openTimeDate' => Carbon::getFullDate($item['openTime']),
                'closeTimeDate' => Carbon::getFullDate($item['closeTime']),
            ];

            return $item;
        }, json_decode(RollingWindowPriceChangeStatistics::exampleResponse()['secondVersion'], true));

        $this->assertEquals($result, $this->binance->ticker(symbol: 'BTCUSDT')['response']['data']);
        $this->assertEquals($result, $this->binance->ticker(symbols: ['BTCUSDT', 'ETHUSDT'], windowSize: '1h', type: 'MINI')['response']['data']);
    }

    public function test_http_rolling_window_price_change_statistic_mandatory_parameters()
    {
        $this->expectException(EndpointQueryException::class);
        $this->binance->ticker();
    }
}
