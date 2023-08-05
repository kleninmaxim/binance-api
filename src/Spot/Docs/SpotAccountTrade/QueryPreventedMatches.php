<?php

namespace BinanceApi\Spot\Docs\SpotAccountTrade;

use BinanceApi\Exception\BinanceException;
use BinanceApi\Spot\Docs\Const\BinanceApi\Endpoint;
use BinanceApi\Spot\Docs\Const\BinanceApi\HasQueryParameters;
use BinanceApi\Spot\Docs\GeneralInfo\Const\BanBased;
use BinanceApi\Spot\Docs\GeneralInfo\Const\HttpMethod;
use BinanceApi\Spot\Docs\GeneralInfo\DataSources;
use BinanceApi\Spot\Docs\GeneralInfo\EndpointSecurityType;
use BinanceApi\Spot\Docs\GeneralInfo\Signed;

/**
 * https://binance-docs.github.io/apidocs/spot/en/#query-prevented-matches-user_data
 *
 * Query Prevented Matches
 */
readonly class QueryPreventedMatches implements Endpoint, HasQueryParameters
{
    public const METHOD = 'myPreventedMatches';

    public function __construct(
        public string $endpoint = '/api/v3/myPreventedMatches',
        public string $httpMethod = HttpMethod::GET,
        public null|int $weight = 10,
        public string $weightBased = BanBased::IP,
        public null|string $dataSource = DataSources::DATABASE,
        public null|string $encryption = Signed::SIGNED_SIGNATURE_ALGO,
        public string $endpointType = EndpointSecurityType::USER_DATA,
        public string $title = 'Query Prevented Matches',
        public string $description = 'Displays the list of orders that were expired because of STP.',
    ) {
    }

    public function getQuery(
        null|string $symbol = null,
        null|string $preventedMatchId = null,
        null|string $orderId = null,
        null|string $fromPreventedMatchId = null,
        int $limit = 500,
        null|string $recvWindow = null
    ): array {
        if (! $symbol) {
            throw new BinanceException('symbol are mandatory parameters, see: https://binance-docs.github.io/apidocs/spot/en/#query-prevented-matches-user_data');
        }

        $query = ['symbol' => $symbol];

        if (! is_null($preventedMatchId)) {
            $query['preventedMatchId'] = $preventedMatchId;
        }

        if (! is_null($orderId)) {
            $query['orderId'] = $orderId;
        }

        if (! is_null($fromPreventedMatchId)) {
            $query['fromPreventedMatchId'] = $fromPreventedMatchId;
        }

        if (! is_null($limit)) {
            $query['limit'] = $limit;
        }

        if (! is_null($recvWindow)) {
            $query['recvWindow'] = $recvWindow;
        }

        return $query ?? [];
    }

    public static function exampleResponse(): string
    {
        return json_encode([
            [
                'symbol' => 'BTCUSDT',
                'preventedMatchId' => 1,
                'takerOrderId' => 5,
                'makerOrderId' => 3,
                'tradeGroupId' => 1,
                'selfTradePreventionMode' => 'EXPIRE_MAKER',
                'price' => '1.100000',
                'makerPreventedQuantity' => '1.300000',
                'transactTime' => 1669101687094,
            ],
        ]);
    }
}
