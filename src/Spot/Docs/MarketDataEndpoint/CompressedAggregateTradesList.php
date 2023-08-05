<?php

namespace BinanceApi\Spot\Docs\MarketDataEndpoint;

use BinanceApi\Helper\Carbon;
use BinanceApi\Spot\Docs\Const\BinanceApi\Endpoint;
use BinanceApi\Spot\Docs\Const\BinanceApi\HasQueryParameters;
use BinanceApi\Spot\Docs\Const\BinanceApi\ProcessResponse;
use BinanceApi\Spot\Docs\Const\Exception\EndpointQueryException;
use BinanceApi\Spot\Docs\GeneralInfo\Const\BanBased;
use BinanceApi\Spot\Docs\GeneralInfo\Const\HttpMethod;
use BinanceApi\Spot\Docs\GeneralInfo\DataSources;
use BinanceApi\Spot\Docs\GeneralInfo\EndpointSecurityType;

/**
 * https://binance-docs.github.io/apidocs/spot/en/#compressed-aggregate-trades-list
 *
 * Compressed/Aggregate Trades List
 */
readonly class CompressedAggregateTradesList implements Endpoint, HasQueryParameters, ProcessResponse
{
    public const METHOD = 'aggTrades';

    public function __construct(
        public string $endpoint = '/api/v3/aggTrades',
        public string $httpMethod = HttpMethod::GET,
        public null|int $weight = 1,
        public string $weightBased = BanBased::IP,
        public null|string $dataSource = DataSources::DATABASE,
        public null|string $encryption = null,
        public string $endpointType = EndpointSecurityType::NONE,
        public string $title = 'Compressed/Aggregate Trades List',
        public string $description = 'Get compressed, aggregate trades. Trades that fill at the time, from the same order, with the same price will have the quantity aggregated.',
    ) {
    }

    public function getQuery(
        null|string $symbol = null,
        null|string $fromId = null,
        null|string $startTime = null,
        null|string $endTime = null,
        int $limit = 500
    ): array {
        if (! $symbol) {
            throw new EndpointQueryException('Symbol is mandatory parameter: https://binance-docs.github.io/apidocs/spot/en/#compressed-aggregate-trades-list');
        }

        if ($limit < 1) {
            $limit = 1;
        } elseif ($limit > 1000) {
            $limit = 1000;
        }

        $query = ['symbol' => $symbol, 'limit' => $limit];

        if ($fromId) {
            $query['fromId'] = $fromId;
        }

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
                'aggregateTradeId' => $item['a'],
                'price' => $item['p'],
                'quantity' => $item['q'],
                'firstTradeId' => $item['f'],
                'lastTradeId' => $item['l'],
                'timestamp' => $item['T'],
                'wasTheBuyerTheMaker' => $item['m'],
                'wasTheTradeTheBestPriceMatch' => $item['M'],
                ProcessResponse::ADDITIONAL_FIELD => [
                    'timestampDate' => Carbon::getFullDate($item['T']),
                ],
            ];
        }, $response);
    }

    public static function exampleResponse(): string
    {
        return json_encode([
            [
                'a' => 26129,
                'p' => "0.01633102",
                'q' => "4.70443515",
                'f' => 27781,
                'l' => 27781,
                'T' => 1498793709153,
                'm' => true,
                'M' => true,
            ]
        ]);
    }
}
