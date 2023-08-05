<?php

namespace BinanceApi\Spot\Docs\WalletEndpoints;

use BinanceApi\Spot\Docs\Const\BinanceApi\Endpoint;
use BinanceApi\Spot\Docs\Const\BinanceApi\HasQueryParameters;
use BinanceApi\Spot\Docs\GeneralInfo\Const\BanBased;
use BinanceApi\Spot\Docs\GeneralInfo\Const\HttpMethod;
use BinanceApi\Spot\Docs\GeneralInfo\EndpointSecurityType;
use BinanceApi\Spot\Docs\GeneralInfo\Signed;

/**
 * https://binance-docs.github.io/apidocs/spot/en/#asset-detail-user_data
 *
 * Asset Detail
 */
readonly class AssetDetail implements Endpoint, HasQueryParameters
{
    public const METHOD = 'assetAssetDetail';

    public function __construct(
        public string $endpoint = '/sapi/v1/asset/assetDetail',
        public string $httpMethod = HttpMethod::GET,
        public null|int $weight = 1,
        public string $weightBased = BanBased::IP,
        public null|string $dataSource = null,
        public null|string $encryption = Signed::SIGNED_SIGNATURE_ALGO,
        public string $endpointType = EndpointSecurityType::USER_DATA,
        public string $title = 'Asset Detail ',
        public string $description = 'Fetch details of assets supported on Binance.',
    ) {
    }

    public function getQuery(null|string $asset = null, null|string $recvWindow = null): array
    {
        if (! is_null($asset)) {
            $query['asset'] = $asset;
        }

        if (! is_null($recvWindow)) {
            $query['recvWindow'] = $recvWindow;
        }

        return $query ?? [];
    }

    public static function exampleResponse(): string
    {
        return json_encode([
            'CTR' => [
                'minWithdrawAmount' => '70.00000000',
                'depositStatus' => false,
                'withdrawFee' => 35,
                'withdrawStatus' => true,
                'depositTip' => 'Delisted, Deposit Suspended',
            ],
            'SKY' => [
                'minWithdrawAmount' => '0.02000000',
                'depositStatus' => true,
                'withdrawFee' => 0.01,
                'withdrawStatus' => true,
            ],
        ]);
    }
}
