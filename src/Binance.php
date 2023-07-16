<?php

namespace BinanceApi;

use Closure;
use GuzzleHttp\Client;
use BinanceApi\Docs\Const\BinanceApi\HasQueryParameters;
use BinanceApi\Docs\Const\Exception\EndpointQueryException;
use BinanceApi\Docs\GeneralInfo\Const\BanBased;
use BinanceApi\Docs\GeneralInfo\EndpointSecurityType;
use BinanceApi\Docs\GeneralInfo\GeneralApiInformation;
use BinanceApi\Docs\GeneralInfo\Limits;
use BinanceApi\Docs\GeneralInfo\Signed;
use BinanceApi\Docs\MarketDataEndpoint\OrderBook;
use BinanceApi\Exception\BinanceException;
use BinanceApi\Exception\BinanceResponseException;
use BinanceApi\Helper\ResponseHandler\CustomResponseHandler;

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
class Binance
{
    /**
     * @var array|array[] property with some information
     */
    protected array $addition = [
        'limits' => [
            BanBased::IP => [
                'api' => [
                    'used' => 0,
                    'lastRequest' => null,
                ],
                'sapi' => [
                    'used' => 0,
                    'lastRequest' => null,
                ],
            ],
            BanBased::ACCOUNT => [
                'count' => 0,
                'lastRequest' => null,
            ],
        ]
    ];

    /**
     * @var BinanceOriginal original binance class to work with Binance API
     */
    public readonly BinanceOriginal $binanceOriginal;

    /**
     * @var string public api key from binance
     */
    protected string $apiKey = '';

    /**
     * @var string private api key from binance
     */
    protected string $apiSecret = '';

    /**
     * @var Closure callback function to filter result data
     */
    protected Closure $outputCallback;

    /**
     * @var bool setting to throw exception or not
     */
    protected bool $isThrowException = true;

    /**
     * Create object
     *
     * @param  string  $endpoint
     * @param  Client  $client
     */
    public function __construct(
        string $endpoint = GeneralApiInformation::BASE_ENDPOINT,
        Client $client = new Client(['timeout' => 2]),
    ) {
        $this->binanceOriginal = new BinanceOriginal(new CustomResponseHandler(), $endpoint, $client);
    }

    /**
     * Return additional information
     *
     * @return array|array[]
     */
    public function getAdditional(): array
    {
        return $this->addition;
    }

    /**
     * Set api keys as a property to use it
     *
     * @param  string  $apiKey
     * @param  string  $apiSecret
     * @return void
     */
    public function setApiKeys(string $apiKey, string $apiSecret = ''): void
    {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
    }

    /**
     * Set a callback function to filter result data
     *
     * @param  Closure  $outputCallback
     * @return void
     */
    public function setOutputCallback(Closure $outputCallback): void
    {
        $this->outputCallback = $outputCallback;
    }

    /**
     * Disable throw exception for class and response handler
     *
     * @return void
     */
    public function disableBinanceExceptions(): void
    {
        if ($this->binanceOriginal->responseHandler instanceof CustomResponseHandler) {
            $this->binanceOriginal->responseHandler->disableException();
        }
        $this->isThrowException = false;
    }

