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
 * https://binance-docs.github.io/apidocs/spot/en/#cancel-order-trade
 *
 * Cancel Order
 */
readonly class CancelOrder implements Endpoint, HasBodyParameters, ProcessResponse
{
    public const METHOD = 'cancelOrder';

    public function __construct(
        public string $endpoint = '/api/v3/order',
        public string $httpMethod = HttpMethod::DELETE,
        public null|int $weight = 1,
        public string $weightBased = BanBased::IP,
        public null|string $dataSource = DataSources::MACHINE_ENGINE,
        public null|string $encryption = Signed::SIGNED_SIGNATURE_ALGO,
        public string $endpointType = EndpointSecurityType::TRADE,
        public string $title = 'Cancel Order',
        public string $description = 'Cancel an active order.',
    ) {
    }

    public function getBody(
        null|string $symbol = null,
        null|string $orderId = null,
        null|string $origClientOrderId = null,
        null|string $newClientOrderId = null,
        null|string $cancelRestrictions = null,
        null|string $recvWindow = null,
    ): array {
        if (! $symbol) {
            throw new BinanceException('symbol are mandatory parameters, see: https://binance-docs.github.io/apidocs/spot/en/#cancel-order-trade');
        }

        $query = ['symbol' => $symbol];

        if (! is_null($orderId)) {
            $query['orderId'] = $orderId;
        }

        if (! is_null($origClientOrderId)) {
            $query['origClientOrderId'] = $origClientOrderId;
        }

        if (! is_null($newClientOrderId)) {
            $query['newClientOrderId'] = $newClientOrderId;
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
        $response[ProcessResponse::ADDITIONAL_FIELD]['transactTimeDate'] = Carbon::getFullDate($response['transactTime']);

        return $response;
    }

    public static function exampleResponse(): string
    {
        return json_encode([
            'symbol' => 'LTCBTC',
            'origClientOrderId' => 'myOrder1',
            'orderId' => 4,
            'orderListId' => -1,
            'clientOrderId' => 'cancelMyOrder1',
            'transactTime' => 1684804350068,
            'price' => '2.00000000',
            'origQty' => '1.00000000',
            'executedQty' => '0.00000000',
            'cummulativeQuoteQty' => '0.00000000',
            'status' => 'CANCELED',
            'timeInForce' => 'GTC',
            'type' => 'LIMIT',
            'side' => 'BUY',
            'selfTradePreventionMode' => 'NONE',
        ]);
    }
}
