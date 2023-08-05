<?php

namespace BinanceApi\Spot\Docs\MarketDataEndpoint;

use BinanceApi\Helper\Carbon;
use BinanceApi\Spot\Docs\Const\BinanceApi\Endpoint;
use BinanceApi\Spot\Docs\Const\BinanceApi\HasQueryParameters;
use BinanceApi\Spot\Docs\Const\BinanceApi\ProcessResponse;
use BinanceApi\Spot\Docs\GeneralInfo\Const\BanBased;
use BinanceApi\Spot\Docs\GeneralInfo\Const\HttpMethod;
use BinanceApi\Spot\Docs\GeneralInfo\DataSources;
use BinanceApi\Spot\Docs\GeneralInfo\EndpointSecurityType;

/**
 * https://binance-docs.github.io/apidocs/spot/en/#exchange-information
 *
 * Exchange Information
 */
readonly class ExchangeInformation implements Endpoint, HasQueryParameters, ProcessResponse
{
    public const METHOD = 'exchangeInfo';

    public function __construct(
        public string $endpoint = '/api/v3/exchangeInfo',
        public string $httpMethod = HttpMethod::GET,
        public null|int $weight = 10,
        public string $weightBased = BanBased::IP,
        public null|string $dataSource = DataSources::MEMORY,
        public null|string $encryption = null,
        public string $endpointType = EndpointSecurityType::NONE,
        public string $title = 'Exchange Information',
        public string $description = 'Current exchange trading rules and symbol information',
    ) {
    }

    public function getQuery(
        null|string $symbol = null,
        null|array $symbols = null,
        null|string|array $permissions = null
    ): array {
        $query = [];

        if ($symbol) {
            $query['symbol'] = $symbol;
        }

        if ($symbols) {
            $query['symbols'] = '["' . implode('","', $symbols) . '"]';
        }

        if (is_string($permissions)) {
            $query['permissions'] = $permissions;
        } elseif (is_array($permissions)) {
            $query['permissions'] = '["' . implode('","', $permissions) . '"]';
        }

        return $query;
    }

    public function processResponse(array $response): array
    {
        $response[ProcessResponse::ADDITIONAL_FIELD]['serverTimeDate'] = Carbon::getFullDate($response['serverTime']);

        return $response;
    }

    public static function exampleResponse(): string
    {
        return json_encode([
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
            ]
        ]);
    }
}
