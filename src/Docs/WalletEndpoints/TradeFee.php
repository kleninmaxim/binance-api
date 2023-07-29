<?php

namespace BinanceApi\Docs\WalletEndpoints;

use BinanceApi\Docs\Const\BinanceApi\Endpoint;
use BinanceApi\Docs\Const\BinanceApi\HasQueryParameters;
use BinanceApi\Docs\Const\BinanceApi\ProcessResponse;
use BinanceApi\Docs\GeneralInfo\Const\BanBased;
use BinanceApi\Docs\GeneralInfo\Const\HttpMethod;
use BinanceApi\Docs\GeneralInfo\EndpointSecurityType;
use BinanceApi\Docs\GeneralInfo\Signed;
use BinanceApi\Exception\BinanceException;
use BinanceApi\Helper\Carbon;

/**
 * https://binance-docs.github.io/apidocs/spot/en/#trade-fee-user_data
 *
 * Trade Fee
 */
readonly class TradeFee implements Endpoint, HasQueryParameters
{
    public const METHOD = 'assetTradeFee';

    public function __construct(
        public string $endpoint = '/sapi/v1/asset/tradeFee',
        public string $httpMethod = HttpMethod::GET,
        public null|int $weight = 1,
        public string $weightBased = BanBased::IP,
        public null|string $dataSource = null,
        public null|string $encryption = Signed::SIGNED_SIGNATURE_ALGO,
        public string $endpointType = EndpointSecurityType::USER_DATA,
        public string $title = 'Trade Fee ',
        public string $description = 'Fetch trade fee',
    ) {
    }

    public function getQuery(null|string $symbol = null, null|string $recvWindow = null): array
    {
        if (! is_null($symbol)) {
            $query['symbol'] = $symbol;
        }

        if (! is_null($recvWindow)) {
            $query['recvWindow'] = $recvWindow;
        }

        return $query ?? [];
    }

    public static function exampleResponse(): string
    {
        return json_encode([
            [
                'symbol' => 'ADABNB',
                'makerCommission' => 0.001,
                'takerCommission' => 0.001,
            ],
            [
                'symbol' => 'BNBBTC',
                'makerCommission' => 0.001,
                'takerCommission' => 0.001,
            ],
        ]);
    }
}
