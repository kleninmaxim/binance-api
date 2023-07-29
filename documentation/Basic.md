## Basic

This topic all about `\BinanceApi\Binance` class

### Create a class with different endpoints
_By default, it: `https://api.binance.com`_
```php
$binanceOriginalEndpoint = new \BinanceApi\Binance();
$binance = new \BinanceApi\Binance('https://api3.binance.com');

// Or through constants
$binance = new \BinanceApi\Binance(\BinanceApi\Docs\GeneralInfo\GeneralApiInformation::GCP_ENDPOINT);
$binance = new \BinanceApi\Binance(\BinanceApi\Docs\GeneralInfo\GeneralApiInformation::API1_ENDPOINT);
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

### Filter every ending result
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
    // Here exception with Endpoint query parameters related,
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
    // It's about Guzzle exception
    // https://docs.guzzlephp.org/en/stable/quickstart.html#exceptions
}
```

### Additional information

After each request additional property updated by request, and you can use it.

```php
$binance->getAdditional();
```

You can see, for example, how many limits you use in binance weights and last request that you made:
```php
print_r($binance->getAdditional()['limits']['IP']['api']);
```
```text
Array
(
    [used] => 2 // By default maximum weight in minute is 1200
    [lastRequest] => Sat, 15 Jul 2023 14:19:01 GMT
)
```

