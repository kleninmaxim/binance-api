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
 * https://binance-docs.github.io/apidocs/spot/en/#dust-transfer-user_data
 *
 * Dust Transfer
 */
readonly class DustTransfer implements Endpoint, HasBodyParameters, ProcessResponse
{
    public const METHOD = 'assetDust';

    public function __construct(
        public string $endpoint = '/sapi/v1/asset/dust',
        public string $httpMethod = HttpMethod::POST,
        public null|int $weight = 10,
        public string $weightBased = BanBased::IP,
        public null|string $dataSource = null,
        public null|string $encryption = Signed::SIGNED_SIGNATURE_ALGO,
        public string $endpointType = EndpointSecurityType::USER_DATA,
        public string $title = 'Dust Transfer',
        public string $description = 'Convert dust assets to BNB.',
    ) {
    }

    public function getBody(array $asset = [], null|string $recvWindow = null): array
    {
        if (! $asset) {
            throw new BinanceException('asset are mandatory parameters, see: https://binance-docs.github.io/apidocs/spot/en/#dust-transfer-user_data');
        }

        $query = ['asset' => implode(',', $asset)];

        if (! is_null($recvWindow)) {
            $query['recvWindow'] = $recvWindow;
        }

        return $query;
    }

    public function processResponse(array $response): array
    {
        $response['transferResult'] = array_map(function ($item) {
            $item[ProcessResponse::ADDITIONAL_FIELD]['operateTimeDate'] = Carbon::getFullDate($item['operateTime']);

            return $item;
        }, $response['transferResult']);

        return $response;
    }

    public static function exampleResponse(): string
    {
        return json_encode([
            'totalServiceCharge' => '0.02102542',
            'totalTransfered' => '1.05127099',
            'transferResult' => [
                [
                    'amount' => '0.03000000',
                    'fromAsset' => 'ETH',
                    'operateTime' => 1563368549307,
                    'serviceChargeAmount' => '0.00500000',
                    'tranId' => 2970932918,
                    'transferedAmount' => '0.25000000',
                ],
                [
                    'amount' => '0.09000000',
                    'fromAsset' => 'LTC',
                    'operateTime' => 1563368549307,
                    'serviceChargeAmount' => '0.01548000',
                    'tranId' => 2970932918,
                    'transferedAmount' => '0.77400000',
                ],
                [
                    'amount' => '248.61878453',
                    'fromAsset' => 'TRX',
                    'operateTime' => 1563368549307,
                    'serviceChargeAmount' => '0.00054542',
                    'tranId' => 2970932918,
                    'transferedAmount' => '0.02727099',
                ],
            ],
        ]);
    }
}
