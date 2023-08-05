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
 * https://binance-docs.github.io/apidocs/spot/en/#cancel-oco-trade
 *
 * Cancel OCO
 */
readonly class CancelOco implements Endpoint, HasBodyParameters
{
    public const METHOD = 'cancelOrderList';

    public function __construct(
        public string $endpoint = '/api/v3/orderList',
        public string $httpMethod = HttpMethod::DELETE,
        public null|int $weight = 1,
        public string $weightBased = BanBased::IP,
        public null|string $dataSource = DataSources::MACHINE_ENGINE,
        public null|string $encryption = Signed::SIGNED_SIGNATURE_ALGO,
        public string $endpointType = EndpointSecurityType::TRADE,
        public string $title = 'Cancel OCO',
        public string $description = 'Cancel an entire Order List.',
    ) {
    }

    public function getBody(
        null|string $symbol = null,
        null|string $orderListId = null,
        null|string $listClientOrderId = null,
        null|string $newClientOrderId = null,
        null|string $recvWindow = null
    ): array {
        if (! $symbol) {
            throw new BinanceException('symbol are mandatory parameters, see: https://binance-docs.github.io/apidocs/spot/en/#cancel-oco-trade');
        }

        $query = ['symbol' => $symbol];

        if (! is_null($orderListId)) {
            $query['orderListId'] = $orderListId;
        }

        if (! is_null($listClientOrderId)) {
            $query['listClientOrderId'] = $listClientOrderId;
        }

        if (! is_null($newClientOrderId)) {
            $query['newClientOrderId'] = $newClientOrderId;
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
            'listStatusType' => 'ALL_DONE',
            'listOrderStatus' => 'ALL_DONE',
            'listClientOrderId' => 'C3wyj4WVEktd7u9aVBRXcN',
            'transactionTime' => 1574040868128,
            'symbol' => 'LTCBTC',
            'orders' => [
                [
                    'symbol' => 'LTCBTC',
                    'orderId' => 2,
                    'clientOrderId' => 'pO9ufTiFGg3nw2fOdgeOXa',
                ],
                [
                    'symbol' => 'LTCBTC',
                    'orderId' => 3,
                    'clientOrderId' => 'TXOvglzXuaubXAaENpaRCB',
                ],
            ],
            'orderReports' => [
                [
                    'symbol' => 'LTCBTC',
                    'orderId' => 2,
                    'orderListId' => 0,
                    'clientOrderId' => 'unfWT8ig8i0uj6lPuYLez6',
                    'transactTime' => 1688005070874,
                    'price' => '1.00000000',
                    'origQty' => '10.00000000',
                    'executedQty' => '0.00000000',
                    'cummulativeQuoteQty' => '0.00000000',
                    'status' => 'CANCELED',
                    'timeInForce' => 'GTC',
                    'type' => 'STOP_LOSS_LIMIT',
                    'side' => 'SELL',
                    'stopPrice' => '1.00000000',
                    'selfTradePreventionMode' => 'NONE',
                ],
                [
                    'symbol' => 'LTCBTC',
                    'origClientOrderId' => 'TXOvglzXuaubXAaENpaRCB',
                    'orderId' => 3,
                    'orderListId' => 0,
                    'clientOrderId' => 'unfWT8ig8i0uj6lPuYLez6',
                    'transactTime' => 1688005070874,
                    'price' => '3.00000000',
                    'origQty' => '10.00000000',
                    'executedQty' => '0.000000',
                    'cummulativeQuoteQty' => '0.000000',
                    'status' => 'CANCELED',
                    'timeInForce' => 'GTC',
                    'type' => 'LIMIT_MAKER',
                    'side' => 'SELL',
                    'workingTime' => 1563417480525,
                    'selfTradePreventionMode' => 'NONE',
                ]
            ]
        ]);
    }
}
