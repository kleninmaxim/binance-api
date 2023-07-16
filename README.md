# Binance PHP API Client
The purpose of this project is to assist you in creating your own projects that interact with the [Binance API](https://binance-docs.github.io/apidocs/spot/en/).

## Introduction
This project requires [php](https://www.php.net/) version more or equal 8.2. Also it requires [bcmath](https://www.php.net/manual/en/book.bc.php) extension and [guzzle](https://docs.guzzlephp.org/en/stable/) dependency

## Installation

## Quick start
Every method's name in `\BinanceApi\Binance::class` created by name from url after prefix `v3`. For example, by table:
<table>
   <tr><td> Name of endpoint </td> <td> Method name </td></tr>
   
   <tr><td>

   [Order Book](https://binance-docs.github.io/apidocs/spot/en/#order-book): /api/v3/**depth**
   
   </td><td>
   
   ```php
   $binance->depth($symbol, $limit);
   ```
   </td></tr>
   
   <tr><td>

   [Symbol Order Book Ticker](https://binance-docs.github.io/apidocs/spot/en/#symbol-order-book-ticker): /api/v3/**ticker/bookTicker**

   </td><td>

   ```php
   $binance->tickerBookTicker('BTCUSDT');
   ``` 
   </td></tr>

   <tr><td>

   [24hr Ticker Price Change Statistics](https://binance-docs.github.io/apidocs/spot/en/#24hr-ticker-price-change-statistics): /api/v3/**ticker/24hr**

   </td><td>

   ```php
   $binance->ticker24hr($symbol, $symbols, $type);
   ```
   </td></tr>
</table>

All endpoints and their methods with parameters you can see in phpdoc in `\BinanceApi\Binance::class`

You can start to execute requests in two ways:

Custom handled Binance class

 ```php
 $binance = new \BinanceApi\Binance();

 $fullResult = $binance->depth('BTCUSDT', 2);

 $orderbook = $fullResult['response']['data'];
 ```
<details>
 <summary>View $fullResult variable</summary>

```
Array
(
   [request] => Array
      (
         [url] => /api/v3/depth
         [headers] => Array
            (
            )
         [query] => Array
            (
               [symbol] => BTCUSDT
               [limit] => 2
            )
         [body] => Array
            (
            )
      )
   
   [response] => Array
      (
         [data] => Array
            (
               [lastUpdateId] => 37910427874
               [bids] => Array
                  (
                     [0] => Array
                        (
                           [price] => 30319.99000000
                           [amount] => 3.58155000
                        )
                  
                     [1] => Array
                        (
                           [price] => 30319.98000000
                           [amount] => 0.09091000
                        )
                  )
               [asks] => Array
                  (
                     [0] => Array
                        (
                           [price] => 30320.00000000
                           [amount] => 21.24342000
                        )
                     
                     [1] => Array
                        (
                           [price] => 30320.05000000
                           [amount] => 0.00170000
                        )
                  )
            )
         
         [info] => Array
            (
               [statusCode] => 200
               [reasonPhrase] => OK
               [headers] => Array
                  (
                     [Content-Type] => Array
                        (
                           [0] => application/json;charset=UTF-8
                        )
                     
                     ...
                     
                     [x-mbx-uuid] => Array
                        (
                           [0] => ad6df6c5-903b-451b-904c-5ba90eb4576d
                        )
                     
                     [x-mbx-used-weight] => Array
                        (
                           [0] => 1
                        )
                     
                     [x-mbx-used-weight-1m] => Array
                        (
                           [0] => 1
                        )
                     
                     ...
                  )
            )
      )
)
```
</details>

You can go to the `Example` topic to see more examples and use it
## Basic

This topic all about `\BinanceApi\Binance::class`

### Create a class with different endpoints (by default it: `https://api.binance.com`)
```php
$binanceOriginalEndpoint = new \BinanceApi\Binance();
$binance = new \BinanceApi\Binance('https://api3.binance.com');

// Or through constants
$binance = new \BinanceApi\Binance(\BinanceApi\Docs\GeneralInfo\GeneralApiInformation::GCP_ENDPOINT);
$binance = new \BinanceApi\Binance(\BinanceApi\Docs\GeneralInfo\GeneralApiInformation::API1_ENDPOINT);
$binance = new \BinanceApi\Binance(\BinanceApi\Docs\GeneralInfo\GeneralApiInformation::API2_ENDPOINT);
$binance = new \BinanceApi\Binance(\BinanceApi\Docs\GeneralInfo\GeneralApiInformation::API3_ENDPOINT);
$binance = new \BinanceApi\Binance(\BinanceApi\Docs\GeneralInfo\GeneralApiInformation::API4_ENDPOINT);
```
### Create a class to use [testnet](https://testnet.binance.vision/)
```php
$binanceTestNet = new \BinanceApi\Binance(TestNet::BASE_ENDPOINT);
```

### Set Guzzle Client
If you need to replace default Guzzle Client on yours, here an example:
```php
$client = new \GuzzleHttp\Client(['timeout' => 10]);
$binance = new \BinanceApi\Binance(client: $client);
```
See about Guzzle Client [here](https://docs.guzzlephp.org/en/stable/)

### Return result from each endpoint request

Every request method returns next result:

```php
print_r($binance->depth('BTCUSDT', 10));
```

```text
Array
(
   [request] => Array
      (
         [url] => /api/v3/depth
         [headers] => Array
            (
                ...
            )
         [query] => Array
            (
                ...
            )
         [body] => Array
            (
                ...
            )
      )
   
   [response] => Array
      (
         [data] => Array
            (
                 ...
            )
         
         [info] => Array
            (
               [statusCode] => 200
               [reasonPhrase] => OK
               [headers] => Array
                  (
                     ...
                  )
            )
      )
)
```

1) `request` - is an array with all request information to Binance
2) `response` - all about response, where `data` - processed result from Binance and `info` - response data (code, phrase and headers)

### Filter every ending result from `\BinanceApi\Binance::class`
After each request, you get the result as an array. This array contains a lot of information and may be you don't want to use it. 

First example:
```php
$binance->setOutputCallback(function ($output) {
    return $output['response']['data'];
});

print_r($binance->depth('BTCUSDT', 10));
```
```text
Array
(
   [lastUpdateId] => 37910427874
   [bids] => Array
      (
         ...
      )
   [asks] => Array
      (
         ...
      )
)
```

Second example:

```php
$binance->setOutputCallback(function ($output) {
    unset($output['response']['info']['headers']);
    unset($output['request']);

    return $output;
});
```

### Set Api Keys
Execute `setApiKeys` method:
```php
$binance->setApiKeys($apiKey, $secretKey);
```
You also can set only Api Key, without Secret Key (Some endpoints need only Api Key):
```php
$binance->setApiKeys($apiKey);
```

### Exceptions
```php
try {
    $result = $binance->depth('BTCUSDT', 2);
} catch (BinanceApi\Docs\Const\Exception\EndpointQueryException $e) {
    // Here exception with endpoint related,
    // For example, you don't set a symbol as a mandatory parameter into a method
} catch (BinanceApi\Exception\BinanceException $e) {
    // Exception with Binance related,
    // For example, don't set Api Keys to class
} catch (BinanceApi\Exception\BinanceResponseException $e) {
    // This is exception throw, when binance return error message
    // https://binance-docs.github.io/apidocs/spot/en/#error-codes
} catch (BinanceApi\Exception\MethodNotExistException $e) {
    // If method doesn't exist it will throw such exception
} catch (\GuzzleHttp\Exception\GuzzleException $e) {
    // It about Guzzle exception
    // https://docs.guzzlephp.org/en/stable/quickstart.html#exceptions
}
```

### Additional information

`\BinanceApi\Binance::class` has `getAdditional()` method.

After each request additional property updated by request and you can use it.

```php
$binance->getAdditional();
```

You can see, for example, how many limits you use in binance weights and last request that you made:
```php
print_r($binance->getAdditional()['limits'][BinanceApi\Docs\GeneralInfo\Const\BanBased::IP]['api']);
```
```text
Array
(
    [used] => 2 // By default maximum weight in minute is 1200
    [lastRequest] => Sat, 15 Jul 2023 14:19:01 GMT
)
```

### Carbon, Math and Http


## Digging deeper

### Disable throw `BinanceApi\Exception\BinanceException` and `BinanceApi\Exception\BinanceResponseException`
```php
$binance->disableBinanceExceptions();
```
After to execute this method, you will not get `BinanceApi\Exception\BinanceException` and `BinanceApi\Exception\BinanceResponseException`,
but you still can get `BinanceApi\Docs\Const\Exception\EndpointQueryException`, `BinanceApi\Exception\MethodNotExistException` and `\GuzzleHttp\Exception\GuzzleException`

If you also want to disable `BinanceApi\Docs\Const\Exception\EndpointQueryException`, you can rewrite Endpoint and add it to Binance class

### Endpoint

Endpoint is the main core of information on which the binance classes rely

Let's look at one random Endpoint class:
```php
<?php

namespace BinanceApi\Docs\MarketDataEndpoint;

use BinanceApi\Docs\Const\BinanceApi\Endpoint;
use BinanceApi\Docs\Const\BinanceApi\HasQueryParameters;
use BinanceApi\Docs\Const\BinanceApi\ProcessResponse;
use BinanceApi\Docs\Const\Exception\EndpointQueryException;
use BinanceApi\Docs\GeneralInfo\Const\BanBased;
use BinanceApi\Docs\GeneralInfo\Const\HttpMethod;
use BinanceApi\Docs\GeneralInfo\DataSources;
use BinanceApi\Docs\GeneralInfo\EndpointSecurityType;

/**
 * https://binance-docs.github.io/apidocs/spot/en/#order-book
 *
 * Order Book
 */
readonly class OrderBook implements Endpoint, HasQueryParameters, ProcessResponse
{
    public const METHOD = 'depth';

    public function __construct(
        public string $endpoint = '/api/v3/depth',
        public string $httpMethod = HttpMethod::GET,
        public null|int $weight = null,
        public string $weightBased = BanBased::IP,
        public string $dataSource = DataSources::MEMORY,
        public null|string $encryption = null,
        public string $endpointType = EndpointSecurityType::NONE,
        public string $title = 'Order Book',
        public string $description = '',
        public string $version = 'v3',
        public bool $isSapi = false,
    ) {
    }

    public function getQuery(null|string $symbol = null, int $limit = 100): array
    {
        ...

        return $query;
    }

    public function processResponse(array $response): array
    {
        ...

        return $response;
    }

    public static function exampleResponse(): string
    {
        return json_encode([
            ...
        ]);
    }
}
```

1) That class must implement by `BinanceApi\Docs\Const\BinanceApi\Endpoint::class`
2) That class is `readonly`
3) As class implements `BinanceApi\Docs\Const\BinanceApi\Endpoint::class` it must have `public static function exampleResponse(): string`, 
   this is just an example of result that binance give. It is only used for Unit Test and your own purpose and as a doc.
4) We must have all those properties which are set in `__construct`
5) We can optional set `public const METHOD = 'depth';` to add method for Binance classes and execute it
6) `BinanceApi\Docs\Const\BinanceApi\HasQueryParameters` are mandatory if endpoint must have query parameters.
   `public function getQuery(...): array` - write your function which will return array of query parameters