    /**
     * Original methods and analogs (see phpdoc in this class)
     *
     * @throws BinanceException|EndpointQueryException|BinanceResponseException
     */
    public function __call($name, $arguments): array
    {
        // Change $name and $arguments to analog
        $this->getAnalog($name, $arguments);

        $headers = $query = [];

        // Resolve necessary endpoint
        $endpointObject = $this->binanceOriginal->resolveAlias($name);

        // If endpoint secure by api key, then add an api key to header
        if (in_array($endpointObject->endpointType, EndpointSecurityType::SECURITY_TYPES_THROW_API_KEY)) {
            if (! $this->apiKey) {
                $this->throwException('This endpoint {'.$endpointObject->endpoint.'} need api key, you have to set non empty api key in authorize method');
            }

            $headers[EndpointSecurityType::SECURITY_API_KEY_HEADER] = $this->apiKey;
        }

        // If endpoint has query parameters, then get a query as an array
        if ($endpointObject instanceof HasQueryParameters) {
            $query = $endpointObject->getQuery(...$arguments);
        }

        // If endpoint secure by api secret, then create a timestamp parameter and signature
        if (
            in_array($endpointObject->endpointType, EndpointSecurityType::SECURITY_TYPES_THROW_SIGNATURE) &&
            $endpointObject->encryption == Signed::SIGNED_SIGNATURE_ALGO
        ) {
            if (! $this->apiSecret) {
                $this->throwException('This endpoint {'.$endpointObject->endpoint.'} need api secret, you have to set non empty api secret in authorize method');
            }

            $query[Signed::SIGNED_TIMING_SECURITY_PARAMETER] = Signed::binanceMicrotime();
            $query[Signed::SIGNED_PARAMETER] = Signed::signature(http_build_query($query), $this->apiSecret);
        }

        // Form array to return
        $output = [
            'request' => [
                'url' => $endpointObject->endpoint,
                'headers' => $headers,
                'query' => $query,
                'body' => $body ?? [],
            ],
            'response' => $this->binanceOriginal->$name($headers, $query)
        ];

        // If a response handle is CustomResponseHandler, we know which format return and process it
        if ($this->binanceOriginal->responseHandler instanceof CustomResponseHandler) {
            $this->updateAddition($output);
        }

        // if setOutputCallback call it and return, otherwise is simple return
        return (isset($this->outputCallback)) ? ($this->outputCallback)($output) : $output;
    }

    /**
     * Get analogs of some original function and set it
     *
     * @param  string  $name
     * @param  array  $arguments
     * @return void
     */
    protected function getAnalog(string &$name, array &$arguments): void
    {
        $name = match ($name) {
            'orderbook' => OrderBook::METHOD,
            default => $name,
        };

        if (str_contains($name, 'orderbook')) {
            array_unshift($arguments, strtoupper(str_replace('orderbook', '', $name)));
            $name = OrderBook::METHOD;
        }
    }

    /**
     * Update additional property after get response
     *
     * @param  array  $output
     * @return void
     */
    protected function updateAddition(array $output): void
    {
        $headers = $output['response']['info']['headers'];

        $usedWeightHeaderForApi = strtolower(Limits::API_IP_LIMIT_USED_WEIGHT_MINUTE);
        if (isset($headers[$usedWeightHeaderForApi])) {
            $this->addition['limits'][BanBased::IP]['api']['used'] = $headers[$usedWeightHeaderForApi][0];
            $this->addition['limits'][BanBased::IP]['api']['lastRequest'] = $headers['Date'][0];
        }

        $usedWeightHeaderForSapi = strtolower(Limits::SAPI_IP_LIMIT_USED_WEIGHT_MINUTE);
        if (isset($headers[$usedWeightHeaderForSapi])) {
            $this->addition['limits'][BanBased::IP]['sapi']['used'] = $headers[$usedWeightHeaderForSapi][0];
            $this->addition['limits'][BanBased::IP]['sapi']['lastRequest'] = $headers['Date'][0];
        }

        $limitOrderCount = strtolower(Limits::LIMIT_ORDER_COUNT_MINUTE);
        if (isset($headers[$limitOrderCount])) {
            $this->addition['limits'][BanBased::ACCOUNT]['used'] = $headers[$limitOrderCount][0];
            $this->addition['limits'][BanBased::ACCOUNT]['lastRequest'] = $headers['Date'][0];
        }
    }

    /**
     * Check if enable setting to throw exception then do it
     *
     * @param  string  $message
     * @return void
     */
    protected function throwException(string $message): void
    {
        if ($this->isThrowException) {
            throw new BinanceException($message);
        }
    }
}
