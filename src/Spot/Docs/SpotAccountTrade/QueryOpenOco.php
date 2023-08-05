<?php

namespace BinanceApi\Spot\Docs\SpotAccountTrade;

use BinanceApi\Spot\Docs\Const\BinanceApi\Endpoint;
use BinanceApi\Spot\Docs\Const\BinanceApi\HasQueryParameters;
use BinanceApi\Spot\Docs\GeneralInfo\Const\BanBased;
use BinanceApi\Spot\Docs\GeneralInfo\Const\HttpMethod;
use BinanceApi\Spot\Docs\GeneralInfo\DataSources;
use BinanceApi\Spot\Docs\GeneralInfo\EndpointSecurityType;
use BinanceApi\Spot\Docs\GeneralInfo\Signed;

/**
 * https://binance-docs.github.io/apidocs/spot/en/#query-open-oco-user_data
 *
 * Query Open OCO
 */
readonly class QueryOpenOco implements Endpoint, HasQueryParameters
{
    public const METHOD = 'openOrderList';

    public function __construct(
        public string $endpoint = '/api/v3/openOrderList',
        public string $httpMethod = HttpMethod::GET,
        public null|int $weight = 3,
        public string $weightBased = BanBased::IP,
        public null|string $dataSource = DataSources::DATABASE,
        public null|string $encryption = Signed::SIGNED_SIGNATURE_ALGO,
        public string $endpointType = EndpointSecurityType::USER_DATA,
        public string $title = 'Query Open OCO',
        public string $description = 'Retrieves all OCO based on provided optional parameters',
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
                'orderListId' => 31,
                'contingencyType' => 'OCO',
                'listStatusType' => 'EXEC_STARTED',
                'listOrderStatus' => 'EXECUTING',
                'listClientOrderId' => 'wuB13fmulKj3YjdqWEcsnp',
                'transactionTime' => 1565246080644,
                'symbol' => 'LTCBTC',
                'orders' => [
                    [
                        'symbol' => 'LTCBTC',
                        'orderId' => 4,
                        'clientOrderId' => 'r3EH2N76dHfLoSZWIUw1bT',
                    ],
                    [
                        'symbol' => 'LTCBTC',
                        'orderId' => 5,
                        'clientOrderId' => 'Cv1SnyPD3qhqpbjpYEHbd2',
                    ],
                ],
            ]
        ]);
    }
}