7) `BinanceApi\Docs\Const\BinanceApi\ProcessResponse` are optional if you want to rewrite original response from Binance
   `public function processResponse(array $response): array` - where `$response` is Binance response

You can extend that endpoint class and rewrite everything you want
```php
<?php

readonly class ExtendedKlineCandlestickData extends KlineCandlestickData
{
    public function processResponse(array $response): array
    {
        return array_map(function ($item) {
            return [
                'klineOpenTime' => Carbon::getFullDate($item[0]),
                'openPrice' => $item[1],
                'highPrice' => $item[2],
                'lowPrice' => $item[3],
                'closePrice' => $item[4],
            ];
        }, $response);
    }
}

// Replace default alias in 'klines'. See topic below about it
$binance->binanceOriginal->addAlias('klines', ExtendedKlineCandlestickData::class);

$binance->klines('BTCUSDT', '1d', limit: 5); // and will handle the content of response in that format
```

### Add Endpoint to execute it as a function

You can create your own Endpoint by previous topic or use already existing Endpoint

```php
$binance = new \BinanceApi\Binance();
$binance->binanceOriginal->addAlias('yourCustomFunction', YourCustomEndpoint::class);

$binance->yourCustomFunction();
$binance->yourCustomFunction(...$parameters); // If YourCustomEndpoint::class implements of BinanceApi\Docs\Const\BinanceApi\HasQueryParameters

$binance->binanceOriginal->addAlias('yourCustomFunctionToGetOrderbook', BinanceApi\Docs\MarketDataEndpoint\OrderBook::class);

// Now yourCustomFunctionToGetOrderbook() and depth() are identical and fully the same
$binance->yourCustomFunctionToGetOrderbook('BTCUSDT', 5);
$binance->depth('BTCUSDT', 5);
```

