<?php

namespace BinanceApi\Docs\MarketDataEndpoint;

use BinanceApi\Docs\Const\BinanceApi\Endpoint;
use BinanceApi\Docs\Const\BinanceApi\HasQueryParameters;
use BinanceApi\Docs\Const\Exception\EndpointQueryException;
use BinanceApi\Docs\GeneralInfo\Const\BanBased;
use BinanceApi\Docs\GeneralInfo\Const\HttpMethod;
use BinanceApi\Docs\GeneralInfo\DataSources;
use BinanceApi\Docs\GeneralInfo\EndpointSecurityType;

/**
 * https://binance-docs.github.io/apidocs/spot/en/#current-average-price
 *
 * Current Average Price
 */
readonly class CurrentAveragePrice implements Endpoint, HasQueryParameters
{
    public const METHOD = 'avgPrice';

    public function __construct(
        public string $endpoint = '/api/v3/avgPrice',
        public string $httpMethod = HttpMethod::GET,
        public null|int $weight = 1,
        public string $weightBased = BanBased::IP,
        public null|string $dataSource = DataSources::MEMORY,
        public null|string $encryption = null,
        public string $endpointType = EndpointSecurityType::NONE,
        public string $title = 'Current Average Price',
        public string $description = 'Current average price for a symbol.',
    ) {
    }

    public function getQuery(null|string $symbol = null): array
    {
        if (! $symbol) {
            throw new EndpointQueryException('Symbol is mandatory parameter: https://binance-docs.github.io/apidocs/spot/en/#current-average-price');
        }

        return ['symbol' => $symbol];
    }

    public static function exampleResponse(): string
    {
        return json_encode([
            'mins' => 5,
            'price' => '9.35751834',
        ]);
    }
}
