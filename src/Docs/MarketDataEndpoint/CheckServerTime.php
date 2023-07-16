<?php

namespace BinanceApi\Docs\MarketDataEndpoint;

use BinanceApi\Docs\Const\BinanceApi\Endpoint;
use BinanceApi\Docs\Const\BinanceApi\ProcessResponse;
use BinanceApi\Docs\GeneralInfo\Const\BanBased;
use BinanceApi\Docs\GeneralInfo\Const\HttpMethod;
use BinanceApi\Docs\GeneralInfo\DataSources;
use BinanceApi\Docs\GeneralInfo\EndpointSecurityType;
use BinanceApi\Helper\Carbon;

/**
 * https://binance-docs.github.io/apidocs/spot/en/#check-server-time
 *
 * Check Server Time
 */
readonly class CheckServerTime implements Endpoint, ProcessResponse
{
    public const METHOD = 'time';

    public function __construct(
        public string $endpoint = '/api/v3/time',
        public string $httpMethod = HttpMethod::GET,
        public null|int $weight = 1,
        public string $weightBased = BanBased::IP,
        public string $dataSource = DataSources::MEMORY,
        public null|string $encryption = null,
        public string $endpointType = EndpointSecurityType::NONE,
        public string $title = 'Check Server Time',
        public string $description = 'Test connectivity to the Rest API and get the current server time.',
        public string $version = 'v3',
        public bool $isSapi = false,
    ) {
    }

    public function processResponse(array $response): array
    {
        return [
            'serverTime' => $response['serverTime'],
            ProcessResponse::ADDITIONAL_FIELD => [
                'serverTimeDate' => Carbon::getFullDate($response['serverTime']),
            ],
        ];
    }

    public static function exampleResponse(): string
    {
        return json_encode(['serverTime' => 1499827319559]);
    }
}