### Let's talk about `\BinanceApi\BinanceOriginal::class`
 ```php
 $binance = new \BinanceApi\BinanceOriginal();

 $orderbook = $binance->depth(query: ['symbol' => 'BTCUSDT', 'limit' => 5]);
 ```

<details>
 <summary>View $orderbook variable</summary>

```
Array
(
   [lastUpdateId] => 37910484364

   [bids] => Array
      (
         [0] => Array
            (
               [0] => 30331.38000000
               [1] => 14.74474000
            )
         [1] => Array
            (
               [0] => 30331.36000000
               [1] => 0.01941000
            )
      )

   [asks] => Array
      (
         [0] => Array
            (
               [0] => 30331.39000000
               [1] => 1.34772000
            )
         [1] => Array
            (
               [0] => 30331.41000000
               [1] => 0.00131000
            )
      )
)
```
</details>

#### Inside of class:

1) This class has only two core things: `__call(string $name, array $arguments)` and `\BinanceApi\BinanceAliases::class` trait
2) When we call any method, for example, `depth(...$parameters)` it resolve alias from property and execute http request.
In `\BinanceApi\BinanceAliases::class` trait we find the Endpoint class by the `$name`, for example `BinanceApi\Docs\MarketDataEndpoint\OrderBook::class`, anyway if not find alias, it will throw `BinanceApi\Exception\MethodNotExistException`.
3) Then execute http request

