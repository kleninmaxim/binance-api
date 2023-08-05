<?php

namespace BinanceApi\Spot\Docs\WalletEndpoints;

use BinanceApi\Spot\Docs\Const\BinanceApi\Endpoint;
use BinanceApi\Spot\Docs\Const\BinanceApi\HasBodyParameters;
use BinanceApi\Spot\Docs\GeneralInfo\Const\BanBased;
use BinanceApi\Spot\Docs\GeneralInfo\Const\HttpMethod;
use BinanceApi\Spot\Docs\GeneralInfo\EndpointSecurityType;
use BinanceApi\Spot\Docs\GeneralInfo\Signed;

/**
 * https://binance-docs.github.io/apidocs/spot/en/#switch-on-off-busd-and-stable-coins-conversion-user_data
 *
 * Switch on/off BUSD and stable coins conversion
 */
readonly class SwitchOnOffBusdAndStableCoinsConversion implements Endpoint, HasBodyParameters
{
    public const METHOD = 'switchCapitalContractConvertibleCoins';

    public function __construct(
        public string $endpoint = '/sapi/v1/capital/contract/convertible-coins',
        public string $httpMethod = HttpMethod::POST,
        public null|int $weight = 600,
        public string $weightBased = BanBased::UID,
        public null|string $dataSource = null,
        public null|string $encryption = Signed::SIGNED_SIGNATURE_ALGO,
        public string $endpointType = EndpointSecurityType::USER_DATA,
        public string $title = 'Switch on/off BUSD and stable coins conversion ',
        public string $description = 'User can use it to turn on or turn off the BUSD auto-conversion from/to a specific stable coin.',
    ) {
    }

    public function getBody(null|string $coin = null, null|bool|string $enable = null): array
    {
        return ['coin' => $coin, 'enable' => $enable];
    }

    public static function exampleResponse(): null|string
    {
        return null;
    }
}
