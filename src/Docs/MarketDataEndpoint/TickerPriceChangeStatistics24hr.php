<?php

namespace BinanceApi\Docs\MarketDataEndpoint;

use BinanceApi\Docs\Const\BinanceApi\Endpoint;
use BinanceApi\Docs\Const\BinanceApi\HasQueryParameters;
use BinanceApi\Docs\Const\BinanceApi\ProcessResponse;
use BinanceApi\Docs\GeneralInfo\Const\BanBased;
use BinanceApi\Docs\GeneralInfo\Const\HttpMethod;
use BinanceApi\Docs\GeneralInfo\DataSources;
use BinanceApi\Docs\GeneralInfo\EndpointSecurityType;
use BinanceApi\Helper\Carbon;

/**
 * https://binance-docs.github.io/apidocs/spot/en/#24hr-ticker-price-change-statistics
 *
 * 24hr Ticker Price Change Statistics
 */
readonly class TickerPriceChangeStatistics24hr implements Endpoint, HasQueryParameters, ProcessResponse
{
    public const METHOD = 'ticker24hr';

    public function __construct(
        public string $endpoint = '/api/v3/ticker/24hr',
        public string $httpMethod = HttpMethod::GET,
        public null|int $weight = 1,
        public string $weightBased = BanBased::IP,
        public null|string $dataSource = DataSources::MEMORY,
        public null|string $encryption = null,
        public string $endpointType = EndpointSecurityType::NONE,
        public string $title = '24hr Ticker Price Change Statistics',
        public string $description = '24 hour rolling window price change statistics. Careful when accessing this with no symbol.',
    ) {
    }

    public function getQuery(null|string $symbol = null, null|array $symbols = null, string $type = 'FULL'): array
    {
        $query = ['type' => $type];

        if ($symbol) {
            $query['symbol'] = $symbol;
        }

        if ($symbols) {
            $query['symbols'] = '["' . implode('","', $symbols) . '"]';
        }

        return $query;
    }

    public function processResponse(array $response): array
    {
        if (isset($response[0])) {
            return array_map(function ($item) {
                $item[ProcessResponse::ADDITIONAL_FIELD] = [
                    'openTimeDate' => Carbon::getFullDate($item['openTime']),
                    'closeTimeDate' => Carbon::getFullDate($item['closeTime']),
                ];

                return $item;
            }, $response);
        }

        $response[ProcessResponse::ADDITIONAL_FIELD] = [
            'openTimeDate' => Carbon::getFullDate($response['openTime']),
            'closeTimeDate' => Carbon::getFullDate($response['closeTime']),
        ];

        return $response;
    }

    public static function exampleResponse(): string
    {
        return json_encode([
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
        ]);
    }
}