Each method in Binance has fixed parameters: `depth(array $headers = [], array $query = [], array $body = []): mixed`.
All this parameters for http request.

You can have access to `\BinanceApi\BinanceOriginal::class` through `\BinanceApi\Binance::class`
```php
$binance = new \BinanceApi\Binance();

$binance->binanceOriginal; // This is \BinanceApi\BinanceOriginal::class

// And you can execute all methods
$binance->binanceOriginal->depth(['x-headers' => 'some-value'], ['symbol' => 'BTCUSDT', 'limit' => 10]);
```

#### The difference between `\BinanceApi\Binance::class` and `\BinanceApi\BinanceOriginal::class`

**So, if you don't want to worry about the internal structure of classes and want to use ready-made methods use `\BinanceApi\Binance::class` and it will be nice.**

**Use `\BinanceApi\BinanceOriginal::class` if you want to make any custom request with adding your parameters to the header, query and body bypassing the `\BinanceApi\Binance::class`**

`\BinanceApi\Binance::class`
1) Return a full result and handle it
2) Every method has its own parameters to endpoint
3) Add to request necessary parameters, for example, api key to header and signature
4) Has additional property with some information
5) Handle the request from Binance (for example, in orderbook request you can see `price` and `amount`)
6) Throw Exception if a Binance return error message
7) And more another feature

`\BinanceApi\BinanceOriginal::class`

1) Return an original result from Binance as in documentation (for example [orderbook](https://binance-docs.github.io/apidocs/spot/en/#order-book)).
2) This class also will return an error result from Binance (for example, no mandatory parameter) as an original result from Binance.
3) Every method you can see in `\BinanceApi\BinanceAliases::class` and every method has three parameters: headers, query, body. So
   you have yourself create signature, add an api key to header at those methods.

## Examples and Analogs

