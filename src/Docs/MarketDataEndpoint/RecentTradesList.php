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
 * https://binance-docs.github.io/apidocs/spot/en/#recent-trades-list
 *
 * Recent Trades List
 */
readonly class RecentTradesList implements Endpoint, HasQueryParameters, ProcessResponse
{
    public const METHOD = 'trades';

    public function __construct(
        public string $endpoint = '/api/v3/trades',
        public string $httpMethod = HttpMethod::GET,
        public null|int $weight = 1,
        public string $weightBased = BanBased::IP,
        public null|string $dataSource = DataSources::MEMORY,
        public null|string $encryption = null,
        public string $endpointType = EndpointSecurityType::NONE,
        public string $title = 'Recent Trades List',
        public string $description = 'Get recent trades.',
    ) {
    }

    public function getQuery(null|string $symbol = null, int $limit = 500): array
    {
        if (! $symbol) {
            throw new EndpointQueryException('Symbol is mandatory parameter: https://binance-docs.github.io/apidocs/spot/en/#recent-trades-list');
        }

        if ($limit < 1) {
            $limit = 1;
        } elseif ($limit > 1000) {
            $limit = 1000;
        }

        return ['symbol' => $symbol, 'limit' => $limit];
    }

    public function processResponse(array $response): array
    {
        return array_map(function ($item) {
            $item[ProcessResponse::ADDITIONAL_FIELD]['timeDate'] = Carbon::getFullDate($item['time']);

            return $item;
        }, $response);
    }

    public static function exampleResponse(): string
    {
        return json_encode([
            [
                'id' => 28457,
                'price' => '4.00000100',
                'qty' => '12.00000000',
                'quoteQty' => '48.000012',
                'time' => 1499865549590,
                'isBuyerMaker' => true,
                'isBestMatch' => true
            ]
        ]);
    }
}
