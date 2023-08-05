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
 * https://binance-docs.github.io/apidocs/spot/en/#account-trade-list-user_data
 *
 * Account Trade List
 */
readonly class AccountTradeList implements Endpoint, HasQueryParameters
{
    public const METHOD = 'myTrades';

    public function __construct(
        public string $endpoint = '/api/v3/myTrades',
        public string $httpMethod = HttpMethod::GET,
        public null|int $weight = 10,
        public string $weightBased = BanBased::IP,
        public null|string $dataSource = DataSources::MEMORY_TO_DATABASE,
        public null|string $encryption = Signed::SIGNED_SIGNATURE_ALGO,
        public string $endpointType = EndpointSecurityType::USER_DATA,
        public string $title = 'Account Trade List',
        public string $description = 'Get trades for a specific account and symbol.',
    ) {
    }

    public function getQuery(
        null|string $symbol = null,
        null|string $orderId = null,
        null|string $startTime = null,
        null|string $endTime = null,
        null|string $fromId = null,
        int $limit = 500,
        null|string $recvWindow = null,
    ): array {
        if (! $symbol) {
            throw new BinanceException('symbol are mandatory parameters, see: https://binance-docs.github.io/apidocs/spot/en/#account-trade-list-user_data');
        }

        $query = ['symbol' => $symbol];

        if (! is_null($orderId)) {
            $query['orderId'] = $orderId;
        }

        if (! is_null($startTime)) {
            $query['startTime'] = $startTime;
        }

        if (! is_null($endTime)) {
            $query['endTime'] = $endTime;
        }

        if (! is_null($fromId)) {
            $query['fromId'] = $fromId;
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
                'symbol' => 'BNBBTC',
                'id' => 28457,
                'orderId' => 100234,
                'orderListId' => -1,
                'price' => '4.00000100',
                'qty' => '12.00000000',
                'quoteQty' => '48.000012',
                'commission' => '10.10000000',
                'commissionAsset' => 'BNB',
                'time' => 1499865549590,
                'isBuyer' => true,
                'isMaker' => false,
                'isBestMatch' => true,
            ]
        ]);
    }
}
