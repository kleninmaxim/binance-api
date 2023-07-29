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
 * https://binance-docs.github.io/apidocs/spot/en/#all-orders-user_data
 *
 * All Orders
 */
readonly class AllOrders implements Endpoint, HasQueryParameters, ProcessResponse
{
    public const METHOD = 'allOrders';

    public function __construct(
        public string $endpoint = '/api/v3/allOrders',
        public string $httpMethod = HttpMethod::GET,
        public null|int $weight = 10,
        public string $weightBased = BanBased::IP,
        public null|string $dataSource = DataSources::DATABASE,
        public null|string $encryption = Signed::SIGNED_SIGNATURE_ALGO,
        public string $endpointType = EndpointSecurityType::USER_DATA,
        public string $title = 'All Orders',
        public string $description = 'Get all account orders; active, canceled, or filled.',
    ) {
    }

    public function getQuery(
        null|string $symbol = null,
        null|string $orderId = null,
        null|string $startTime = null,
        null|string $endTime = null,
        int $limit = 500,
        null|string $recvWindow = null
    ): array {
        if (! $symbol) {
            throw new BinanceException('symbol are mandatory parameters, see: https://binance-docs.github.io/apidocs/spot/en/#all-orders-user_data');
        }

        $query = ['symbol' => $symbol, 'limit' => $limit];

        if (! is_null($orderId)) {
            $query['orderId'] = $orderId;
        }

        if (! is_null($startTime)) {
            $query['startTime'] = $startTime;
        }

        if (! is_null($endTime)) {
            $query['endTime'] = $endTime;
        }

        if (! is_null($recvWindow)) {
            $query['recvWindow'] = $recvWindow;
        }

        return $query ?? [];
    }

    public function processResponse(array $response): array
    {
        return array_map(function ($item) {
            if (isset($item['time'])) {
                $item[ProcessResponse::ADDITIONAL_FIELD]['timeDate'] = Carbon::getFullDate($item['time']);
            }

            if (isset($item['updateTime'])) {
                $item[ProcessResponse::ADDITIONAL_FIELD]['updateTimeDate'] = Carbon::getFullDate($item['updateTime']);
            }

            if (isset($item['workingTime'])) {
                $item[ProcessResponse::ADDITIONAL_FIELD]['workingTimeDate'] = Carbon::getFullDate($item['workingTime']);
            }

            return $item;
        }, $response);
    }

    public static function exampleResponse(): string
    {
        return json_encode([
            [
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
            ]
        ]);
    }
}
