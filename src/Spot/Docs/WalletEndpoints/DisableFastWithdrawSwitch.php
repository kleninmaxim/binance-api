<?php

namespace BinanceApi\Spot\Docs\WalletEndpoints;

use BinanceApi\Spot\Docs\Const\BinanceApi\Endpoint;
use BinanceApi\Spot\Docs\Const\BinanceApi\HasBodyParameters;
use BinanceApi\Spot\Docs\GeneralInfo\Const\BanBased;
use BinanceApi\Spot\Docs\GeneralInfo\Const\HttpMethod;
use BinanceApi\Spot\Docs\GeneralInfo\EndpointSecurityType;
use BinanceApi\Spot\Docs\GeneralInfo\Signed;

/**
 * https://binance-docs.github.io/apidocs/spot/en/#disable-fast-withdraw-switch-user_data
 *
 * Disable Fast Withdraw Switch
 */
readonly class DisableFastWithdrawSwitch implements Endpoint, HasBodyParameters
{
    public const METHOD = 'accountDisableFastWithdrawSwitch';

    public function __construct(
        public string $endpoint = '/sapi/v1/account/disableFastWithdrawSwitch',
        public string $httpMethod = HttpMethod::POST,
        public null|int $weight = 1,
        public string $weightBased = BanBased::IP,
        public null|string $dataSource = null,
        public null|string $encryption = Signed::SIGNED_SIGNATURE_ALGO,
        public string $endpointType = EndpointSecurityType::USER_DATA,
        public string $title = 'Disable Fast Withdraw Switch',
        public string $description = '',
    ) {
    }

    public function getBody(null|string $recvWindow = null): array
    {
        return ! is_null($recvWindow) ? ['recvWindow' => $recvWindow] : [];
    }

    public static function exampleResponse(): string
    {
        return json_encode([]);
    }
}
