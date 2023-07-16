<?php

namespace BinanceApi;

use BinanceApi\Docs\Const\BinanceApi\Endpoint;
use BinanceApi\Docs\MarketDataEndpoint\CheckServerTime;
use BinanceApi\Docs\MarketDataEndpoint\CompressedAggregateTradesList;
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
use BinanceApi\Exception\MethodNotExistException;

/**
 * @method mixed ping(array $headers = [], array $query = [], array $body = []) Test Connectivity. https://binance-docs.github.io/apidocs/spot/en/#test-connectivity
 * @method mixed time(array $headers = [], array $query = [], array $body = [])  Check Server Time. https://binance-docs.github.io/apidocs/spot/en/#check-server-time
 * @method mixed exchangeInfo(array $headers = [], array $query = [], array $body = []) Exchange Information. https://binance-docs.github.io/apidocs/spot/en/#exchange-information
 * @method mixed depth(array $headers = [], array $query = [], array $body = [])  Order Book. https://binance-docs.github.io/apidocs/spot/en/#order-book
 * @method mixed trades(array $headers = [], array $query = [], array $body = [])  Recent Trades List. https://binance-docs.github.io/apidocs/spot/en/#recent-trades-list
 * @method mixed historicalTrades(array $headers = [], array $query = [], array $body = [])  Old Trade Lookup (MARKET_DATA). https://binance-docs.github.io/apidocs/spot/en/#old-trade-lookup-market_data
 * @method mixed aggTrades(array $headers = [], array $query = [], array $body = [])  Compressed/Aggregate Trades List. https://binance-docs.github.io/apidocs/spot/en/#compressed-aggregate-trades-list
 * @method mixed klines(array $headers = [], array $query = [], array $body = [])  Kline/Candlestick Data. https://binance-docs.github.io/apidocs/spot/en/#kline-candlestick-data
 * @method mixed avgPrice(array $headers = [], array $query = [], array $body = [])  UIKlines. https://binance-docs.github.io/apidocs/spot/en/#uiklines
 * @method mixed ticker24hr(array $headers = [], array $query = [], array $body = [])  Current Average Price. https://binance-docs.github.io/apidocs/spot/en/#current-average-price
 * @method mixed tickerPrice(array $headers = [], array $query = [], array $body = [])  24hr Ticker Price Change Statistics. https://binance-docs.github.io/apidocs/spot/en/#24hr-ticker-price-change-statistics
 * @method mixed tickerBookTicker(array $headers = [], array $query = [], array $body = [])  Symbol Price Ticker. https://binance-docs.github.io/apidocs/spot/en/#symbol-price-ticker
 * @method mixed ticker(array $headers = [], array $query = [], array $body = [])  Symbol Order Book Ticker. https://binance-docs.github.io/apidocs/spot/en/#symbol-order-book-ticker
 */
trait BinanceAliases
{
    /**
     * @var array|string[] method as a key, value as Endpoint class for binance endpoint
     */
    protected array $aliases = [
        TestConnectivity::METHOD => TestConnectivity::class,
        CheckServerTime::METHOD => CheckServerTime::class,
        ExchangeInformation::METHOD => ExchangeInformation::class,
        OrderBook::METHOD => OrderBook::class,
        RecentTradesList::METHOD => RecentTradesList::class,
        OldTradeLookup::METHOD => OldTradeLookup::class,
        CompressedAggregateTradesList::METHOD => CompressedAggregateTradesList::class,
        KlineCandlestickData::METHOD => KlineCandlestickData::class,
        UIKlines::METHOD => UIKlines::class,
        CurrentAveragePrice::METHOD => CurrentAveragePrice::class,
        TickerPriceChangeStatistics24hr::METHOD => TickerPriceChangeStatistics24hr::class,
        SymbolPriceTicker::METHOD => SymbolPriceTicker::class,
        SymbolOrderBookTicker::METHOD => SymbolOrderBookTicker::class,
        RollingWindowPriceChangeStatistics::METHOD => RollingWindowPriceChangeStatistics::class,
    ];

    /**
     * @var array Coded created fix Endpoint classes
     */
    protected array $resolvedAliases = [];

    /**
     * Method to resolve alias
     *
     * @param  string  $name  name of method from $this->aliases
     * @return Endpoint object of readonly Endpoint class
     * @throws MethodNotExistException
     */
    public function resolveAlias(string $name): Endpoint
    {
        if (isset($this->resolvedAliases[$name])) {
            return $this->resolvedAliases[$name];
        }

        if (! isset($this->aliases[$name])) {
            throw new MethodNotExistException('There is no such method or endpoint: '.$name);
        }

        return $this->resolvedAliases[$name] ??= new $this->aliases[$name]();
    }

    /**
     * Method add new alias for endpoint and resolve it
     *
     * @param  string  $name
     * @param  string  $endpointClass
     * @return void
     */
    public function addAlias(string $name, string $endpointClass): void
    {
        $this->aliases[$name] = $endpointClass;

        $this->resolveAlias($name);
    }
}
