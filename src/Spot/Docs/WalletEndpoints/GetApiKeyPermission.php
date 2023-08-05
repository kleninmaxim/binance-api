<?php

namespace BinanceApi\Spot\Docs\WalletEndpoints;

use BinanceApi\Helper\Carbon;
use BinanceApi\Spot\Docs\Const\BinanceApi\Endpoint;
use BinanceApi\Spot\Docs\Const\BinanceApi\HasQueryParameters;
use BinanceApi\Spot\Docs\Const\BinanceApi\ProcessResponse;
use BinanceApi\Spot\Docs\GeneralInfo\Const\BanBased;
use BinanceApi\Spot\Docs\GeneralInfo\Const\HttpMethod;
use BinanceApi\Spot\Docs\GeneralInfo\EndpointSecurityType;
use BinanceApi\Spot\Docs\GeneralInfo\Signed;

/**
 * https://binance-docs.github.io/apidocs/spot/en/#get-api-key-permission-user_data
 *
 * Get API Key Permission
 */
readonly class GetApiKeyPermission implements Endpoint, HasQueryParameters, ProcessResponse
{
    public const METHOD = 'accountApiRestrictions';

    public function __construct(
        public string $endpoint = '/sapi/v1/account/apiRestrictions',
        public string $httpMethod = HttpMethod::GET,
        public null|int $weight = 1,
        public string $weightBased = BanBased::IP,
        public null|string $dataSource = null,
        public null|string $encryption = Signed::SIGNED_SIGNATURE_ALGO,
        public string $endpointType = EndpointSecurityType::USER_DATA,
        public string $title = 'Get API Key Permission',
        public string $description = '',
    ) {
    }

    public function getQuery(null|string $recvWindow = null): array
    {
        return ! is_null($recvWindow) ? ['recvWindow' => $recvWindow] : [];
    }

    public function processResponse(array $response): array
    {
        $response[ProcessResponse::ADDITIONAL_FIELD]['createTimeDate'] = Carbon::getFullDate($response['createTime']);

        if (isset($response['tradingAuthorityExpirationTime']) && is_int($response['tradingAuthorityExpirationTime'])) {
            $response[ProcessResponse::ADDITIONAL_FIELD]['tradingAuthorityExpirationTimeDate'] = Carbon::getFullDate($response['tradingAuthorityExpirationTime']);
        }

        return $response;
    }

    public static function exampleResponse(): string
    {
        return json_encode([
            'ipRestrict' => false,
            'createTime' => 1623840271000,
            'enableWithdrawals' => false,
            'enableInternalTransfer' => true,
            'permitsUniversalTransfer' => true,
            'enableVanillaOptions' => false,
            'enableReading' => true,
            'enableFutures' => false,
            'enableMargin' => false,
            'enableSpotAndMarginTrading' => false,
            'tradingAuthorityExpirationTime' => 1628985600000,
        ]);
    }
}
