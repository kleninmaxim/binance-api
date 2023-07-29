<?php

namespace BinanceApi\Docs\SpotAccountTrade;

use BinanceApi\Docs\Const\BinanceApi\Endpoint;
use BinanceApi\Docs\Const\BinanceApi\HasBodyParameters;
use BinanceApi\Docs\GeneralInfo\Const\BanBased;
use BinanceApi\Docs\GeneralInfo\Const\HttpMethod;
use BinanceApi\Docs\GeneralInfo\DataSources;
use BinanceApi\Docs\GeneralInfo\EndpointSecurityType;
use BinanceApi\Docs\GeneralInfo\Signed;
use BinanceApi\Exception\BinanceException;

/**
 * https://binance-docs.github.io/apidocs/spot/en/#new-oco-trade
 *
 * New OCO
 */
readonly class NewOco implements Endpoint, HasBodyParameters
{
    public const METHOD = 'orderOco';

    public function __construct(
        public string $endpoint = '/api/v3/order/oco',
        public string $httpMethod = HttpMethod::POST,
        public null|int $weight = 2,
        public string $weightBased = BanBased::UID,
        public null|string $dataSource = DataSources::MACHINE_ENGINE,
        public null|string $encryption = Signed::SIGNED_SIGNATURE_ALGO,
        public string $endpointType = EndpointSecurityType::TRADE,
        public string $title = 'New OCO',
        public string $description = 'Send in a new OCO',
    ) {
    }

    public function getBody(
        null|string $symbol = null,
        null|string $listClientOrderId = null,
        null|string $side = null,
        null|string $quantity = null,
        null|string $limitClientOrderId = null,
        null|string $limitStrategyId = null,
        null|string $limitStrategyType = null,
        null|string $price = null,
        null|string $limitIcebergQty = null,
        null|string $trailingDelta = null,
        null|string $stopClientOrderId = null,
        null|string $stopPrice = null,
        null|string $stopStrategyId = null,
        null|string $stopStrategyType = null,
        null|string $stopLimitPrice = null,
        null|string $stopIcebergQty = null,
        null|string $stopLimitTimeInForce = null,
        null|string $newOrderRespType = null,
        null|string $selfTradePreventionMode = null,
        null|string $recvWindow = null
    ): array {
        if (! $symbol && ! $side && ! $quantity && ! $price && ! $stopPrice) {
            throw new BinanceException('symbol, side, quantity, price, stopPrice are mandatory parameters, see: https://binance-docs.github.io/apidocs/spot/en/#new-oco-trade');
        }

        $query = ['symbol' => $symbol, 'side' => $side, 'quantity' => $quantity, 'price' => $price, 'stopPrice' => $stopPrice];

        if (! is_null($listClientOrderId)) {
            $query['listClientOrderId'] = $listClientOrderId;
        }

        if (! is_null($side)) {
            $query['side'] = $side;
        }

        if (! is_null($quantity)) {
            $query['quantity'] = $quantity;
        }

        if (! is_null($limitClientOrderId)) {
            $query['limitClientOrderId'] = $limitClientOrderId;
        }

        if (! is_null($limitStrategyId)) {
            $query['limitStrategyId'] = $limitStrategyId;
        }

        if (! is_null($limitStrategyType)) {
            $query['limitStrategyType'] = $limitStrategyType;
        }

        if (! is_null($price)) {
            $query['price'] = $price;
        }

        if (! is_null($limitIcebergQty)) {
            $query['limitIcebergQty'] = $limitIcebergQty;
        }

        if (! is_null($trailingDelta)) {
            $query['trailingDelta'] = $trailingDelta;
        }

        if (! is_null($stopClientOrderId)) {
            $query['stopClientOrderId'] = $stopClientOrderId;
        }

        if (! is_null($stopPrice)) {
            $query['stopPrice'] = $stopPrice;
        }

        if (! is_null($stopStrategyId)) {
            $query['stopStrategyId'] = $stopStrategyId;
        }

        if (! is_null($stopStrategyType)) {
            $query['stopStrategyType'] = $stopStrategyType;
        }

        if (! is_null($stopLimitPrice)) {
            $query['stopLimitPrice'] = $stopLimitPrice;
        }

        if (! is_null($stopIcebergQty)) {
            $query['stopIcebergQty'] = $stopIcebergQty;
        }

        if (! is_null($stopLimitTimeInForce)) {
            $query['stopLimitTimeInForce'] = $stopLimitTimeInForce;
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
        return json_encode([
            'orderListId' => 0,
            'contingencyType' => 'OCO',
            'listStatusType' => 'EXEC_STARTED',
            'listOrderStatus' => 'EXECUTING',
            'listClientOrderId' => 'JYVpp3F0f5CAG15DhtrqLp',
            'transactionTime' => 1563417480525,
            'symbol' => 'LTCBTC',
            'orders' => [
                [
                    'symbol' => 'LTCBTC',
                    'orderId' => 2,
                    'clientOrderId' => 'Kk7sqHb9J6mJWTMDVW7Vos',
                ],
                [
                    'symbol' => 'LTCBTC',
                    'orderId' => 3,
                    'clientOrderId' => 'xTXKaGYd4bluPVp78IVRvl',
                ],
            ],
            'orderReports' => [
                [
                    'symbol' => 'LTCBTC',
                    'orderId' => 2,
                    'orderListId' => 0,
                    'clientOrderId' => 'Kk7sqHb9J6mJWTMDVW7Vos',
                    'transactTime' => 1563417480525,
                    'price' => '0.00000000',
                    'origQty' => '0.624363',
                    'executedQty' => '0.000000',
                    'cummulativeQuoteQty' => '0.000000',
                    'status' => 'NEW',
                    'timeInForce' => 'GTC',
                    'type' => 'STOP_LOSS',
                    'side' => 'BUY',
                    'stopPrice' => '0.960664',
                    'workingTime' => 1563417480525,
                    'selfTradePreventionMode' => 'NONE',
                ],
                [
                    'symbol' => 'LTCBTC',
                    'orderId' => 3,
                    'orderListId' => 0,
                    'clientOrderId' => 'xTXKaGYd4bluPVp78IVRvl',
                    'transactTime' => 1563417480525,
                    'price' => '0.036435',
                    'origQty' => '0.624363',
                    'executedQty' => '0.000000',
                    'cummulativeQuoteQty' => '0.000000',
                    'status' => 'NEW',
                    'timeInForce' => 'GTC',
                    'type' => 'LIMIT_MAKER',
                    'side' => 'BUY',
                    'workingTime' => 1563417480525,
                    'selfTradePreventionMode' => 'NONE',
                ]
            ]
        ]);
    }
}
