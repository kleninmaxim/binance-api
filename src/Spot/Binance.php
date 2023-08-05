<?php

namespace BinanceApi\Spot;

use BinanceApi\App\ResponseHandler\CustomResponseHandler;
use BinanceApi\Exception\BinanceException;
use BinanceApi\Exception\BinanceResponseException;
use BinanceApi\Spot\Docs\Const\BinanceApi\HasBodyParameters;
use BinanceApi\Spot\Docs\Const\BinanceApi\HasQueryParameters;
use BinanceApi\Spot\Docs\Const\Exception\EndpointQueryException;
use BinanceApi\Spot\Docs\GeneralInfo\Const\BanBased;
use BinanceApi\Spot\Docs\GeneralInfo\Const\HttpMethod;
use BinanceApi\Spot\Docs\GeneralInfo\EndpointSecurityType;
use BinanceApi\Spot\Docs\GeneralInfo\GeneralApiInformation;
use BinanceApi\Spot\Docs\GeneralInfo\Limits;
use BinanceApi\Spot\Docs\GeneralInfo\Signed;
use Closure;
use GuzzleHttp\Client;

/**
 *
 * Wallet Endpoints:
 * @method array systemStatus() System Status (System)
 * @method array capitalConfigGetall(null|string $recvWindow = null) All Coins' Information
 * @method array accountSnapshot(string $type = 'SPOT', null|string $startTime = null, null|string $endTime = null, int $limit = 7, null|string $recvWindow = null) Daily Account Snapshot
 * @method array accountDisableFastWithdrawSwitch(null|string $recvWindow = null) Disable Fast Withdraw Switch
 * @method array accountEnableFastWithdrawSwitch(null|string $recvWindow = null) Enable Fast Withdraw Switch
 * @method array capitalWithdrawApply(null|string $coin = null, null|string $address = null, null|string $amount = null, null|string $withdrawOrderId = null, null|string $network = null, null|string $addressTag = null, null|string $transactionFeeFlag = null, null|string $name = null, null|string $walletType = null, null|string $recvWindow = null) Withdraw
 * @method array capitalDepositHisrec(null|string $coin = null, null|string $status = null, null|string $startTime = null, null|string $endTime = null, null|string $offset = null, null|string $limit = null, null|string $recvWindow = null, null|string $txId = null) Deposit History (supporting network)
 * @method array capitalWithdrawHistory(null|string $coin = null, null|string $withdrawOrderId = null, null|string $offset = null, int $limit = 1000, null|string $status = null, null|string $startTime = null, null|string $endTime = null, null|string $recvWindow = null) Withdraw History (supporting network)
 * @method array capitalDepositAddress(null|string $coin = null, null|string $network = null, null|string $recvWindow = null) Deposit Address (supporting network)
 * @method array accountStatus(null|string $recvWindow = null) Account Status
 * @method array accountApiTradingStatus(null|string $recvWindow = null) Account API Trading Status
 * @method array assetDribblet(null|string $startTime = null, null|string $endTime = null, null|string $recvWindow = null) DustLog
 * @method array assetDustBtc(null|string $recvWindow = null) Get Assets That Can Be Converted Into BNB
 * @method array assetDust(array $asset = [], null|string $recvWindow = null) Dust Transfer
 * @method array assetAssetDividend(null|string $asset = null, null|string $startTime = null, null|string $endTime = null, int $limit = 20, null|string $recvWindow = null) Asset Dividend Record
 * @method array assetAssetDetail(null|string $asset = null, null|string $recvWindow = null) Asset Detail
 * @method array assetTradeFee(null|string $symbol = null, null|string $recvWindow = null) Trade Fee
 * @method array assetTransfer(null|string $type = null, null|string $asset = null, null|string $amount = null, null|string $fromSymbol = null, null|string $toSymbol = null, null|string $recvWindow = null) User Universal Transfer
 * @method array getAssetTransfer(null|string $type = null, null|string $startTime = null, null|string $endTime = null, int $current = 1, int $size = 10, null|string $fromSymbol = null, null|string $toSymbol = null, null|string $recvWindow = null) Query User Universal Transfer History
 * @method array assetGetFundingAsset(null|string $asset = null, null|string $needBtcValuation = null, null|string $recvWindow = null) Funding Wallet
 * @method array assetGetUserAsset(null|string $asset = null, null|string $needBtcValuation = null, null|string $recvWindow = null) User Asset
 * @method array assetConvertTransfer(null|string $clientTranId = null, null|string $asset = null, null|string $amount = null, null|string $targetAsset = null, null|string $accountType = null) BUSD Convert
 * @method array assetConvertTransferQueryByPage(null|string $tranId = null, null|string $clientTranId = null, null|string $asset = null, null|string $startTime = null, null|string $endTime = null, null|string $accountType = null, int $current = 1, int $size = 10) BUSD Convert History
 * @method array assetLedgerTransferCloudMiningQueryByPage(null|string $tranId = null, null|string $clientTranId = null, null|string $asset = null, null|string $startTime = null, null|string $endTime = null, int $current = null, int $size = 10) Get Cloud-Mining payment and refund history
 * @method array accountApiRestrictions(null|string $recvWindow = null) Get API Key Permission
 * @method array capitalContractConvertibleCoins() Query auto-converting stable coins
 * @method array switchCapitalContractConvertibleCoins(null|string $coin = null, null|bool|string $enable = null) Switch on/off BUSD and stable coins conversion
 * @method array capitalDepositCreditApply(null|string $depositId = null, null|string $txId = null, null|string $subAccountId = null, null|string $subUserId = null) One click arrival deposit apply (for expired address deposit)
 *
 * Market Data Endpoints:
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
 * Spot Account/Trade:
 * @method array orderTest(null|string $symbol = null, null|string $side = null, null|string $type = null, null|string $timeInForce = null, null|string $quantity = null, null|string $quoteOrderQty = null, null|string $price = null, null|string $newClientOrderId = null, null|string $strategyId = null, null|string $strategyType = null, null|string $stopPrice = null, null|string $trailingDelta = null, null|string $icebergQty = null, null|string $newOrderRespType = null, null|string $selfTradePreventionMode = null, null|string $recvWindow = null) Test New Order
 * @method array order(null|string $symbol = null, null|string $side = null, null|string $type = null, null|string $timeInForce = null, null|string $quantity = null, null|string $quoteOrderQty = null, null|string $price = null, null|string $newClientOrderId = null, null|string $strategyId = null, null|string $strategyType = null, null|string $stopPrice = null, null|string $trailingDelta = null, null|string $icebergQty = null, null|string $newOrderRespType = null, null|string $selfTradePreventionMode = null, null|string $recvWindow = null) New Order
 * @method array cancelOrder(null|string $symbol = null, null|string $orderId = null, null|string $origClientOrderId = null, null|string $newClientOrderId = null, null|string $cancelRestrictions = null, null|string $recvWindow = null) Cancel Order
 * @method array cancelOpenOrders(null|string $symbol = null, null|string $recvWindow = null) Cancel all Open Orders on a Symbol
 * @method array getOrder(null|string $symbol = null, null|string $orderId = null, null|string $origClientOrderId = null, null|string $recvWindow = null) Query Order
 * @method array orderCancelReplace(null|string $symbol = null, null|string $side = null, null|string $type = null, null|string $cancelReplaceMode = null, null|string $timeInForce = null, null|string $quantity = null, null|string $quoteOrderQty = null, null|string $price = null, null|string $cancelNewClientOrderId = null, null|string $cancelOrigClientOrderId = null, null|string $cancelOrderId = null, null|string $newClientOrderId = null, null|string $strategyId = null, null|string $strategyType = null, null|string $stopPrice = null, null|string $trailingDelta = null, null|string $icebergQty = null, null|string $newOrderRespType = null, null|string $selfTradePreventionMode = null, null|string $cancelRestrictions = null, null|string $recvWindow = null) Cancel an Existing Order and Send a New Order
 * @method array openOrders(null|string $symbol = null, null|string $recvWindow = null) Current Open Orders
 * @method array allOrders(null|string $symbol = null, null|string $orderId = null, null|string $startTime = null, null|string $endTime = null, int $limit = 500, null|string $recvWindow = null) All Orders
 * @method array orderOco(null|string $symbol = null, null|string $listClientOrderId = null, null|string $side = null, null|string $quantity = null, null|string $limitClientOrderId = null, null|string $limitStrategyId = null, null|string $limitStrategyType = null, null|string $price = null, null|string $limitIcebergQty = null, null|string $trailingDelta = null, null|string $stopClientOrderId = null, null|string $stopPrice = null, null|string $stopStrategyId = null, null|string $stopStrategyType = null, null|string $stopLimitPrice = null, null|string $stopIcebergQty = null, null|string $stopLimitTimeInForce = null, null|string $newOrderRespType = null, null|string $selfTradePreventionMode = null, null|string $recvWindow = null) New OCO
 * @method array cancelOrderList(null|string $symbol = null, null|string $orderListId = null, null|string $listClientOrderId = null, null|string $newClientOrderId = null, null|string $recvWindow = null) Cancel OCO
 * @method array orderList(null|string $orderListId = null, null|string $origClientOrderId = null, null|string $recvWindow = null) Query OCO
 * @method array allOrderList(null|string $fromId = null, null|string $startTime = null, null|string $endTime = null, int $limit = 500, null|string $recvWindow = null) Query all OCO
 * @method array openOrderList(null|string $recvWindow = null) Query Open OCO
 * @method array account(null|string $recvWindow = null) Account Information
 * @method array myTrades(null|string $symbol = null, null|string $orderId = null, null|string $startTime = null, null|string $endTime = null, null|string $fromId = null, int $limit = 500, null|string $recvWindow = null) Account Trade List
 * @method array rateLimitOrder(null|string $recvWindow = null) Query Current Order Count Usage
 * @method array myPreventedMatches(null|string $symbol = null, null|string $preventedMatchId = null, null|string $orderId = null, null|string $fromPreventedMatchId = null, int $limit = 500, null|string $recvWindow = null) Query Prevented Matches
 *
 * Analogs:
 * @method array withdraw(null|string $coin = null, null|string $address = null, null|string $amount = null, null|string $withdrawOrderId = null, null|string $network = null, null|string $addressTag = null, null|string $transactionFeeFlag = null, null|string $name = null, null|string $walletType = null, null|string $recvWindow = null) capitalWithdrawApply() analog
 *
 * @method array orderbook(string $symbol, int $limit = 100) depth() analog
 * @method array orderbookBTCUSDT(int $limit = 100) depth() analog
 * @method array tradesBTCUSDT(int $limit = 500) trades() analog
 * @method array secondKlines(null|string $symbol = null, null|string $startTime = null, null|string $endTime = null, int $limit = 500) klines() analog
 * @method array minuteKlines(null|string $symbol = null, null|string $startTime = null, null|string $endTime = null, int $limit = 500) klines() analog
 * @method array threeMinuteKlines(null|string $symbol = null, null|string $startTime = null, null|string $endTime = null, int $limit = 500) klines() analog
 * @method array fiveMinuteKlines(null|string $symbol = null, null|string $startTime = null, null|string $endTime = null, int $limit = 500) klines() analog
 * @method array fifteenMinuteKlines(null|string $symbol = null, null|string $startTime = null, null|string $endTime = null, int $limit = 500) klines() analog
 * @method array thirtyMinuteKlines(null|string $symbol = null, null|string $startTime = null, null|string $endTime = null, int $limit = 500) klines() analog
 * @method array hourKlines(null|string $symbol = null, null|string $startTime = null, null|string $endTime = null, int $limit = 500) klines() analog
 * @method array twoHourKlines(null|string $symbol = null, null|string $startTime = null, null|string $endTime = null, int $limit = 500) klines() analog
 * @method array fourHourKlines(null|string $symbol = null, null|string $startTime = null, null|string $endTime = null, int $limit = 500) klines() analog
 * @method array sixHourKlines(null|string $symbol = null, null|string $startTime = null, null|string $endTime = null, int $limit = 500) klines() analog
 * @method array eightHourKlines(null|string $symbol = null, null|string $startTime = null, null|string $endTime = null, int $limit = 500) klines() analog
 * @method array twelveHourKlines(null|string $symbol = null, null|string $startTime = null, null|string $endTime = null, int $limit = 500) klines() analog
 * @method array dayKlines(null|string $symbol = null, null|string $startTime = null, null|string $endTime = null, int $limit = 500) klines() analog
 * @method array threeDayKlines(null|string $symbol = null, null|string $startTime = null, null|string $endTime = null, int $limit = 500) klines() analog
 * @method array weekKlines(null|string $symbol = null, null|string $startTime = null, null|string $endTime = null, int $limit = 500) klines() analog
 * @method array monthKlines(null|string $symbol = null, null|string $startTime = null, null|string $endTime = null, int $limit = 500) klines() analog
 *
 * @method array limitOrder(null|string $symbol = null, null|string $side = null, null|string $quantity = null, null|string $quoteOrderQty = null, null|string $price = null, null|string $newClientOrderId = null, null|string $strategyId = null, null|string $strategyType = null, null|string $stopPrice = null, null|string $trailingDelta = null, null|string $icebergQty = null, null|string $newOrderRespType = null, null|string $selfTradePreventionMode = null, null|string $recvWindow = null) order() analog
 * @method array marketOrder(null|string $symbol = null, null|string $side = null, null|string $quantity = null, null|string $quoteOrderQty = null, null|string $price = null, null|string $newClientOrderId = null, null|string $strategyId = null, null|string $strategyType = null, null|string $stopPrice = null, null|string $trailingDelta = null, null|string $icebergQty = null, null|string $newOrderRespType = null, null|string $selfTradePreventionMode = null, null|string $recvWindow = null) order() analog
 * @method array stopLossOrder(null|string $symbol = null, null|string $side = null, null|string $quantity = null, null|string $quoteOrderQty = null, null|string $price = null, null|string $newClientOrderId = null, null|string $strategyId = null, null|string $strategyType = null, null|string $stopPrice = null, null|string $trailingDelta = null, null|string $icebergQty = null, null|string $newOrderRespType = null, null|string $selfTradePreventionMode = null, null|string $recvWindow = null) order() analog
 * @method array takeProfitOrder(null|string $symbol = null, null|string $side = null, null|string $quantity = null, null|string $quoteOrderQty = null, null|string $price = null, null|string $newClientOrderId = null, null|string $strategyId = null, null|string $strategyType = null, null|string $stopPrice = null, null|string $trailingDelta = null, null|string $icebergQty = null, null|string $newOrderRespType = null, null|string $selfTradePreventionMode = null, null|string $recvWindow = null) order() analog
 */
