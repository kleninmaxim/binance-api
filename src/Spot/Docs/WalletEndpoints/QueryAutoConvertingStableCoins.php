<?php

namespace BinanceApi\Spot\Docs\WalletEndpoints;

use BinanceApi\Spot\Docs\Const\BinanceApi\Endpoint;
use BinanceApi\Spot\Docs\GeneralInfo\Const\BanBased;
use BinanceApi\Spot\Docs\GeneralInfo\Const\HttpMethod;
use BinanceApi\Spot\Docs\GeneralInfo\EndpointSecurityType;
use BinanceApi\Spot\Docs\GeneralInfo\Signed;

/**
 * https://binance-docs.github.io/apidocs/spot/en/#query-auto-converting-stable-coins-user_data
 *
 * Query auto-converting stable coins
 */
readonly class QueryAutoConvertingStableCoins implements Endpoint
{
    public const METHOD = 'capitalContractConvertibleCoins';

    public function __construct(
        public string $endpoint = '/sapi/v1/capital/contract/convertible-coins',
        public string $httpMethod = HttpMethod::GET,
        public null|int $weight = 600,
        public string $weightBased = BanBased::IP,
        public null|string $dataSource = null,
        public null|string $encryption = Signed::SIGNED_SIGNATURE_ALGO,
        public string $endpointType = EndpointSecurityType::USER_DATA,
        public string $title = 'Query auto-converting stable coins ',
        public string $description = 'Get a user\'s auto-conversion settings in deposit/withdrawal',
    ) {
    }

    public static function exampleResponse(): string
    {
        return json_encode([
            'convertEnabled' => true,
            'coins' => [
                'USDC',
                'USDP',
                'TUSD',
            ],
            'exchangeRates' => [
                'USDC' => '1',
                'TUSD' => '1',
                'USDP' => '1',
            ],
        ]);
    }
}
