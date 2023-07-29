<?php

namespace BinanceApi\Docs\WalletEndpoints;

use BinanceApi\Docs\Const\BinanceApi\Endpoint;
use BinanceApi\Docs\GeneralInfo\Const\BanBased;
use BinanceApi\Docs\GeneralInfo\Const\HttpMethod;
use BinanceApi\Docs\GeneralInfo\EndpointSecurityType;

/**
 * https://binance-docs.github.io/apidocs/spot/en/#system-status-system
 *
 * System Status (System)
 */
readonly class SystemStatus implements Endpoint
{
    public const METHOD = 'systemStatus';

    public function __construct(
        public string $endpoint = '/sapi/v1/system/status',
        public string $httpMethod = HttpMethod::GET,
        public null|int $weight = 1,
        public string $weightBased = BanBased::IP,
        public null|string $dataSource = null,
        public null|string $encryption = null,
        public string $endpointType = EndpointSecurityType::NONE,
        public string $title = 'System Status (System)',
        public string $description = 'Fetch system status.',
    ) {
    }

    public static function exampleResponse(): string
    {
        return json_encode([
            'status' => 0,
            'msg' => 'normal',
        ]);
    }
}