class Binance
{
    use BinanceAnalogs;

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
     * @var BinanceSpotOriginal original binance class to work with Binance API
     */
    public readonly BinanceSpotOriginal $binanceOriginal;

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
        $this->binanceOriginal = new BinanceSpotOriginal(new CustomResponseHandler(), $endpoint, $client);
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
        $this->isThrowException = false;
    }

    /**
     * Original methods and analogs (see phpdoc in this class)
     *
     * @throws BinanceException|EndpointQueryException|BinanceResponseException|\BinanceApi\Exception\MethodNotExistException
     */
    public function __call($name, $arguments): ?array
    {
        // Change $name and $arguments from analog to original
        $this->getAnalog($name, $arguments);

        $headers = $query = $body = [];

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

        // If endpoint has query parameters, then get a query as an array
        if ($endpointObject instanceof HasBodyParameters) {
            $body = $endpointObject->getBody(...$arguments);
        }

        // If endpoint secure by api secret, then create a timestamp parameter and signature
        if (
            in_array($endpointObject->endpointType, EndpointSecurityType::SECURITY_TYPES_THROW_SIGNATURE) &&
            $endpointObject->encryption == Signed::SIGNED_SIGNATURE_ALGO
        ) {
            if (! $this->apiSecret) {
                $this->throwException('This endpoint {'.$endpointObject->endpoint.'} need api secret, you have to set non empty api secret in authorize method');
            }

            if ($endpointObject->httpMethod == HttpMethod::GET) {
                $query[Signed::SIGNED_TIMING_SECURITY_PARAMETER] = Signed::binanceMicrotime();
                $query[Signed::SIGNED_PARAMETER] = Signed::signature(http_build_query($query), $this->apiSecret);
            }

            if (in_array($endpointObject->httpMethod, [HttpMethod::POST, HttpMethod::DELETE])) {
                $body[Signed::SIGNED_TIMING_SECURITY_PARAMETER] = Signed::binanceMicrotime();
                $body[Signed::SIGNED_PARAMETER] = Signed::signature(http_build_query($body), $this->apiSecret);
            }
        }

        // Form array to return
        $output = [
            'request' => [
                'url' => $endpointObject->endpoint,
                'headers' => $headers,
                'query' => $query,
                'body' => $body,
            ],
            'response' => $this->binanceOriginal->$name($headers, $query, $body)
        ];

        // If a response handle is CustomResponseHandler, we know which format return and process it
        if ($this->binanceOriginal->responseHandler instanceof CustomResponseHandler) {
            $this->updateAddition($output);

            $this->handleResponseError($output['response']['data']);
        }

        // if setOutputCallback call it and return, otherwise is simple return
        return isset($this->outputCallback) ? ($this->outputCallback)($output) : $output;
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
            $this->addition['limits'][BanBased::IP]['api'] = [
                'used' => $headers[$usedWeightHeaderForApi][0],
                'lastRequest' => $headers['Date'][0],
            ];
        }

        $usedWeightHeaderForSapi = strtoupper(Limits::SAPI_IP_LIMIT_USED_WEIGHT_MINUTE);
        if (isset($headers[$usedWeightHeaderForSapi])) {
            $this->addition['limits'][BanBased::IP]['sapi'] = [
                'used' => $headers[$usedWeightHeaderForSapi][0],
                'lastRequest' => $headers['Date'][0],
            ];
        }

        $limitOrderCount = strtolower(Limits::LIMIT_ORDER_COUNT_MINUTE);
        if (isset($headers[$limitOrderCount])) {
            $this->addition['limits'][BanBased::ACCOUNT] = [
                'used' => $headers[$limitOrderCount][0],
                'lastRequest' => $headers['Date'][0],
            ];
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

    /**
     * Handle response to check is error message and if it does then throw exception
     *
     * @throws BinanceResponseException
     */
    protected function handleResponseError(null|array $data): void
    {
        if ($this->isThrowException && GeneralApiInformation::isErrorMessage($data)) {
            throw new BinanceResponseException(
                $data[GeneralApiInformation::ERROR_CODE_AND_MESSAGES[1]],
                $data[GeneralApiInformation::ERROR_CODE_AND_MESSAGES[0]]
            );
        }
    }
}
