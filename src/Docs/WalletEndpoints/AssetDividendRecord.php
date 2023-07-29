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
 * https://binance-docs.github.io/apidocs/spot/en/#asset-dividend-record-user_data
 *
 * Asset Dividend Record
 */
readonly class AssetDividendRecord implements Endpoint, HasQueryParameters, ProcessResponse
{
    public const METHOD = 'assetAssetDividend';

    public function __construct(
        public string $endpoint = '/sapi/v1/asset/assetDividend',
        public string $httpMethod = HttpMethod::GET,
        public null|int $weight = 10,
        public string $weightBased = BanBased::IP,
        public null|string $dataSource = null,
        public null|string $encryption = Signed::SIGNED_SIGNATURE_ALGO,
        public string $endpointType = EndpointSecurityType::USER_DATA,
        public string $title = 'Asset Dividend Record ',
        public string $description = 'Query asset dividend record.',
    ) {
    }

    public function getQuery(
        null|string $asset = null,
        null|string $startTime = null,
        null|string $endTime = null,
        int $limit = 20,
        null|string $recvWindow = null
    ): array {
        if (! is_null($asset)) {
            $query['asset'] = $asset;
        }

        if (! is_null($startTime)) {
            $query['startTime'] = $startTime;
        }

        if (! is_null($endTime)) {
            $query['endTime'] = $endTime;
        }

        $query['limit'] = $limit;

        if (! is_null($recvWindow)) {
            $query['recvWindow'] = $recvWindow;
        }

        return $query;
    }

    public function processResponse(array $response): array
    {
        $response['rows'] = array_map(function ($item) {
            $item[ProcessResponse::ADDITIONAL_FIELD]['divTimeDate'] = Carbon::getFullDate($item['divTime']);

            return $item;
        }, $response['rows']);

        return $response;
    }

    public static function exampleResponse(): string
    {
        return json_encode([
            'rows' => [
                [
                    'id' => 1637366104,
                    'amount' => '10.00000000',
                    'asset' => 'BHFT',
                    'divTime' => 1563189166000,
                    'enInfo' => 'BHFT distribution',
                    'tranId' => 2968885920,
                ],
                [
                    'id' => 1631750237,
                    'amount' => '10.00000000',
                    'asset' => 'BHFT',
                    'divTime' => 1563189166000,
                    'enInfo' => 'BHFT distribution',
                    'tranId' => 2968885920,
                ]
            ],
            'total' => 2,
        ]);
    }
}
