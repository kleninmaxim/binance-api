<?php

namespace BinanceApi\Docs\WalletEndpoints;

use BinanceApi\Docs\Const\BinanceApi\Endpoint;
use BinanceApi\Docs\Const\BinanceApi\HasQueryParameters;
use BinanceApi\Docs\Const\BinanceApi\ProcessResponse;
use BinanceApi\Docs\GeneralInfo\Const\BanBased;
use BinanceApi\Docs\GeneralInfo\Const\HttpMethod;
use BinanceApi\Docs\GeneralInfo\EndpointSecurityType;
use BinanceApi\Docs\GeneralInfo\Signed;
use BinanceApi\Exception\BinanceException;
use BinanceApi\Helper\Carbon;

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
