<?php

namespace BinanceApi\Docs\SpotAccountTrade;

use BinanceApi\Docs\Const\BinanceApi\Endpoint;
use BinanceApi\Docs\Const\BinanceApi\HasQueryParameters;
use BinanceApi\Docs\GeneralInfo\Const\BanBased;
use BinanceApi\Docs\GeneralInfo\Const\HttpMethod;
use BinanceApi\Docs\GeneralInfo\DataSources;
use BinanceApi\Docs\GeneralInfo\EndpointSecurityType;
use BinanceApi\Docs\GeneralInfo\Signed;
use BinanceApi\Exception\BinanceException;

/**
 * https://binance-docs.github.io/apidocs/spot/en/#query-current-order-count-usage-trade
 *
 * Query Current Order Count Usage
 */
readonly class QueryCurrentOrderCountUsage implements Endpoint, HasQueryParameters
{
    public const METHOD = 'rateLimitOrder';

    public function __construct(
        public string $endpoint = '/api/v3/rateLimit/order',
        public string $httpMethod = HttpMethod::GET,
        public null|int $weight = 20,
        public string $weightBased = BanBased::IP,
        public null|string $dataSource = DataSources::MEMORY,
        public null|string $encryption = Signed::SIGNED_SIGNATURE_ALGO,
        public string $endpointType = EndpointSecurityType::TRADE,
        public string $title = 'Query Current Order Count Usage',
        public string $description = 'Displays the user\'s current order count usage for all intervals.',
    ) {
    }

    public function getQuery(null|string $recvWindow = null): array
    {
        if (! is_null($recvWindow)) {
            $query['recvWindow'] = $recvWindow;
        }

        return $query ?? [];
    }

    public static function exampleResponse(): string
    {
        return json_encode([
            [
                'rateLimitType' => 'ORDERS',
                'interval' => 'SECOND',
                'intervalNum' => 10,
                'limit' => 10000,
                'count' => 0,
            ],
            [
                'rateLimitType' => 'ORDERS',
                'interval' => 'DAY',
                'intervalNum' => 1,
                'limit' => 20000,
                'count' => 0,
            ]
        ]);
    }
}
