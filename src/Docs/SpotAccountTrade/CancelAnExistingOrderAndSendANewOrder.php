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
 * https://binance-docs.github.io/apidocs/spot/en/#cancel-an-existing-order-and-send-a-new-order-trade
 *
 * Cancel an Existing Order and Send a New Order
 */
readonly class CancelAnExistingOrderAndSendANewOrder implements Endpoint, HasBodyParameters, ProcessResponse
{
    public const METHOD = 'orderCancelReplace';

    public function __construct(
        public string $endpoint = '/api/v3/order/cancelReplace',
        public string $httpMethod = HttpMethod::POST,
        public null|int $weight = 1,
        public string $weightBased = BanBased::IP,
        public null|string $dataSource = DataSources::MACHINE_ENGINE,
        public null|string $encryption = Signed::SIGNED_SIGNATURE_ALGO,
        public string $endpointType = EndpointSecurityType::TRADE,
        public string $title = 'Cancel an Existing Order and Send a New Order',
        public string $description = 'Cancels an existing order and places a new order on the same symbol.',
    ) {
    }

    public function getBody(
        null|string $symbol = null,
        null|string $side = null,
        null|string $type = null,
        null|string $cancelReplaceMode = null,
        null|string $timeInForce = null,
        null|string $quantity = null,
        null|string $quoteOrderQty = null,
        null|string $price = null,
        null|string $cancelNewClientOrderId = null,
        null|string $cancelOrigClientOrderId = null,
        null|string $cancelOrderId = null,
        null|string $newClientOrderId = null,
        null|string $strategyId = null,
        null|string $strategyType = null,
        null|string $stopPrice = null,
        null|string $trailingDelta = null,
        null|string $icebergQty = null,
        null|string $newOrderRespType = null,
        null|string $selfTradePreventionMode = null,
        null|string $cancelRestrictions = null,
        null|string $recvWindow = null
    ): array {
        if (! $symbol && ! $side && ! $type && ! $cancelReplaceMode) {
            throw new BinanceException('symbol, side, type, cancelReplaceMode are mandatory parameters, see: https://binance-docs.github.io/apidocs/spot/en/#cancel-an-existing-order-and-send-a-new-order-trade');
        }

        $query = ['symbol' => $symbol, 'side' => $side, 'type' => $type, 'cancelReplaceMode' => $cancelReplaceMode];

        if (! is_null($timeInForce)) {
            $query['timeInForce'] = $timeInForce;
        }

        if (! is_null($quantity)) {
            $query['quantity'] = $quantity;
        }

        if (! is_null($quoteOrderQty)) {
            $query['quoteOrderQty'] = $quoteOrderQty;
        }

        if (! is_null($price)) {
            $query['price'] = $price;
        }

        if (! is_null($cancelNewClientOrderId)) {
            $query['cancelNewClientOrderId'] = $cancelNewClientOrderId;
        }

        if (! is_null($cancelOrigClientOrderId)) {
            $query['cancelOrigClientOrderId'] = $cancelOrigClientOrderId;
        }

        if (! is_null($cancelOrderId)) {
            $query['cancelOrderId'] = $cancelOrderId;
        }

        if (! is_null($newClientOrderId)) {
            $query['newClientOrderId'] = $newClientOrderId;
        }

        if (! is_null($strategyId)) {
            $query['strategyId'] = $strategyId;
        }

        if (! is_null($strategyType)) {
            $query['strategyType'] = $strategyType;
        }

        if (! is_null($stopPrice)) {
            $query['stopPrice'] = $stopPrice;
        }

        if (! is_null($trailingDelta)) {
            $query['trailingDelta'] = $trailingDelta;
        }

        if (! is_null($icebergQty)) {
            $query['icebergQty'] = $icebergQty;
        }

        if (! is_null($newOrderRespType)) {
            $query['newOrderRespType'] = $newOrderRespType;
        }

        if (! is_null($selfTradePreventionMode)) {
            $query['selfTradePreventionMode'] = $selfTradePreventionMode;
        }

        if (! is_null($cancelRestrictions)) {
            $query['cancelRestrictions'] = $cancelRestrictions;
        }

        if (! is_null($recvWindow)) {
            $query['recvWindow'] = $recvWindow;
        }

        return $query ?? [];
    }

    public function processResponse(array $response): array
    {
        if (isset($response['cancelResponse']['transactTime'])) {
            $response['cancelResponse'][ProcessResponse::ADDITIONAL_FIELD]['transactTimeDate'] = Carbon::getFullDate($response['cancelResponse']['transactTime']);
        }

        if (isset($response['newOrderResponse']['transactTime'])) {
            $response['newOrderResponse'][ProcessResponse::ADDITIONAL_FIELD]['transactTimeDate'] = Carbon::getFullDate($response['newOrderResponse']['transactTime']);
        }

        if (isset($response['newOrderResponse']['workingTime'])) {
            $response['newOrderResponse'][ProcessResponse::ADDITIONAL_FIELD]['workingTimeDate'] = Carbon::getFullDate($response['newOrderResponse']['workingTime']);
        }

        return $response;
    }

    public static function exampleResponse(): array
    {
        return [
            'firstVersion' => json_encode([
                'cancelResult' => 'SUCCESS',
                'newOrderResult' => 'SUCCESS',
                'cancelResponse' => [
                    'symbol' => 'BTCUSDT',
                    'origClientOrderId' => 'DnLo3vTAQcjha43lAZhZ0y',
                    'orderId' => 9,
                    'orderListId' => -1,
                    'clientOrderId' => 'osxN3JXAtJvKvCqGeMWMVR',
                    'transactTime' => 1684804350068,
                    'price' => '0.01000000',
                    'origQty' => '0.000100',
                    'executedQty' => '0.00000000',
                    'cummulativeQuoteQty' => '0.00000000',
                    'status' => 'CANCELED',
                    'timeInForce' => 'GTC',
                    'type' => 'LIMIT',
                    'side' => 'SELL',
                    'selfTradePreventionMode' => 'NONE',
                ],
                'newOrderResponse' => [
                    'symbol' => 'BTCUSDT',
                    'orderId' => 10,
                    'orderListId' => -1,
                    'clientOrderId' => 'wOceeeOzNORyLiQfw7jd8S',
                    'transactTime' => 1652928801803,
                    'price' => '0.02000000',
                    'origQty' => '0.040000',
                    'executedQty' => '0.00000000',
                    'cummulativeQuoteQty' => '0.00000000',
                    'status' => 'NEW',
                    'timeInForce' => 'GTC',
                    'type' => 'LIMIT',
                    'side' => 'BUY',
                    'workingTime' => 1669277163808,
                    'fills' => [],
                    'selfTradePreventionMode' => 'NONE',
                ],
            ]),
            'secondVersion' => [
                'code' => -2022,
                'msg' => 'Order cancel-replace failed.',
                'data' => [
                    'cancelResult' => 'FAILURE',
                    'newOrderResult' => 'NOT_ATTEMPTED',
                    'cancelResponse' => [
                        'code' => -2011,
                        'msg' => 'Unknown order sent.',
                    ],
                    'newOrderResponse' => null,
                ],
            ],
            'thirdVersion' => [
                'code' => -2021,
                'msg' => 'Order cancel-replace partially failed.',
                'data' => [
                    'cancelResult' => 'SUCCESS',
                    'newOrderResult' => 'FAILURE',
                    'cancelResponse' => [
                        'symbol' => 'BTCUSDT',
                        'origClientOrderId' => '86M8erehfExV8z2RC8Zo8k',
                        'orderId' => 3,
                        'orderListId' => -1,
                        'clientOrderId' => 'G1kLo6aDv2KGNTFcjfTSFq',
                        'transactTime' => 1684804350068,
                        'price' => '0.006123',
                        'origQty' => '10000.000000',
                        'executedQty' => '0.000000',
                        'cummulativeQuoteQty' => '0.000000',
                        'status' => 'CANCELED',
                        'timeInForce' => 'GTC',
                        'type' => 'LIMIT_MAKER',
                        'side' => 'SELL',
                        'selfTradePreventionMode' => 'NONE',
                    ],
                    'newOrderResponse' => [
                        'code' => -2010,
                        'msg' => 'Order would immediately match and take.'
                    ],
                ],
            ],
            'fourthVersion' => [
                'code' => -2021,
                'msg' => 'Order cancel-replace partially failed.',
                'data' => [
                    'cancelResult' => 'FAILURE',
                    'newOrderResult' => 'SUCCESS',
                    'cancelResponse' => [
                        'code' => -2011,
                        'msg' => 'Unknown order sent.',
                    ],
                    'newOrderResponse' => [
                        'symbol' => 'BTCUSDT',
                        'orderId' => 11,
                        'orderListId' => -1,
                        'clientOrderId' => 'pfojJMg6IMNDKuJqDxvoxN',
                        'transactTime' => 1648540168818,
                    ],
                ],
            ],
            'fifthVersion' => [
                'code' => -2022,
                'msg' => 'Order cancel-replace failed.',
                'data' => [
                    'cancelResult' => 'FAILURE',
                    'newOrderResult' => 'FAILURE',
                    'cancelResponse' => [
                        'code' => -2011,
                        'msg' => 'Unknown order sent.',
                    ],
                    'newOrderResponse' => [
                        'code' => -2010,
                        'msg' => 'Order would immediately match and take.',
                    ],
                ],
            ]
        ];
    }
}
