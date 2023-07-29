<?php

namespace BinanceApi\Docs\WalletEndpoints;

use BinanceApi\Docs\Const\BinanceApi\Endpoint;
use BinanceApi\Docs\Const\BinanceApi\HasBodyParameters;
use BinanceApi\Docs\GeneralInfo\Const\BanBased;
use BinanceApi\Docs\GeneralInfo\Const\HttpMethod;
use BinanceApi\Docs\GeneralInfo\EndpointSecurityType;
use BinanceApi\Docs\GeneralInfo\Signed;

/**
 * https://binance-docs.github.io/apidocs/spot/en/#enable-fast-withdraw-switch-user_data
 *
 * Enable Fast Withdraw Switch
 */
readonly class EnableFastWithdrawSwitch implements Endpoint, HasBodyParameters
{
    public const METHOD = 'accountEnableFastWithdrawSwitch';

    public function __construct(
        public string $endpoint = '/sapi/v1/account/enableFastWithdrawSwitch',
        public string $httpMethod = HttpMethod::POST,
        public null|int $weight = 1,
        public string $weightBased = BanBased::IP,
        public null|string $dataSource = null,
        public null|string $encryption = Signed::SIGNED_SIGNATURE_ALGO,
        public string $endpointType = EndpointSecurityType::USER_DATA,
        public string $title = 'Enable Fast Withdraw Switch',
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
