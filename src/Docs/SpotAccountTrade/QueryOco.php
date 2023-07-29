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
 * https://binance-docs.github.io/apidocs/spot/en/#query-oco-user_data
 *
 * Query OCO
 */
readonly class QueryOco implements Endpoint, HasQueryParameters
{
    public const METHOD = 'orderList';

    public function __construct(
        public string $endpoint = '/api/v3/orderList',
        public string $httpMethod = HttpMethod::GET,
        public null|int $weight = 2,
        public string $weightBased = BanBased::IP,
        public null|string $dataSource = DataSources::DATABASE,
        public null|string $encryption = Signed::SIGNED_SIGNATURE_ALGO,
        public string $endpointType = EndpointSecurityType::USER_DATA,
        public string $title = 'Query OCO',
        public string $description = 'Retrieves a specific OCO based on provided optional parameters',
    ) {
    }

    public function getQuery(
        null|string $orderListId = null,
        null|string $origClientOrderId = null,
        null|string $recvWindow = null
    ): array {
        if (! is_null($orderListId)) {
            $query['orderListId'] = $orderListId;
        }

        if (! is_null($origClientOrderId)) {
            $query['origClientOrderId'] = $origClientOrderId;
        }

        if (! is_null($recvWindow)) {
            $query['recvWindow'] = $recvWindow;
        }

        return $query ?? [];
    }

    public static function exampleResponse(): string
    {
        return json_encode([
            'orderListId' => 27,
            'contingencyType' => 'OCO',
            'listStatusType' => 'EXEC_STARTED',
            'listOrderStatus' => 'EXECUTING',
            'listClientOrderId' => 'h2USkA5YQpaXHPIrkd96xE',
            'transactionTime' => 1565245656253,
            'symbol' => 'LTCBTC',
            'orders' => [
                [
                    'symbol' => 'LTCBTC',
                    'orderId' => 4,
                    'clientOrderId' => 'qD1gy3kc3Gx0rihm9Y3xwS',
                ],
                [
                    'symbol' => 'LTCBTC',
                    'orderId' => 5,
                    'clientOrderId' => 'ARzZ9I00CPM8i3NhmU9Ega',
                ],
            ],
        ]);
    }
}
