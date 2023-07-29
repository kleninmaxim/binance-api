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
 * https://binance-docs.github.io/apidocs/spot/en/#new-order-trade
 *
 * New Order
 */
readonly class NewOrder implements Endpoint, HasBodyParameters, ProcessResponse
{
    public const METHOD = 'order';

    public function __construct(
        public string $endpoint = '/api/v3/order',
        public string $httpMethod = HttpMethod::POST,
        public null|int $weight = 1,
        public string $weightBased = BanBased::UID,
        public null|string $dataSource = DataSources::MACHINE_ENGINE,
        public null|string $encryption = Signed::SIGNED_SIGNATURE_ALGO,
        public string $endpointType = EndpointSecurityType::TRADE,
        public string $title = 'New Order',
        public string $description = 'Send in a new order.',
    ) {
    }

    public function getBody(
        null|string $symbol = null,
        null|string $side = null,
        null|string $type = null,
        null|string $timeInForce = null,
        null|string $quantity = null,
        null|string $quoteOrderQty = null,
        null|string $price = null,
        null|string $newClientOrderId = null,
        null|string $strategyId = null,
        null|string $strategyType = null,
        null|string $stopPrice = null,
        null|string $trailingDelta = null,
        null|string $icebergQty = null,
        null|string $newOrderRespType = 'FULL',
        null|string $selfTradePreventionMode = null,
        null|string $recvWindow = null,
    ): array {
        if (! $symbol || ! $side || ! $type) {
            throw new BinanceException('symbol, side, type are mandatory parameters, see: https://binance-docs.github.io/apidocs/spot/en/#new-order-trade');
        }

        $query = ['symbol' => $symbol, 'side' => $side, 'type' => $type];

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

        if (! is_null($recvWindow)) {
            $query['recvWindow'] = $recvWindow;
        }

        return $query ?? [];
    }

    public function processResponse(array $response): array
    {
        $response[ProcessResponse::ADDITIONAL_FIELD]['transactTimeDate'] = Carbon::getFullDate($response['transactTime']);

        if (isset($response['workingTime'])) {
            $response[ProcessResponse::ADDITIONAL_FIELD]['workingTimeDate'] = Carbon::getFullDate($response['workingTime']);
        }

        return $response;
    }

    public static function exampleResponse(): array
    {
        return [
            'firstVersion' => json_encode([
                'symbol' => 'BTCUSDT',
                'orderId' => 28,
                'orderListId' => -1,
                'clientOrderId' => '6gCrw2kRUAF9CvJDGP16IP',
                'transactTime' => 1507725176595,
            ]),
            'secondVersion' => json_encode([
                'symbol' => 'BTCUSDT',
                'orderId' => 28,
                'orderListId' => -1,
                'clientOrderId' => '6gCrw2kRUAF9CvJDGP16IP',
                'transactTime' => 1507725176595,
                'price' => '0.00000000',
                'origQty' => '10.00000000',
                'executedQty' => '10.00000000',
                'cummulativeQuoteQty' => '10.00000000',
                'status' => 'FILLED',
                'timeInForce' => 'GTC',
                'type' => 'MARKET',
                'side' => 'SELL',
                'workingTime' => 1507725176595,
                'selfTradePreventionMode' => 'NONE',
            ]),
            'thirdVersion' => json_encode([
                'symbol' => 'BTCUSDT',
                'orderId' => 28,
                'orderListId' => -1,
                'clientOrderId' => '6gCrw2kRUAF9CvJDGP16IP',
                'transactTime' => 1507725176595,
                'price' => '0.00000000',
                'origQty' => '10.00000000',
                'executedQty' => '10.00000000',
                'cummulativeQuoteQty' => '10.00000000',
                'status' => 'FILLED',
                'timeInForce' => 'GTC',
                'type' => 'MARKET',
                'side' => 'SELL',
                'workingTime' => 1507725176595,
                'selfTradePreventionMode' => 'NONE',
                'fills' => [
                    [
                        'price' => '4000.00000000',
                        'qty' => '1.00000000',
                        'commission' => '4.00000000',
                        'commissionAsset' => 'USDT',
                        'tradeId' => 56,
                    ],
                    [
                        'price' => '3999.00000000',
                        'qty' => '5.00000000',
                        'commission' => '19.99500000',
                        'commissionAsset' => 'USDT',
                        'tradeId' => 57,
                    ],
                    [
                        'price' => '3998.00000000',
                        'qty' => '2.00000000',
                        'commission' => '7.99600000',
                        'commissionAsset' => 'USDT',
                        'tradeId' => 58,
                    ],
                    [
                        'price' => '3997.00000000',
                        'qty' => '1.00000000',
                        'commission' => '3.99700000',
                        'commissionAsset' => 'USDT',
                        'tradeId' => 59,
                    ],
                    [
                        'price' => '3995.00000000',
                        'qty' => '1.00000000',
                        'commission' => '3.99500000',
                        'commissionAsset' => 'USDT',
                        'tradeId' => 60,
                    ],
                ],
            ]),
        ];
    }
}
