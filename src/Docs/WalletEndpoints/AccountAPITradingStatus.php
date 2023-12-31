<?php

namespace BinanceApi\Docs\WalletEndpoints;

use BinanceApi\Docs\Const\BinanceApi\Endpoint;
use BinanceApi\Docs\Const\BinanceApi\HasQueryParameters;
use BinanceApi\Docs\Const\BinanceApi\ProcessResponse;
use BinanceApi\Docs\Const\Exception\EndpointQueryException;
use BinanceApi\Docs\GeneralInfo\Const\BanBased;
use BinanceApi\Docs\GeneralInfo\Const\HttpMethod;
use BinanceApi\Docs\GeneralInfo\EndpointSecurityType;
use BinanceApi\Docs\GeneralInfo\Signed;
use BinanceApi\Exception\BinanceException;
use BinanceApi\Helper\Carbon;

/**
 * https://binance-docs.github.io/apidocs/spot/en/#account-api-trading-status-user_data
 *
 * Account API Trading Status
 */
readonly class AccountAPITradingStatus implements Endpoint, HasQueryParameters, ProcessResponse
{
    public const METHOD = 'accountApiTradingStatus';

    public function __construct(
        public string $endpoint = '/sapi/v1/account/apiTradingStatus',
        public string $httpMethod = HttpMethod::GET,
        public null|int $weight = 1,
        public string $weightBased = BanBased::IP,
        public null|string $dataSource = null,
        public null|string $encryption = Signed::SIGNED_SIGNATURE_ALGO,
        public string $endpointType = EndpointSecurityType::USER_DATA,
        public string $title = 'Account API Trading Status',
        public string $description = 'Fetch account api trading status detail.',
    ) {
    }

    public function getQuery(null|string $recvWindow = null): array
    {
        return ! is_null($recvWindow) ? ['recvWindow' => $recvWindow] : [];
    }

    public function processResponse(array $response): array
    {
        $response['data'][ProcessResponse::ADDITIONAL_FIELD]['updateTimeDate'] = Carbon::getFullDate($response['data']['updateTime']);

        return $response;
    }

    public static function exampleResponse(): string
    {
        return json_encode([
            'data' => [
                'isLocked' => false,
                'plannedRecoverTime' => 0,
                'triggerCondition' => [
                    'GCR' => 150,
                    'IFER' => 150,
                    'UFR' => 300,
                ],
                'updateTime' => 1547630471725,
            ],
        ]);
    }
}