All methods you can find in `\BinanceApi\Binance::class`
```php
/**
 *
 * Original Methods:
 *
 * @method array ping() Test Connectivity
 * @method array time() Check Server Time
 * @method array exchangeInfo(null|string $symbol = null, null|array $symbols = null, null|string|array $permissions = null) Exchange Information
 * @method array depth(null|string $symbol = null, int $limit = 100) Order Book.
 * @method array trades(null|string $symbol = null, int $limit = 500) Recent Trades List.
 * @method array historicalTrades(null|string $symbol = '', int $limit = 500, null|string $fromId = null) Old Trade Lookup (MARKET_DATA).
 * @method array aggTrades(null|string $symbol = null, null|string $fromId = null, null|string $startTime = null, null|string $endTime = null, int $limit = 500) Compressed/Aggregate Trades List.
 * @method array klines(null|string $symbol = null, null|string $interval = null, null|string $startTime = null, null|string $endTime = null, int $limit = 500) Kline/Candlestick Data.
 * @method array uiKlines(null|string $symbol = null, null|string $interval = null, null|string $startTime = null, null|string $endTime = null, int $limit = 500) UIKlines.
 * @method array avgPrice(null|string $symbol = null) Current Average Price.
 * @method array ticker24hr(null|string $symbol = null, null|array $symbols = null, string $type = 'FULL') 24hr Ticker Price Change Statistics.
 * @method array tickerPrice(null|string $symbol = null, null|array $symbols = null) Symbol Price Ticker.
 * @method array tickerBookTicker(null|string $symbol = null, null|array $symbols = null) Symbol Order Book Ticker.
 * @method array ticker(null|string $symbol = null, null|array $symbols = null, string $windowSize = '1d', string $type = 'FULL') Rolling window price change statistics.
 *
 * Analogs:
 *
 * @method array orderbook(string $symbol, int $limit = 100) depth() analog
 * @method array orderbookBTCUSDT(int $limit = 100) depth() analog
 */
class Binance {

}
```

### Common part for all next requests
```php
$binance = new \BinanceApi\Binance();

$binance->setOutputCallback(function ($output) {
    return $output['response']['data'];
});

$binance->setApiKeys('apiKey', 'apiSecret');
```

### [Test Connectivity](https://binance-docs.github.io/apidocs/spot/en/#test-connectivity)
```php
$binance->ping();
```

<details>
<summary>View result</summary>

```text
[]
```
</details>

### [Check Server Time](https://binance-docs.github.io/apidocs/spot/en/#check-server-time)
```php
$binance->time();
```

<details>
<summary>View result</summary>

```text
[
   'serverTime' => 1499827319559
   'customAdditional' => [
       'serverTimeDate' => 'Sat, 15 Jul 2023 17:02:47 UTC'
   ]
]
```
</details>

### [Exchange Information](https://binance-docs.github.io/apidocs/spot/en/#exchange-information)
```php
$binance->exchangeInfo('BTCUSDT');
```

<details>
<summary>View result</summary>

