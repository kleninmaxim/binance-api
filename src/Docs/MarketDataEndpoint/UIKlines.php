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
 * https://binance-docs.github.io/apidocs/spot/en/#uiklines
 *
 * UIKlines
 */
readonly class UIKlines implements Endpoint, HasQueryParameters, ProcessResponse
{
    public const METHOD = 'uiKlines';

    public function __construct(
        public string $endpoint = '/api/v3/uiKlines',
        public string $httpMethod = HttpMethod::GET,
        public null|int $weight = 1,
        public string $weightBased = BanBased::IP,
        public null|string $dataSource = DataSources::DATABASE,
        public null|string $encryption = null,
        public string $endpointType = EndpointSecurityType::NONE,
        public string $title = 'UIKlines',
        public string $description = 'The request is similar to klines having the same parameters and response.'."\n".'uiKlines return modified kline data, optimized for presentation of candlestick charts.',
    ) {
    }

    public function getQuery(
        null|string $symbol = null,
        null|string $interval = null,
        null|string $startTime = null,
        null|string $endTime = null,
        int $limit = 500
    ): array {
        if (! $symbol) {
            throw new EndpointQueryException('Symbol is mandatory parameter: https://binance-docs.github.io/apidocs/spot/en/#uiklines');
        }

        if (! $interval) {
            throw new EndpointQueryException('Interval is mandatory parameter: https://binance-docs.github.io/apidocs/spot/en/#uiklines');
        }

        if ($limit < 1) {
            $limit = 1;
        } elseif ($limit > 1000) {
            $limit = 1000;
        }

        $query = ['symbol' => $symbol, 'interval' => $interval, 'limit' => $limit];

        if ($startTime) {
            $query['startTime'] = $startTime;
        }

        if ($endTime) {
            $query['endTime'] = $endTime;
        }

        return $query;
    }

    public function processResponse(array $response): array
    {
        return array_map(function ($item) {
            return [
                'klineOpenTime' => $item[0],
                'openPrice' => $item[1],
                'highPrice' => $item[2],
                'lowPrice' => $item[3],
                'closePrice' => $item[4],
                'volume' => $item[5],
                'klineCloseTime' => $item[6],
                'quoteAssetVolume' => $item[7],
                'numberOfTrades' => $item[8],
                'takerBuyBaseAssetVolume' => $item[9],
                'takerBuyQuoteAssetVolume' => $item[10],
                'unusedField' => $item[11],
                ProcessResponse::ADDITIONAL_FIELD => [
                    'klineOpenTimeDate' => Carbon::getFullDate($item[0]),
                    'klineCloseTimeDate' => Carbon::getFullDate($item[6]),
                ],
            ];
        }, $response);
    }

    public static function exampleResponse(): string
    {
        return json_encode([
            [
                1499040000000,
                '0.01634790',
                '0.80000000',
                '0.01575800',
                '0.01577100',
                '148976.11427815',
                1499644799999,
                '2434.19055334',
                308,
                '1756.87402397',
                '28.46694368',
                '0',
            ]
        ]);
    }
}
