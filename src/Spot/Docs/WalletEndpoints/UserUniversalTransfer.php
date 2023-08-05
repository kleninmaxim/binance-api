<?php

namespace BinanceApi\Spot\Docs\WalletEndpoints;

use BinanceApi\Exception\BinanceException;
use BinanceApi\Spot\Docs\Const\BinanceApi\Endpoint;
use BinanceApi\Spot\Docs\Const\BinanceApi\HasBodyParameters;
use BinanceApi\Spot\Docs\GeneralInfo\Const\BanBased;
use BinanceApi\Spot\Docs\GeneralInfo\Const\HttpMethod;
use BinanceApi\Spot\Docs\GeneralInfo\EndpointSecurityType;
use BinanceApi\Spot\Docs\GeneralInfo\Signed;

/**
 * https://binance-docs.github.io/apidocs/spot/en/#user-universal-transfer-user_data
 *
 * User Universal Transfer
 */
readonly class UserUniversalTransfer implements Endpoint, HasBodyParameters
{
    public const METHOD = 'assetTransfer';

    public function __construct(
        public string $endpoint = '/sapi/v1/asset/transfer',
        public string $httpMethod = HttpMethod::POST,
        public null|int $weight = 900,
        public string $weightBased = BanBased::IP,
        public null|string $dataSource = null,
        public null|string $encryption = Signed::SIGNED_SIGNATURE_ALGO,
        public string $endpointType = EndpointSecurityType::USER_DATA,
        public string $title = 'User Universal Transfer ',
        public string $description = 'You need to enable Permits Universal Transfer option for the API Key which requests this endpoint.',
    ) {
    }

    public function getBody(
        null|string $type = null,
        null|string $asset = null,
        null|string $amount = null,
        null|string $fromSymbol = null,
        null|string $toSymbol = null,
        null|string $recvWindow = null
    ): array {
        if (! $type || ! $asset || ! $amount) {
            throw new BinanceException('type, asset, amount are mandatory parameters, see: https://binance-docs.github.io/apidocs/spot/en/#user-universal-transfer-user_data');
        }

        $query = ['type' => $type, 'asset' => $asset, 'amount' => $amount];

        if (! is_null($fromSymbol)) {
            $query['fromSymbol'] = $fromSymbol;
        }

        if (! is_null($toSymbol)) {
            $query['toSymbol'] = $toSymbol;
        }

        if (! is_null($recvWindow)) {
            $query['recvWindow'] = $recvWindow;
        }

        return $query;
    }

    public static function exampleResponse(): string
    {
        return json_encode([
            'tranId' => 13526853623
        ]);
    }
}
