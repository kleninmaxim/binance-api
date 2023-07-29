# Binance PHP API Client
The purpose of this project is to assist you in creating your own projects that interact with the [Binance SPOT API](https://binance-docs.github.io/apidocs/spot/en/).

Supported in the current version [Wallet Endpoints](https://binance-docs.github.io/apidocs/spot/en/#wallet-endpoints),
[Market Data Endpoints](https://binance-docs.github.io/apidocs/spot/en/#market-data-endpoints) and [Spot Account/Trade](https://binance-docs.github.io/apidocs/spot/en/#spot-account-trade)

## Introduction
This project requires [php](https://www.php.net/) version more or equal 8.2. Also it requires [bcmath](https://www.php.net/manual/en/book.bc.php) extension and [guzzle](https://docs.guzzlephp.org/en/stable/) dependency

## Installation

```shell
composer require kleninm/binance-api
```

## Quick start
Every original method's name in `\BinanceApi\Binance` class created by name from url after prefix `v1`, `v2` or `v3`.

For example, by table:
<table>
   <tr><td> Link to endpoint </td> <td> Method name </td></tr>
   
   <tr><td>

   [Order Book](https://binance-docs.github.io/apidocs/spot/en/#order-book)
   
   </td><td>
   
   ```php
   $binance->depth($symbol, $limit);
   ```
   </td></tr>
   
   <tr><td>

   [Symbol Order Book Ticker](https://binance-docs.github.io/apidocs/spot/en/#symbol-order-book-ticker)

   </td><td>

   ```php
   $binance->tickerBookTicker($symbol);
   ``` 
   </td></tr>

   <tr><td>

   [24hr Ticker Price Change Statistics](https://binance-docs.github.io/apidocs/spot/en/#24hr-ticker-price-change-statistics)

   </td><td>

   ```php
   $binance->ticker24hr($symbol, $symbols, $type);
   ```
   </td></tr>

   <tr><td>

[Withdraw History (supporting network)](https://binance-docs.github.io/apidocs/spot/en/#withdraw-history-supporting-network-user_data)

   </td><td>

   ```php
   $binance->capitalWithdrawHistory();
   ```
   </td></tr>
</table>

All endpoints and their methods with parameters you can see in phpdoc in `\BinanceApi\Binance` class

Full docs you can find in `documentation` folder of this repository

Look at the [Basic](https://github.com/kleninmaxim/binance-api/tree/1.x/documentation/Basic.md) topic
to learn more features

Look at the [Digging deeper](https://github.com/kleninmaxim/binance-api/tree/1.x/documentation/Basic.md) topic
if you want to dive deep into the mechanism and add more yourself customizations and scale functionality

You can go to the [Examples and Analogs](https://github.com/kleninmaxim/binance-api/tree/1.x/documentation/ExamplesAndAnalogs.md) topic
to see more examples, include what each function returns

## Simple start

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

## If you want to use [testnet](https://testnet.binance.vision/)
```php
$binanceTestNet = new \BinanceApi\Binance(TestNet::BASE_ENDPOINT);

$fullResult = $binance->depth('BTCUSDT', 2);
```

## Set api keys

Some endpoints will require an API Keys. You can set them like this:

```php
$binance->setApiKeys($apiKey, $secretKey);
```

## Handle often throws errors:
```php
try {
    $result = $binance->depth('BTCUSDT', 2);
} catch (BinanceApi\Exception\BinanceResponseException $e) {
    // This is exception throw, when binance return error message
    // https://binance-docs.github.io/apidocs/spot/en/#error-codes
} catch (\GuzzleHttp\Exception\GuzzleException $e) {
    // It's about Guzzle exception
    // https://docs.guzzlephp.org/en/stable/quickstart.html#exceptions
}
```
_Full list of errors, you can see in Basic topic_

## Rate limits

Limits by IP

```php
$binance->getAdditional()['limits']['IP']['api'];
```

```text
Array
(
    [used] => 2 // By default maximum weight in minute is 1200
    [lastRequest] => Sat, 15 Jul 2023 14:19:01 GMT
)
```

```php
$dateTime = new DateTime($binance->getAdditional()['limits']['IP']['api']['lastRequest']);

$dateTime = new DateTime($binance->getAdditional()['limits']['IP']['sapi']['lastRequest']);
```

You know how much weight you use

Binance reset weights by IP (api and sapi) every minute

## Binance time

At any places where you need to use time, use a binance microtime format

You can get binance microtime now by function:

```php
\BinanceApi\Docs\GeneralInfo\Signed::binanceMicrotime(); //1690113560956
```

## More examples

Common part for all next examples

```php
$binance = new \BinanceApi\Binance();

$binance->setApiKeys($apiKey, $secretKey);

// Filter every output. Read more about it in a Basic topic or just use it if you need only a body result from request
$binance->setOutputCallback(function ($output) {
    return $output['response']['data'];
});
```

### Exchange info

Current exchange trading rules and symbol information

```php
$binance->exchangeInfo();
```

### Order book

All three methods are identical. Use that you prefer

```php
$binance->depth('BTCUSDT', 5);

$binance->orderbook('BTCUSDT', 5);

$binance->orderbookBTCUSDT(5); // "BTCUSDT" you can replace with any market: "ETHUSDT", "BTCBUSD", ...
```

### Trades

All two methods are identical. Use that you prefer

```php
$binance->trades('BTCUSDT', 5);

$binance->tradesETHUSDT(5); // "ETHUSDT" you can replace with any market: "BTCUSDT", "BTCBUSD", ...
```

### Klines/Candlestick

Kline/candlestick bars for a symbol.

```php
$binance->klines('BTCUSDT', '1m', limit: 50);

$startTime = (new DateTime('01 Jan 2022 00:00:00 GMT'))->getTimestamp() * 1000;
$binance->klines('BTCUSDT', '1d', $startTime);

$endTime = (new DateTime('01 Jan 2023 00:00:00 GMT'))->getTimestamp() * 1000;
$binance->klines('BTCUSDT', '1d', endTime: $endTime);
```
```php
$binance->secondKlines('BTCUSDT');

$binance->minuteKlines('BTCUSDT');

$binance->threeMinuteKlines('BTCUSDT');

$binance->fiveMinuteKlines('BTCUSDT');

$binance->fifteenMinuteKlines('BTCUSDT');

$binance->thirtyMinuteKlines('BTCUSDT');

$binance->hourKlines('BTCUSDT');

$binance->twoHourKlines('BTCUSDT');

$binance->fourHourKlines('BTCUSDT');

$binance->sixHourKlines('BTCUSDT');

$binance->eightHourKlines('BTCUSDT');

$binance->twelveHourKlines('BTCUSDT');

$binance->dayKlines('BTCUSDT');

$binance->threeDayKlines('BTCUSDT');

$binance->weekKlines('BTCUSDT');

$binance->monthKlines('BTCUSDT');
```
```php
$startTime = new DateTime('01 Jan 2022 00:00:00 GMT');
$binance->hourKlines('BTCUSDT', $startTime, limit: 24);

$endTime = new DateTime('01 Jan 2022 00:00:00 GMT');
$binance->hourKlines('BTCUSDT', endTime: $endTime, limit: 48);
```

### Prices

Latest price for a symbol or symbols.

```php
$binance->tickerPrice();

$binance->tickerPrice('BTCUSDT');
```

### Limit order

```php
$binance->order('BTCUSDT', 'BUY', 'LIMIT', 'GTC', 0.01, price: 20000);

$binance->limitOrder('BTCUSDT', 'BUY', 0.01, price: 21000);
```

### Market order

```php
$binance->order('BTCUSDT', 'BUY', 'MARKET', quantity: 0.01);

$binance->marketOrder('BTCUSDT', 'SELL', 0.01);
```

### Stop loss order

```php
$binance->order('BTCUSDT', 'SELL', 'STOP_LOSS', 'GTC', 0.01, stopPrice: 25000);

$binance->stopLossOrder('BTCUSDT', 'SELL', 0.01, stopPrice: 25000);
```

### Take profit order

```php
$binance->order('BTCUSDT', 'SELL', 'TAKE_PROFIT', 'GTC', 0.01, stopPrice: 100000);

$binance->takeProfitOrder('BTCUSDT', 'SELL', 0.01, stopPrice: 100000);
```

### Get open orders

Get all open orders on a symbol. Careful when accessing this with no symbol.

```php
$binance->openOrders('BTCUSDT');

$binance->openOrders();
```

### Get order status

Check an order's status.

```php
$binance->getOrder('BTCUSDT', 8403075);
```

### Cancel order

Cancel an active order.

```php
$binance->cancelOrder('BTCUSDT', 8403075);
```

### Cancel all orders

Cancels all active orders on a symbol.

```php
$binance->cancelOpenOrders('BTCUSDT');
```

### Account Information (Including Balances)

Get current account information.

```php
$binance->account();
```

### Account Trade List

Get trades for a specific account and symbol.

```php
$binance->myTrades('BTCUSDT');
```

### All Coins' Information

Get information of coins (available for deposit and withdraw) for user.

```php
$binance->capitalConfigGetall();
```

### Withdraw

Submit a withdraw request.

```php
$binance->capitalWithdrawApply('USDT', network: 'TRX', address: 'TNGjavWm7sMjCA4r1YhsEYGfaZtZEkXzNf', amount: 10);

$binance->withdraw('USDT', network: 'TRX', address: 'TNGjavWm7sMjCA4r1YhsEYGfaZtZEkXzNf', amount: 10);
```

### Withdraw History (supporting network)

Fetch withdraw history.

```php
$binance->capitalWithdrawHistory();
```

### Deposit Address (supporting network)

Fetch deposit address with network.

```php
$binance->capitalDepositAddress('USDT', 'TRX');
```

### Deposit History (supporting network)

Fetch deposit history.

```php
$binance->capitalDepositHisrec();
```

# Contributing
- Please give a star or fork repository 💫
- Create a new issues or pull requests 🤝

# License

Binance PHP API Client is licensed under [The MIT License (MIT)](https://github.com/kleninmaxim/binance-api/blob/1.x/LICENSE).
