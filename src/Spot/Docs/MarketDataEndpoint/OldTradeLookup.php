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
 * https://binance-docs.github.io/apidocs/spot/en/#old-trade-lookup-market_data
 *
 * Old Trade Lookup
 */
readonly class OldTradeLookup implements Endpoint, HasQueryParameters, ProcessResponse
{
    public const METHOD = 'historicalTrades';

    public function __construct(
        public string $endpoint = '/api/v3/historicalTrades',
        public string $httpMethod = HttpMethod::GET,
        public null|int $weight = 5,
        public string $weightBased = BanBased::IP,
        public null|string $dataSource = DataSources::DATABASE,
        public null|string $encryption = null,
        public string $endpointType = EndpointSecurityType::MARKET_DATA,
        public string $title = 'Old Trade Lookup',
        public string $description = 'Get older market trades.',
    ) {
    }

    /**
     * @throws EndpointQueryException
     */
    public function getQuery(null|string $symbol = '', int $limit = 500, null|string $fromId = null): array
    {
        if (! $symbol) {
            throw new EndpointQueryException('Symbol is mandatory parameter: https://binance-docs.github.io/apidocs/spot/en/#old-trade-lookup-market_data');
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

        return $query;
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
