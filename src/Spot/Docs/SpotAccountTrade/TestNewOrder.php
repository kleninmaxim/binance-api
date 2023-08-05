<?php

namespace BinanceApi\Spot\Docs\SpotAccountTrade;

use BinanceApi\Exception\BinanceException;
use BinanceApi\Spot\Docs\Const\BinanceApi\Endpoint;
use BinanceApi\Spot\Docs\Const\BinanceApi\HasBodyParameters;
use BinanceApi\Spot\Docs\GeneralInfo\Const\BanBased;
use BinanceApi\Spot\Docs\GeneralInfo\Const\HttpMethod;
use BinanceApi\Spot\Docs\GeneralInfo\DataSources;
use BinanceApi\Spot\Docs\GeneralInfo\EndpointSecurityType;
use BinanceApi\Spot\Docs\GeneralInfo\Signed;

/**
 * https://binance-docs.github.io/apidocs/spot/en/#test-new-order-trade
 *
 * Test New Order
 */
readonly class TestNewOrder implements Endpoint, HasBodyParameters
{
    public const METHOD = 'orderTest';

    public function __construct(
        public string $endpoint = '/api/v3/order/test',
        public string $httpMethod = HttpMethod::POST,
        public null|int $weight = 1,
        public string $weightBased = BanBased::UID,
        public null|string $dataSource = DataSources::MEMORY,
        public null|string $encryption = Signed::SIGNED_SIGNATURE_ALGO,
        public string $endpointType = EndpointSecurityType::TRADE,
        public string $title = 'Test New Order',
        public string $description = 'Test new order creation and signature/recvWindow long. Creates and validates a new order but does not send it into the matching engine.',
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
            throw new BinanceException('symbol, side, type are mandatory parameters, see: https://binance-docs.github.io/apidocs/spot/en/#test-new-order-trade');
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

    public static function exampleResponse(): string
    {
        return json_encode([]);
    }
}