```text
[
   'timezone' => 'UTC',
   'serverTime' => 1565246363776,
   'rateLimits' => [
       [
           'rateLimitType' => 'REQUEST_WEIGHT',
           'interval' => 'MINUTE',
           'intervalNum' => 1,
           'limit' => 1200,
       ],
       [
           'rateLimitType' => 'ORDERS',
           'interval' => 'SECOND',
           'intervalNum' => 10,
           'limit' => 50,
       ],
       [
           'rateLimitType' => 'ORDERS',
           'interval' => 'DAY',
           'intervalNum' => 1,
           'limit' => 160000,
       ],
       [
           'rateLimitType' => 'RAW_REQUESTS',
           'interval' => 'MINUTE',
           'intervalNum' => 5,
           'limit' => 6100,
       ],
   ],
   'exchangeFilters' => [],
   'symbols' => [
       [
           'symbol' => 'ETHBTC',
           'status' => 'TRADING',
           'baseAsset' => 'ETH',
           'baseAssetPrecision' => 8,
           'quoteAsset' => 'BTC',
           'quotePrecision' => 8,
           'quoteAssetPrecision' => 8,
           'orderTypes' => [
               'LIMIT',
               'LIMIT_MAKER',
               'MARKET',
               'STOP_LOSS',
               'STOP_LOSS_LIMIT',
               'TAKE_PROFIT',
               'TAKE_PROFIT_LIMIT'
           ],
           'icebergAllowed' => true,
           'ocoAllowed' => true,
           'quoteOrderQtyMarketAllowed' => true,
           'allowTrailingStop' => false,
           'cancelReplaceAllowed' => false,
           'isSpotTradingAllowed' => true,
           'isMarginTradingAllowed' => true,
           'filters' => [
               [
                   'filterType' => 'PRICE_FILTER',
                   'minPrice' => 0.00000100,
                   'maxPrice' => 100.00000000,
                   'tickSize' => 0.00000100,
               ],
               [
                   'filterType' => 'LOT_SIZE',
                   'minPrice' => 0.00000100,
                   'maxPrice' => 9000.00000000,
                   'stepSize' => 0.00001000,
               ],
               [
                   'filterType' => 'ICEBERG_PARTS',
                   'limit' => 10,
               ],
               [
                   'filterType' => 'MARKET_LOT_SIZE',
                   'minPrice' => 0.00000000,
                   'maxPrice' => 1000.00000000,
                   'stepSize' => 0.00000000,
               ],
               [
                   'filterType' => 'TRAILING_DELTA',
                   'minTrailingAboveDelta' => 10,
                   'maxTrailingAboveDelta' => 2000,
                   'minTrailingBelowDelta' => 10,
                   'maxTrailingBelowDelta' => 2000,
               ],
               [
                   'filterType' => 'PERCENT_PRICE_BY_SIDE',
                   'bidMultiplierUp' => 5,
                   'bidMultiplierDown' => 0.2,
                   'askMultiplierUp' => 5,
                   'askMultiplierDown' => 0.2,
               ],
               [
                   'filterType' => 'NOTIONAL',
                   'minNotional' => 0.00010000,
                   'applyMinToMarket' => 1,
                   'maxNotional' => 9000000.00000000,
                   'applyMaxToMarket' => '',
                   'avgPriceMins' => 1,
               ],
               [
                   'filterType' => 'MAX_NUM_ORDERS',
                   'maxNumOrders' => 200,
               ],
               [
                   'filterType' => 'MAX_NUM_ALGO_ORDERS',
                   'maxNumAlgoOrders' => 5,
               ],
           ],
           'permissions' => ['SPOT', 'MARGIN'],
           'defaultSelfTradePreventionMode' => 'NONE',
           'allowedSelfTradePreventionModes' => ['NONE'],
       ]
   ],
   'customAdditional' => [
      ['serverTimeDate'] => 'Sat, 15 Jul 2023 17:02:47 UTC'
   ]
]
```
</details>

### [Order Book](https://binance-docs.github.io/apidocs/spot/en/#order-book)
```php
$binance->depth('BTCUSDT', 5);
$binance->orderbook('BTCUSDT', 5);
$binance->orderbookBTCUSDT(5); // "BTCUSDT" you can replace with any market: "ETHUSDT", "BTCBUSD", ...
```

<details>
<summary>View result</summary>

```text
[
            'lastUpdateId' => 1027024,
            'bids' => [
                [
                    'amount' => '4.00000000',
                    'price' => '431.00000000',
                ],
            ],
            'asks' => [
                [
                    'amount' => '4.00000200',
                    'price' => '12.00000000',
                ],
            ]
        ]
```
</details>

### [Recent Trades List](https://binance-docs.github.io/apidocs/spot/en/#recent-trades-list)
```php
$binance->trades('BTCUSDT', 5);
```

<details>
<summary>View result</summary>

```text
[
   [
       'id' => 1454371,
       'price' => '30280.27000000',
       'qty' => '0.00100000',
       'quoteQty' => '48.000012',
       'time' => 1499865549590,
       'isBuyerMaker' => true,
       'isBestMatch' => true,
       'customAdditional' => [
            'timeDate' => 'Sun, 16 Jul 2023 08:17:01 UTC'
       ],
   ],
   [
       'id' => 28457,
       'price' => '4.00000100',
       'qty' => '12.00000000',
       'quoteQty' => '48.000012',
       'time' => 1499865549590,
       'isBuyerMaker' => true,
       'isBestMatch' => true,
       'customAdditional' => [
            'timeDate' => 'Sun, 16 Jul 2023 08:17:01 UTC'
       ],
   ]
]
```
</details>

### [Old Trade Lookup](https://binance-docs.github.io/apidocs/spot/en/#old-trade-lookup)
```php
$binance->historicalTrades('BTCUSDT');
```

<details>
<summary>View result</summary>

