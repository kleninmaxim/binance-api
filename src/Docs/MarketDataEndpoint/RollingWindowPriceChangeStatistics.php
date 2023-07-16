<?php

namespace BinanceApi\Docs\MarketDataEndpoint;

use BinanceApi\Docs\Const\BinanceApi\Endpoint;
use BinanceApi\Docs\Const\BinanceApi\HasQueryParameters;
use BinanceApi\Docs\Const\BinanceApi\ProcessResponse;
use BinanceApi\Docs\Const\Exception\EndpointQueryException;
use BinanceApi\Docs\Const\Response;
use BinanceApi\Docs\GeneralInfo\Const\BanBased;
use BinanceApi\Docs\GeneralInfo\Const\HttpMethod;
use BinanceApi\Docs\GeneralInfo\DataSources;
use BinanceApi\Docs\GeneralInfo\EndpointSecurityType;
use BinanceApi\Helper\Carbon;

/**
 * https://binance-docs.github.io/apidocs/spot/en/#rolling-window-price-change-statistics
 *
 * Rolling window price change statistics
 */
readonly class RollingWindowPriceChangeStatistics implements Endpoint, HasQueryParameters, ProcessResponse
{
    public const METHOD = 'ticker';

    public function __construct(
        public string $endpoint = '/api/v3/ticker',
        public string $httpMethod = HttpMethod::GET,
        public null|int $weight = 2,
        public string $weightBased = BanBased::IP,
        public string $dataSource = DataSources::DATABASE,
        public null|string $encryption = null,
        public string $endpointType = EndpointSecurityType::NONE,
        public string $title = 'Rolling window price change statistics',
        public string $description = 'Note: This endpoint is different from the GET /api/v3/ticker/24hr endpoint.',
        public string $version = 'v3',
        public bool $isSapi = false,
    ) {
    }

    public function getQuery(
        null|string $symbol = null,
        null|array $symbols = null,
        string $windowSize = '1d',
        string $type = 'FULL'
    ): array {
        $query = ['windowSize' => $windowSize, 'type' => $type];

        if (!$symbol && !$symbols) {
            throw new EndpointQueryException('Symbol or Symbols is mandatory parameter: https://binance-docs.github.io/apidocs/spot/en/#rolling-window-price-change-statistics');
        }

        if ($symbol) {
            $query['symbol'] = $symbol;
        }

        if ($symbols) {
            $query['symbols'] = '["'.implode('","', $symbols).'"]';
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

    public static function exampleResponse(): array
    {
        return [
            'firstVersion' => json_encode([
                'symbol' => 'BNBBTC',
                'priceChange' => '-8.00000000',
                'priceChangePercent' => '-88.889',
                'weightedAvgPrice' => '2.60427807',
                'openPrice' => '9.00000000',
                'highPrice' => '9.00000000',
                'lowPrice' => '1.00000000',
                'lastPrice' => '1.00000000',
                'volume' => '187.00000000',
                'quoteVolume' => '487.00000000',
                'openTime' => 1641859200000,
                'closeTime' => 1642031999999,
                'firstId' => 0,
                'lastId' => 60,
                'count' => 61,
            ]),
            'secondVersion' => json_encode([
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
                ],
            ]),
        ];
    }
}
