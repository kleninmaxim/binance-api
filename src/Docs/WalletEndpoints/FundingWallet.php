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
 * https://binance-docs.github.io/apidocs/spot/en/#funding-wallet-user_data
 *
 * Funding Wallet
 */
readonly class FundingWallet implements Endpoint, HasBodyParameters
{
    public const METHOD = 'assetGetFundingAsset';

    public function __construct(
        public string $endpoint = '/sapi/v1/asset/get-funding-asset',
        public string $httpMethod = HttpMethod::POST,
        public null|int $weight = 1,
        public string $weightBased = BanBased::IP,
        public null|string $dataSource = null,
        public null|string $encryption = Signed::SIGNED_SIGNATURE_ALGO,
        public string $endpointType = EndpointSecurityType::USER_DATA,
        public string $title = 'Funding Wallet',
        public string $description = '',
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
                'asset' => 'USDT',
                'free' => '1',
                'locked' => '0',
                'freeze' => '0',
                'withdrawing' => '0',
                'btcValuation' => '0.00000091',
            ],
        ]);
    }
}