```text
[
   [
       'id' => 28457,
       'price' => '4.00000100',
       'qty' => '12.00000000',
       'quoteQty' => '48.000012',
       'time' => 1499865549590,
       'isBuyerMaker' => true,
       'isBestMatch' => true
       'customAdditional' => [
            'timeDate' => 'Sun, 16 Jul 2023 08:17:01 UTC'
       ],
   ],
   [
       'id' => 28457,
       'price' => '4.00000100',
       'qty' => '12.00000000',
       'quoteQty' => '48.000012',
       'time' => 1499865549590,
       'isBuyerMaker' => true,
       'isBestMatch' => true
       'customAdditional' => [
            'timeDate' => 'Sun, 16 Jul 2023 08:17:01 UTC'
       ],
   ]
]
```
</details>

### [Compressed/Aggregate Trades List](https://binance-docs.github.io/apidocs/spot/en/#compressed-aggregate-trades-list)
```php
$binance->aggTrades('BTCUSDT', limit: 5);
```

<details>
<summary>View result</summary>

```text
[
   [
      'aggregateTradeId' => 26129,
      'price' => "0.01633102",
      'quantity' => "4.70443515",
      'firstTradeId' => 27781,
      'lastTradeId' => 27781,
      'timestamp' => 1498793709153,
      'wasTheBuyerTheMaker' => true,
      'wasTheTradeTheBestPriceMatch' => true,
      'customAdditional' => [
           'timestampDate' => 'Sun, 16 Jul 2023 08:21:53 UTC'
      ]
   ],
   [
      'aggregateTradeId' => 26129,
      'price' => "0.01633102",
      'quantity' => "4.70443515",
      'firstTradeId' => 27781,
      'lastTradeId' => 27781,
      'timestamp' => 1498793709153,
      'wasTheBuyerTheMaker' => true,
      'wasTheTradeTheBestPriceMatch' => true,
      'customAdditional' => [
           'timestampDate' => 'Sun, 16 Jul 2023 08:21:53 UTC'
      ]
   ]
]
```
</details>

### [Kline/Candlestick Data](https://binance-docs.github.io/apidocs/spot/en/#kline-candlestick-data)
```php
$binance->klines('BTCUSDT', '1d', limit: 5);
```

<details>
<summary>View result</summary>

```text
[
   [
       'klineOpenTime' => '1689465600000',
       'openPrice' => '30289.53000000',
       'highPrice' => '30335.16000000',
       'lowPrice' => '29984.02000000',
       'closePrice' => '30293.76000000',
       'volume' => '639.17429700',
       'klineCloseTime' => '1689551999999',
       'quoteAssetVolume' => '19323347.68137913',
       'numberOfTrades' => '45576',
       'takerBuyBaseAssetVolume' => '362.10226300',
       'takerBuyQuoteAssetVolume' => '10945758.72630827',
       'unusedField' => '0',
       'customAdditional' => [
           'klineOpenTimeDate' => 'Sun, 16 Jul 2023 00:00:00 UTC',
           'klineCloseTimeDate' => 'Mon, 17 Jul 2023 00:00:00 UTC',
       ],
   ]
]
```
</details>

### [UIKlines](https://binance-docs.github.io/apidocs/spot/en/#uiklines)
```php
$binance->uiKlines('BTCUSDT', '1d', limit: 5);
```

<details>
<summary>View result</summary>

```text
[
   [
       'klineOpenTime' => '1689465600000',
       'openPrice' => '30289.53000000',
       'highPrice' => '30335.16000000',
       'lowPrice' => '29984.02000000',
       'closePrice' => '30293.76000000',
       'volume' => '639.17429700',
       'klineCloseTime' => '1689551999999',
       'quoteAssetVolume' => '19323347.68137913',
       'numberOfTrades' => '45576',
       'takerBuyBaseAssetVolume' => '362.10226300',
       'takerBuyQuoteAssetVolume' => '10945758.72630827',
       'unusedField' => '0',
       'customAdditional' => [
           'klineOpenTimeDate' => 'Sun, 16 Jul 2023 00:00:00 UTC',
           'klineCloseTimeDate' => 'Mon, 17 Jul 2023 00:00:00 UTC',
       ],
   ]
]
```
</details>

### [Current Average Price](https://binance-docs.github.io/apidocs/spot/en/#current-average-price)
```php
$binance->avgPrice('BTCUSDT');
```

<details>
<summary>View result</summary>

```text
[
   'mins' => 5,
   'price' => '9.35751834',
]
```
</details>

### [24hr Ticker Price Change Statistics](https://binance-docs.github.io/apidocs/spot/en/#24hr-ticker-price-change-statistics)
```php
$binance->ticker24hr('BTCUSDT');
```

