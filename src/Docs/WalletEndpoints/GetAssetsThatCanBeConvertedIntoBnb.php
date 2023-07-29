<?php

namespace BinanceApi\Docs\WalletEndpoints;

use BinanceApi\Docs\Const\BinanceApi\Endpoint;
use BinanceApi\Docs\Const\BinanceApi\HasBodyParameters;
use BinanceApi\Docs\GeneralInfo\Const\BanBased;
use BinanceApi\Docs\GeneralInfo\Const\HttpMethod;
use BinanceApi\Docs\GeneralInfo\EndpointSecurityType;
use BinanceApi\Docs\GeneralInfo\Signed;

/**
 * https://binance-docs.github.io/apidocs/spot/en/#get-assets-that-can-be-converted-into-bnb-user_data
 *
 * Get Assets That Can Be Converted Into BNB
 */
readonly class GetAssetsThatCanBeConvertedIntoBnb implements Endpoint, HasBodyParameters
{
    public const METHOD = 'assetDustBtc';

    public function __construct(
        public string $endpoint = '/sapi/v1/asset/dust-btc',
        public string $httpMethod = HttpMethod::POST,
        public null|int $weight = 1,
        public string $weightBased = BanBased::IP,
        public null|string $dataSource = null,
        public null|string $encryption = Signed::SIGNED_SIGNATURE_ALGO,
        public string $endpointType = EndpointSecurityType::USER_DATA,
        public string $title = 'Get Assets That Can Be Converted Into BNB',
        public string $description = '',
    ) {
    }

    public function getBody(null|string $recvWindow = null): array
    {
        return ! is_null($recvWindow) ? ['recvWindow' => $recvWindow] : [];
    }

    public static function exampleResponse(): string
    {
        return json_encode([
            'details' => [
                [
                    'asset' => 'ADA',
                    'assetFullName' => 'ADA',
                    'amountFree' => '6.21',
                    'toBTC' => '0.00016848',
                    'toBNB' => '0.01777302',
                    'toBNBOffExchange' => '0.01741756',
                    'exchange' => '0.00035546',
                ],
            ],
            'totalTransferBtc' => '0.00016848',
            'totalTransferBNB' => '0.01777302',
            'dribbletPercentage' => '0.02',
        ]);
    }
}
