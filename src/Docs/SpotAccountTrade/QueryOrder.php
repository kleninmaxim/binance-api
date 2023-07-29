<?php

namespace BinanceApi\Docs\SpotAccountTrade;

use BinanceApi\Docs\Const\BinanceApi\Endpoint;
use BinanceApi\Docs\Const\BinanceApi\HasQueryParameters;
use BinanceApi\Docs\Const\BinanceApi\ProcessResponse;
use BinanceApi\Docs\GeneralInfo\Const\BanBased;
use BinanceApi\Docs\GeneralInfo\Const\HttpMethod;
use BinanceApi\Docs\GeneralInfo\DataSources;
use BinanceApi\Docs\GeneralInfo\EndpointSecurityType;
use BinanceApi\Docs\GeneralInfo\Signed;
use BinanceApi\Exception\BinanceException;
use BinanceApi\Helper\Carbon;

/**
 * https://binance-docs.github.io/apidocs/spot/en/#query-order-user_data
 *
 * Query Order
 */
readonly class QueryOrder implements Endpoint, HasQueryParameters, ProcessResponse
{
    public const METHOD = 'getOrder';

    public function __construct(
        public string $endpoint = '/api/v3/order',
        public string $httpMethod = HttpMethod::GET,
        public null|int $weight = 2,
        public string $weightBased = BanBased::IP,
        public null|string $dataSource = DataSources::MEMORY_TO_DATABASE,
        public null|string $encryption = Signed::SIGNED_SIGNATURE_ALGO,
        public string $endpointType = EndpointSecurityType::USER_DATA,
        public string $title = 'Query Order',
        public string $description = 'Check an order\'s status.',
    ) {
    }

    public function getQuery(
        null|string $symbol = null,
        null|string $orderId = null,
        null|string $origClientOrderId = null,
        null|string $recvWindow = null
    ): array {
        if (! $symbol) {
            throw new BinanceException('symbol are mandatory parameters, see: https://binance-docs.github.io/apidocs/spot/en/#query-order-user_data');
        }

        $query = ['symbol' => $symbol];

        if (! is_null($orderId)) {
            $query['orderId'] = $orderId;
        }

        if (! is_null($origClientOrderId)) {
            $query['origClientOrderId'] = $origClientOrderId;
        }

        if (! is_null($recvWindow)) {
            $query['recvWindow'] = $recvWindow;
        }

        return $query ?? [];
    }

    public function processResponse(array $response): array
    {
        if (isset($response['time'])) {
            $response[ProcessResponse::ADDITIONAL_FIELD]['timeDate'] = Carbon::getFullDate($response['time']);
        }

        if (isset($response['updateTime'])) {
            $response[ProcessResponse::ADDITIONAL_FIELD]['updateTimeDate'] = Carbon::getFullDate($response['updateTime']);
        }

        if (isset($response['workingTime'])) {
            $response[ProcessResponse::ADDITIONAL_FIELD]['workingTimeDate'] = Carbon::getFullDate($response['workingTime']);
        }

        return $response;
    }

    public static function exampleResponse(): string
    {
        return json_encode([
            'symbol' => 'LTCBTC',
            'orderId' => 1,
            'orderListId' => -1,
            'clientOrderId' => 'myOrder1',
            'price' => '0.1',
            'origQty' => '1.0',
            'executedQty' => '0.0',
            'cummulativeQuoteQty' => '0.0',
            'status' => 'NEW',
            'timeInForce' => 'GTC',
            'type' => 'LIMIT',
            'side' => 'BUY',
            'stopPrice' => '0.0',
            'icebergQty' => '0.0',
            'time' => 1499827319559,
            'updateTime' => 1499827319559,
            'isWorking' => true,
            'workingTime' => 1499827319559,
            'origQuoteOrderQty' => '0.000000',
            'selfTradePreventionMode' => 'NONE',
        ]);
    }
}
