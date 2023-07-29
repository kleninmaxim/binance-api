<?php

namespace BinanceApi\Docs\SpotAccountTrade;

use BinanceApi\Docs\Const\BinanceApi\Endpoint;
use BinanceApi\Docs\Const\BinanceApi\HasBodyParameters;
use BinanceApi\Docs\Const\BinanceApi\ProcessResponse;
use BinanceApi\Docs\GeneralInfo\Const\BanBased;
use BinanceApi\Docs\GeneralInfo\Const\HttpMethod;
use BinanceApi\Docs\GeneralInfo\DataSources;
use BinanceApi\Docs\GeneralInfo\EndpointSecurityType;
use BinanceApi\Docs\GeneralInfo\Signed;
use BinanceApi\Exception\BinanceException;
use BinanceApi\Helper\Carbon;

/**
 * https://binance-docs.github.io/apidocs/spot/en/#cancel-all-open-orders-on-a-symbol-trade
 *
 * Cancel all Open Orders on a Symbol
 */
readonly class CancelAllOpenOrdersOnASymbol implements Endpoint, HasBodyParameters, ProcessResponse
{
    public const METHOD = 'cancelOpenOrders';

    public function __construct(
        public string $endpoint = '/api/v3/openOrders',
        public string $httpMethod = HttpMethod::DELETE,
        public null|int $weight = 1,
        public string $weightBased = BanBased::IP,
        public null|string $dataSource = DataSources::MACHINE_ENGINE,
        public null|string $encryption = Signed::SIGNED_SIGNATURE_ALGO,
        public string $endpointType = EndpointSecurityType::TRADE,
        public string $title = 'Cancel all Open Orders on a Symbol',
        public string $description = 'This includes OCO orders.',
    ) {
    }

    public function getBody(null|string $symbol = null, null|string $recvWindow = null): array
    {
        if (! $symbol) {
            throw new BinanceException('symbol are mandatory parameters, see: https://binance-docs.github.io/apidocs/spot/en/#cancel-all-open-orders-on-a-symbol-trade');
        }

        $query = ['symbol' => $symbol];

        if (! is_null($recvWindow)) {
            $query['recvWindow'] = $recvWindow;
        }

        return $query ?? [];
    }


    public function processResponse(array $response): array
    {
        return array_map(function ($item) {
            if (isset($item['transactTime'])) {
                $item[ProcessResponse::ADDITIONAL_FIELD]['transactTimeDate'] = Carbon::getFullDate($item['transactTime']);
            }

            if (isset($item['transactionTime'])) {
                $item[ProcessResponse::ADDITIONAL_FIELD]['transactionTimeDate'] = Carbon::getFullDate($item['transactionTime']);
            }

            if (isset($item['orderReports'])) {
                $item['orderReports'] = array_map(function ($item) {
                    if (isset($item['transactTime'])) {
                        $item[ProcessResponse::ADDITIONAL_FIELD]['transactTimeDate'] = Carbon::getFullDate($item['transactTime']);
                    }

                    return $item;
                }, $item['orderReports']);
            }

            return $item;
        }, $response);
    }

    public static function exampleResponse(): string
    {
        return json_encode([
            [
                'symbol' => 'BTCUSDT',
                'origClientOrderId' => 'E6APeyTJvkMvLMYMqu1KQ4',
                'orderId' => 11,
                'orderListId' => -1,
                'clientOrderId' => 'pXLV6Hz6mprAcVYpVMTGgx',
                'transactTime' => 1684804350068,
                'price' => '0.089853',
                'origQty' => '0.178622',
                'executedQty' => '0.000000',
                'cummulativeQuoteQty' => '0.000000',
                'status' => 'CANCELED',
                'timeInForce' => 'GTC',
                'type' => 'LIMIT',
                'side' => 'BUY',
                'selfTradePreventionMode' => 'NONE',
            ],
            [
                'symbol' => 'BTCUSDT',
                'origClientOrderId' => 'A3EF2HCwxgZPFMrfwbgrhv',
                'orderId' => 13,
                'orderListId' => -1,
                'clientOrderId' => 'pXLV6Hz6mprAcVYpVMTGgx',
                'transactTime' => 1684804350069,
                'price' => '0.090430',
                'origQty' => '0.178622',
                'executedQty' => '0.000000',
                'cummulativeQuoteQty' => '0.000000',
                'status' => 'CANCELED',
                'timeInForce' => 'GTC',
                'type' => 'LIMIT',
                'side' => 'BUY',
                'selfTradePreventionMode' => 'NONE',
            ],
            [
                'orderListId' => 1929,
                'contingencyType' => 'OCO',
                'listStatusType' => 'ALL_DONE',
                'listOrderStatus' => 'ALL_DONE',
                'listClientOrderId' => '2inzWQdDvZLHbbAmAozX2N',
                'transactionTime' => 1585230948299,
                'symbol' => 'BTCUSDT',
                'orders' => [
                    [
                        'symbol' => 'BTCUSDT',
                        'orderId' => 20,
                        'clientOrderId' => 'CwOOIPHSmYywx6jZX77TdL',
                    ],
                    [
                        'symbol' => 'BTCUSDT',
                        'orderId' => 21,
                        'clientOrderId' => '461cPg51vQjV3zIMOXNz39',
                    ],
                ],
                'orderReports' => [
                    [
                        'symbol' => 'BTCUSDT',
                        'origClientOrderId' => 'CwOOIPHSmYywx6jZX77TdL',
                        'orderId' => 20,
                        'orderListId' => 1929,
                        'clientOrderId' => 'pXLV6Hz6mprAcVYpVMTGgx',
                        'transactTime' => 1688005070874,
                        'price' => '0.668611',
                        'origQty' => '0.690354',
                        'executedQty' => '0.000000',
                        'cummulativeQuoteQty' => '0.000000',
                        'status' => 'CANCELED',
                        'timeInForce' => 'GTC',
                        'type' => 'STOP_LOSS_LIMIT',
                        'side' => 'BUY',
                        'stopPrice' => '0.378131',
                        'icebergQty' => '0.017083',
                        'selfTradePreventionMode' => 'NONE',
                    ],
                    [
                        'symbol' => 'BTCUSDT',
                        'origClientOrderId' => '461cPg51vQjV3zIMOXNz39',
                        'orderId' => 21,
                        'orderListId' => 1929,
                        'clientOrderId' => 'pXLV6Hz6mprAcVYpVMTGgx',
                        'transactTime' => 1688005070874,
                        'price' => '0.008791',
                        'origQty' => '0.690354',
                        'executedQty' => '0.000000',
                        'cummulativeQuoteQty' => '0.000000',
                        'status' => 'CANCELED',
                        'timeInForce' => 'GTC',
                        'type' => 'LIMIT_MAKER',
                        'side' => 'BUY',
                        'icebergQty' => '0.017083',
                        'selfTradePreventionMode' => 'NONE',
                    ],
                ],
            ],
        ]);
    }
}