<details>
<summary>View result</summary>

```text
[
   [
      'symbol' => 'BNBBTC',
      'priceChange' => '-94.99999800',
      'priceChangePercent' => '-95.960',
      'weightedAvgPrice' => '0.29628482',
      'prevClosePrice' => '0.10002000',
      'lastPrice' => '4.00000200',
      'lastQty' => '200.00000000',
      'bidPrice' => '4.00000000',
      'bidQty' => '100.00000000',
      'askPrice' => '4.00000200',
      'askQty' => '100.00000000',
      'openPrice' => '99.00000000',
      'highPrice' => '100.00000000',
      'lowPrice' => '0.10000000',
      'volume' => '8913.30000000',
      'quoteVolume' => '15.30000000',
      'openTime' => 1499783499040,
      'closeTime' => 1499869899040,
      'firstId' => 28385,
      'lastId' => 28460,
      'count' => 76,
      'customAdditional' => [
           'openTimeDate' => 'Sat, 15 Jul 2023 08:35:54 UTC',
           'closeTimeDate' => 'Sun, 16 Jul 2023 08:35:54 UTC'
      ]
   ]
]
```
</details>

### [Symbol Price Ticker](https://binance-docs.github.io/apidocs/spot/en/#symbol-price-ticker)
```php
$binance->tickerPrice();
```

<details>
<summary>View result</summary>

```text
[
    [
        'symbol' => 'LTCBTC',
        'price' => '4.00000200',
    ],
    [
        'symbol' => 'ETHBTC',
        'price' => '0.07946600',
    ]
]
```
</details>

### [Symbol Order Book Ticker](https://binance-docs.github.io/apidocs/spot/en/#symbol-order-book-ticker)
```php
$binance->tickerBookTicker('BTCUSDT');
```

<details>
<summary>View result</summary>

```text
[
    [
        'symbol' => 'LTCBTC',
        'bidPrice' => '4.00000000',
        'bidQty' => '431.00000000',
        'askPrice' => '4.00000200',
        'askQty' => '9.00000000',
    ],
    [
        'symbol' => 'ETHBTC',
        'bidPrice' => '0.07946700',
        'bidQty' => '9.00000000',
        'askPrice' => '100000.00000000',
        'askQty' => '1000.00000000',
    ]
]
```
</details>

### [Rolling window price change statistics](https://binance-docs.github.io/apidocs/spot/en/#rolling-window-price-change-statistics)
```php
$binance->ticker('BTCUSDT');
```

<details>
<summary>View result</summary>

```text
[
    [
        'symbol' => 'BTCUSDT',
        'priceChange' => '-154.13000000',
        'priceChangePercent' => '-0.740',
        'weightedAvgPrice' => '20677.46305250',
        'openPrice' => '20825.27000000',
        'highPrice' => '20972.46000000',
        'lowPrice' => '20327.92000000',
        'lastPrice' => '20671.14000000',
        'volume' => '72.65112300',
        'quoteVolume' => '1502240.91155513',
        'openTime' => 1655432400000,
        'closeTime' => 1655446835460,
        'firstId' => 11147809,
        'lastId' => 11149775,
        'count' => 1967,
        'customAdditional' => [
             'openTimeDate' => 'Sat, 15 Jul 2023 08:35:54 UTC',
             'closeTimeDate' => 'Sun, 16 Jul 2023 08:35:54 UTC'
        ]
    ],
    [
        'symbol' => 'BNBBTC',
        'priceChange' => '0.00008530',
        'priceChangePercent' => '0.823',
        'weightedAvgPrice' => '0.01043129',
        'openPrice' => '0.01036170',
        'highPrice' => '0.01049850',
        'lowPrice' => '0.01033870',
        'lastPrice' => '0.01044700',
        'volume' => '166.67000000',
        'quoteVolume' => '1.73858301',
        'openTime' => 1655432400000,
        'closeTime' => 1655446835460,
        'firstId' => 2351674,
        'lastId' => 2352034,
        'count' => 361,
        'customAdditional' => [
             'openTimeDate' => 'Sat, 15 Jul 2023 08:35:54 UTC',
             'closeTimeDate' => 'Sun, 16 Jul 2023 08:35:54 UTC'
        ]
    ]
]
```
</details>
