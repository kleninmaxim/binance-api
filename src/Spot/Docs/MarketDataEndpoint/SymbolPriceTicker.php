<?php

namespace BinanceApi\Spot\Docs\MarketDataEndpoint;

use BinanceApi\Spot\Docs\Const\BinanceApi\Endpoint;
use BinanceApi\Spot\Docs\Const\BinanceApi\HasQueryParameters;
use BinanceApi\Spot\Docs\GeneralInfo\Const\BanBased;
use BinanceApi\Spot\Docs\GeneralInfo\Const\HttpMethod;
use BinanceApi\Spot\Docs\GeneralInfo\DataSources;
use BinanceApi\Spot\Docs\GeneralInfo\EndpointSecurityType;

/**
 * https://binance-docs.github.io/apidocs/spot/en/#symbol-price-ticker
 *
 * Symbol Price Ticker
 */
readonly class SymbolPriceTicker implements Endpoint, HasQueryParameters
{
    public const METHOD = 'tickerPrice';

    public function __construct(
        public string $endpoint = '/api/v3/ticker/price',
        public string $httpMethod = HttpMethod::GET,
        public null|int $weight = 2,
        public string $weightBased = BanBased::IP,
        public null|string $dataSource = DataSources::MEMORY,
        public null|string $encryption = null,
        public string $endpointType = EndpointSecurityType::NONE,
        public string $title = 'Symbol Price Ticker',
        public string $description = 'Latest price for a symbol or symbols.',
    ) {
    }

    public function getQuery(null|string $symbol = null, null|array $symbols = null): array
    {
        $query = [];

        if ($symbol) {
            $query['symbol'] = $symbol;
        }

        if ($symbols) {
            $query['symbols'] = '["' . implode('","', $symbols) . '"]';
        }

        return $query;
    }

    public static function exampleResponse(): array
    {
        return [
            'firstVersion' => json_encode([
                'symbol' => 'LTCBTC',
                'price' => '4.00000200',
            ]),
            'secondVersion' => json_encode([
                [
                    'symbol' => 'LTCBTC',
                    'price' => '4.00000200',
                ],
                [
                    'symbol' => 'ETHBTC',
                    'price' => '0.07946600',
                ],
            ]),
        ];
    }
}
