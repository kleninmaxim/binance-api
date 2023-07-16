<?php

namespace BinanceApi\Docs\MarketDataEndpoint;

use BinanceApi\Docs\Const\BinanceApi\Endpoint;
use BinanceApi\Docs\GeneralInfo\Const\BanBased;
use BinanceApi\Docs\GeneralInfo\Const\HttpMethod;
use BinanceApi\Docs\GeneralInfo\DataSources;
use BinanceApi\Docs\GeneralInfo\EndpointSecurityType;

/**
 * https://binance-docs.github.io/apidocs/spot/en/#market-data-endpoints
 *
 * Test Connectivity
 */
readonly class TestConnectivity implements Endpoint
{
    public const METHOD = 'ping';

    public function __construct(
        public string $endpoint = '/api/v3/ping',
        public string $httpMethod = HttpMethod::GET,
        public null|int $weight = 1,
        public string $weightBased = BanBased::IP,
        public string $dataSource = DataSources::MEMORY,
        public null|string $encryption = null,
        public string $endpointType = EndpointSecurityType::NONE,
        public string $title = 'Test Connectivity',
        public string $description = 'Test connectivity to the Rest API.',
        public string $version = 'v3',
        public bool $isSapi = false,
    ) {
    }

    public static function exampleResponse(): string
    {
        return json_encode([]);
    }
}
