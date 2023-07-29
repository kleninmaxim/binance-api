<?php

namespace BinanceApi\Docs\WalletEndpoints;

use BinanceApi\Docs\Const\BinanceApi\Endpoint;
use BinanceApi\Docs\Const\BinanceApi\HasBodyParameters;
use BinanceApi\Docs\GeneralInfo\Const\BanBased;
use BinanceApi\Docs\GeneralInfo\Const\HttpMethod;
use BinanceApi\Docs\GeneralInfo\EndpointSecurityType;
use BinanceApi\Docs\GeneralInfo\Signed;

/**
 * https://binance-docs.github.io/apidocs/spot/en/#one-click-arrival-deposit-apply-for-expired-address-deposit-user_data
 *
 * One click arrival deposit apply (for expired address deposit)
 */
readonly class OneClickArrivalDepositApply implements Endpoint, HasBodyParameters
{
    public const METHOD = 'capitalDepositCreditApply';

    public function __construct(
        public string $endpoint = '/sapi/v1/capital/deposit/credit-apply',
        public string $httpMethod = HttpMethod::POST,
        public null|int $weight = 1,
        public string $weightBased = BanBased::IP,
        public null|string $dataSource = null,
        public null|string $encryption = Signed::SIGNED_SIGNATURE_ALGO,
        public string $endpointType = EndpointSecurityType::USER_DATA,
        public string $title = 'One click arrival deposit apply (for expired address deposit)',
        public string $description = 'Apply deposit credit for expired address (One click arrival)',
    ) {
    }

    public function getBody(
        null|string $depositId = null,
        null|string $txId = null,
        null|string $subAccountId = null,
        null|string $subUserId = null,
    ): array {
        if (! is_null($depositId)) {
            $query['depositId'] = $depositId;
        }

        if (! is_null($txId)) {
            $query['txId'] = $txId;
        }

        if (! is_null($subAccountId)) {
            $query['subAccountId'] = $subAccountId;
        }

        if (! is_null($subUserId)) {
            $query['subUserId'] = $subUserId;
        }

        return $query ?? [];
    }

    public static function exampleResponse(): null|string
    {
        return json_encode([
            'code' => '000000',
            'message' => 'success',
            'data' => true,
            'success' => true,
        ]);
    }
}
