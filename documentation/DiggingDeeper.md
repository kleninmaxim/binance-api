## Digging deeper

### Disable exceptions

If you disable exception, then you will get the original error response as Binance return

```php
$binance->disableBinanceExceptions();
```
After to execute this method, you will not get:

`BinanceApi\Exception\BinanceException`

`BinanceApi\Exception\BinanceResponseException`

But you still can get:

`BinanceApi\Docs\Const\Exception\EndpointQueryException`

`BinanceApi\Exception\MethodNotExistException`

`\GuzzleHttp\Exception\GuzzleException`

### Endpoint

Endpoint is the main core of information on which the binance classes rely

Let's look at one random Endpoint class:

```php
<?php

namespace BinanceApi\Docs\MarketDataEndpoint;

use BinanceApi\Spot\Docs\Const\BinanceApi\Endpoint;use BinanceApi\Spot\Docs\Const\BinanceApi\HasQueryParameters;use BinanceApi\Spot\Docs\Const\BinanceApi\ProcessResponse;use BinanceApi\Spot\Docs\GeneralInfo\Const\BanBased;use BinanceApi\Spot\Docs\GeneralInfo\Const\HttpMethod;use BinanceApi\Spot\Docs\GeneralInfo\DataSources;use BinanceApi\Spot\Docs\GeneralInfo\EndpointSecurityType;

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

That class must implement by `BinanceApi\Docs\Const\BinanceApi\Endpoint` class

`exampleResponse()` is only used as a returning result for Unit Test and your own purpose and as a doc.

`__construct()` - we must have all those properties which are set in constructor

`BinanceApi\Docs\Const\BinanceApi\HasQueryParameters` are mandatory if endpoint must have query parameters.

`BinanceApi\Docs\Const\BinanceApi\HasBodyParameters` are mandatory if endpoint must have body parameters.

`BinanceApi\Docs\Const\BinanceApi\ProcessResponse` are optional if you want to rewrite original response from Binance 

`public const METHOD = 'depth';` - we can optional set to add method for Binance classes and execute it

### Rewrite original Endpoint

You can extend that endpoint class and rewrite everything you want

```php
<?php

readonly class ExtendedKlineCandlestickData extends \BinanceApi\Spot\Docs\MarketDataEndpoint\KlineCandlestickData
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

// Replace default alias in 'klines'. See the topic below about it
$binance->binanceOriginal->addAlias(\BinanceApi\Spot\Docs\MarketDataEndpoint\KlineCandlestickData::METHOD, ExtendedKlineCandlestickData::class);

$binance->klines('BTCUSDT', '1d', limit: 5); // and will handle the content of response in that format
```

### Add Endpoint to execute it as a function

You can create your own Endpoint by previous topic or use already existing Endpoint

```php
$binance = new \BinanceApi\Spot\Binance();
$binance->binanceOriginal->addAlias('yourCustomFunction', YourCustomEndpoint::class);

// If YourCustomEndpoint::class implements of BinanceApi\Docs\Const\BinanceApi\HasQueryParameters
// or BinanceApi\Docs\Const\BinanceApi\HasBodyParameters set parameters to function
$binance->yourCustomFunction(...$parameters);

$binance->depth('BTCUSDT', 5);
```

```php
$binance = new \BinanceApi\Spot\Binance();
$binance->binanceOriginal->addAlias('yourCustomFunctionToGetOrderbook', \BinanceApi\Spot\Docs\MarketDataEndpoint\OrderBook::class);

// Now yourCustomFunctionToGetOrderbook() and depth() are identical and fully the same
$binance->yourCustomFunctionToGetOrderbook('BTCUSDT', 5);
$binance->depth('BTCUSDT', 5);
```

### Let's talk about BinanceOriginal

 ```php
 $binance = new \BinanceApi\Spot\BinanceSpotOriginal();

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

When we call any method, for example, `depth($headers, $query, $body)` It resolves alias from property and executes http request.

Each method in BinanceOriginal has fixed parameters: 
`depth(array $headers = [], array $query = [], array $body = []): mixed`.

All these parameters for http request.

You can have access to `\BinanceApi\BinanceOriginal` class through `\BinanceApi\Binance` class

```php
$binance = new \BinanceApi\Spot\Binance();

$binance->binanceOriginal; // This is \BinanceApi\BinanceOriginal::class

// And you can execute all methods
$binance->binanceOriginal->depth(['x-headers' => 'some-value'], ['symbol' => 'BTCUSDT', 'limit' => 10]);

// Example with signature to create limit order
$body = [
   'symbol' => 'BTCUSDT', 
   'side' => 'BUY', 
   'type' => 'LIMIT', 
   'timeInForce' => 'GTC', 
   'quantity' => 0.01, 
   'price' => 20000, 
   'timestamp' => \BinanceApi\Spot\Docs\GeneralInfo\Signed::binanceMicrotime(), 
];
$body['signature'] = \BinanceApi\Spot\Docs\GeneralInfo\Signed::signature(http_build_query($body), 'your-api-secret');

$binance->binanceOriginal->order(['X-MBX-APIKEY' => 'your-api-key'], body: $body);
```

### Return response in different variations

```php
// every result you will get as Guzzle Psr7 Format
$binanceOriginal = new \BinanceApi\Spot\BinanceSpotOriginal(new \BinanceApi\App\ResponseHandler\GuzzlePsr7ResponseHandler());
$binanceOriginal->depth(query: ['symbol' => 'BTCUSDT', 'limit' => 10]); // GuzzleHttp\Psr7\Response Object
 
 // every result you will get as encoded message
$binanceOriginal = new \BinanceApi\Spot\BinanceSpotOriginal(new \BinanceApi\App\ResponseHandler\OriginalResponseHandler());
$binanceOriginal->depth(query: ['symbol' => 'BTCUSDT', 'limit' => 10]); // string(686) "{"lastUpdateId":38045811823,"bids":[["29089.15000000","0.83957000"],["29089.10000000","0.00402000"],["29089.00000000","0.00384000"],["29088.91000000","0.00083000"],["29088.68000000","0.39883000"],["29088.66000000","0.38883000"],["29088.58000000","0.02548000"],["29088.53000000","0.00170000"],["29088.33000000","0.00481000"],["29088.31000000","0.00035000"]],"asks":[["29089.16000000","8.54491000"],["29089.19000000","0.34384000"],["29089.42000000","0.09425000"],["29089.43000000","0.05400000"],["29089.47000000","0.18862000"],["29089.48000000","0.00090000"],["29089.49000000","0.34383000"],["29089.89000000","0.15706000"],["29089.91000000","0.20000000"],["29089.99000000","0.73589000"]]}"
```

### The difference between Binance and BinanceOriginal

So, if you don't want to worry about the internal structure of classes
and want to use ready-made methods use `\BinanceApi\Binance` class, and it will be nice.

Use `\BinanceApi\BinanceOriginal` class
if you want to make any custom request with adding your parameters to the header,
query and body bypassing the `\BinanceApi\Binance` class

`\BinanceApi\Binance` class:
1) Return a full result and handle it
2) Every method has its own parameters to endpoint
3) Add to request necessary parameters, for example, api key to header and signature
4) Has additional property with some information
5) Handle the request from Binance (for example, in orderbook request you can see `price` and `amount`)
6) Throw Exception if a Binance return error message
7) And more another feature

`\BinanceApi\BinanceOriginal` class:
1) Return an original result from Binance as in documentation
2) This class also will return an error result from Binance
3) Every method you can see in `\BinanceApi\BinanceAliases` has three parameters:headers, query, body
