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
 * https://binance-docs.github.io/apidocs/spot/en/#busd-convert-trade
 *
 * BUSD Convert
 */
readonly class BusdConvert implements Endpoint, HasBodyParameters
{
    public const METHOD = 'assetConvertTransfer';

    public function __construct(
        public string $endpoint = '/sapi/v1/asset/convert-transfer',
        public string $httpMethod = HttpMethod::POST,
        public null|int $weight = 5,
        public string $weightBased = BanBased::IP,
        public null|string $dataSource = null,
        public null|string $encryption = Signed::SIGNED_SIGNATURE_ALGO,
        public string $endpointType = EndpointSecurityType::TRADE,
        public string $title = 'BUSD Convert',
        public string $description = 'Convert transfer, convert between BUSD and stablecoins.',
    ) {
    }

    public function getBody(
        null|string $clientTranId = null,
        null|string $asset = null,
        null|string $amount = null,
        null|string $targetAsset = null,
        null|string $accountType = null
    ): array {
        if (! $clientTranId || ! $asset || ! $amount || ! $targetAsset) {
            throw new BinanceException('clientTranId, asset, amount, targetAsset are mandatory parameters, see: https://binance-docs.github.io/apidocs/spot/en/#busd-convert-trade');
        }

        $query = ['clientTranId' => $clientTranId, 'asset' => $asset, 'amount' => $amount, 'targetAsset' => $targetAsset];

        if (! is_null($accountType)) {
            $query['accountType'] = $accountType;
        }

        return $query ?? [];
    }

    public static function exampleResponse(): string
    {
        return json_encode([
            'tranId' => 118263407119,
            'status' => 'S',
        ]);
    }
}
