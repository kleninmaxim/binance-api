<?php

namespace BinanceApi\Docs\WalletEndpoints;

use BinanceApi\Docs\Const\BinanceApi\Endpoint;
use BinanceApi\Docs\Const\BinanceApi\HasBodyParameters;
use BinanceApi\Docs\Const\BinanceApi\ProcessResponse;
use BinanceApi\Docs\GeneralInfo\Const\BanBased;
use BinanceApi\Docs\GeneralInfo\Const\HttpMethod;
use BinanceApi\Docs\GeneralInfo\EndpointSecurityType;
use BinanceApi\Docs\GeneralInfo\Signed;
use BinanceApi\Exception\BinanceException;
use BinanceApi\Helper\Carbon;

/**
 * https://binance-docs.github.io/apidocs/spot/en/#user-asset-user_data
 *
 * User Asset
 */
readonly class UserAsset implements Endpoint, HasBodyParameters
{
    public const METHOD = 'assetGetUserAsset';

    public function __construct(
        public string $endpoint = '/sapi/v3/asset/getUserAsset',
        public string $httpMethod = HttpMethod::POST,
        public null|int $weight = 5,
        public string $weightBased = BanBased::IP,
        public null|string $dataSource = null,
        public null|string $encryption = Signed::SIGNED_SIGNATURE_ALGO,
        public string $endpointType = EndpointSecurityType::USER_DATA,
        public string $title = 'User Asset',
        public string $description = 'Get user assets, just for positive data.',
    ) {
    }

    public function getBody(
        null|string $asset = null,
        null|bool|string $needBtcValuation = null,
        null|string $recvWindow = null
    ): array {
        if (! is_null($asset)) {
            $query['asset'] = $asset;
        }

        if (! is_null($needBtcValuation)) {
            $query['needBtcValuation'] = $needBtcValuation;
        }

        if (! is_null($recvWindow)) {
            $query['recvWindow'] = $recvWindow;
        }

        return $query ?? [];
    }

    public static function exampleResponse(): string
    {
        return json_encode([
            [
                'asset' => 'AVAX',
                'free' => '1',
                'locked' => '0',
                'freeze' => '0',
                'withdrawing' => '0',
                'ipoable' => '0',
                'btcValuation' => '0',
            ],
            [
                'asset' => 'BCH',
                'free' => '0.9',
                'locked' => '0',
                'freeze' => '0',
                'withdrawing' => '0',
                'ipoable' => '0',
                'btcValuation' => '0',
            ],
            [
                'asset' => 'BNB',
                'free' => '887.47061626',
                'locked' => '0',
                'freeze' => '10.52',
                'withdrawing' => '0.1',
                'ipoable' => '0',
                'btcValuation' => '0',
            ],
            [
                'asset' => 'BUSD',
                'free' => '9999.7',
                'locked' => '0',
                'freeze' => '0',
                'withdrawing' => '0',
                'ipoable' => '0',
                'btcValuation' => '0',
            ],
            [
                'asset' => 'SHIB',
                'free' => '532.32',
                'locked' => '0',
                'freeze' => '0',
                'withdrawing' => '0',
                'ipoable' => '0',
                'btcValuation' => '0',
            ],
            [
                'asset' => 'USDT',
                'free' => '50300000001.44911105',
                'locked' => '0',
                'freeze' => '0',
                'withdrawing' => '0',
                'ipoable' => '0',
                'btcValuation' => '0',
            ],
            [
                'asset' => 'WRZ',
                'free' => '1',
                'locked' => '0',
                'freeze' => '0',
                'withdrawing' => '0',
                'ipoable' => '0',
                'btcValuation' => '0',
            ],
        ]);
    }
}
