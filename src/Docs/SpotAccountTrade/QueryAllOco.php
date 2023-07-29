<?php

namespace BinanceApi\Docs\SpotAccountTrade;

use BinanceApi\Docs\Const\BinanceApi\Endpoint;
use BinanceApi\Docs\Const\BinanceApi\HasQueryParameters;
use BinanceApi\Docs\GeneralInfo\Const\BanBased;
use BinanceApi\Docs\GeneralInfo\Const\HttpMethod;
use BinanceApi\Docs\GeneralInfo\DataSources;
use BinanceApi\Docs\GeneralInfo\EndpointSecurityType;
use BinanceApi\Docs\GeneralInfo\Signed;

/**
 * https://binance-docs.github.io/apidocs/spot/en/#query-all-oco-user_data
 *
 * Query all OCO
 */
readonly class QueryAllOco implements Endpoint, HasQueryParameters
{
    public const METHOD = 'allOrderList';

    public function __construct(
        public string $endpoint = '/api/v3/allOrderList',
        public string $httpMethod = HttpMethod::GET,
        public null|int $weight = 10,
        public string $weightBased = BanBased::IP,
        public null|string $dataSource = DataSources::DATABASE,
        public null|string $encryption = Signed::SIGNED_SIGNATURE_ALGO,
        public string $endpointType = EndpointSecurityType::USER_DATA,
        public string $title = 'Query all OCO',
        public string $description = 'Retrieves all OCO based on provided optional parameters',
    ) {
    }

    public function getQuery(
        null|string $fromId = null,
        null|string $startTime = null,
        null|string $endTime = null,
        int $limit = 500,
        null|string $recvWindow = null
    ): array {
        if (! is_null($fromId)) {
            $query['fromId'] = $fromId;
        }

        if (! is_null($startTime)) {
            $query['startTime'] = $startTime;
        }

        if (! is_null($endTime)) {
            $query['endTime'] = $endTime;
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
                'orderListId' => 29,
                'contingencyType' => 'OCO',
                'listStatusType' => 'EXEC_STARTED',
                'listOrderStatus' => 'EXECUTING',
                'listClientOrderId' => 'amEEAXryFzFwYF1FeRpUoZ',
                'transactionTime' => 1565245913483,
                'symbol' => 'LTCBTC',
                'orders' => [
                    [
                        'symbol' => 'LTCBTC',
                        'orderId' => 4,
                        'clientOrderId' => 'oD7aesZqjEGlZrbtRpy5zB',
                    ],
                    [
                        'symbol' => 'LTCBTC',
                        'orderId' => 5,
                        'clientOrderId' => 'Jr1h6xirOxgeJOUuYQS7V3',
                    ],
                ],
            ],
            [
                'orderListId' => 28,
                'contingencyType' => 'OCO',
                'listStatusType' => 'EXEC_STARTED',
                'listOrderStatus' => 'EXECUTING',
                'listClientOrderId' => 'hG7hFNxJV6cZy3Ze4AUT4d',
                'transactionTime' => 1565245913407,
                'symbol' => 'LTCBTC',
                'orders' => [
                    [
                        'symbol' => 'LTCBTC',
                        'orderId' => 2,
                        'clientOrderId' => 'j6lFOfbmFMRjTYA7rRJ0LP',
                    ],
                    [
                        'symbol' => 'LTCBTC',
                        'orderId' => 3,
                        'clientOrderId' => 'z0KCjOdditiLS5ekAFtK81',
                    ],
                ],
            ]
        ]);
    }
}
