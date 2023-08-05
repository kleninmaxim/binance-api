<?php

namespace BinanceApi\Spot\Docs\WalletEndpoints;

use BinanceApi\Exception\BinanceException;
use BinanceApi\Helper\Carbon;
use BinanceApi\Spot\Docs\Const\BinanceApi\Endpoint;
use BinanceApi\Spot\Docs\Const\BinanceApi\HasQueryParameters;
use BinanceApi\Spot\Docs\Const\BinanceApi\ProcessResponse;
use BinanceApi\Spot\Docs\GeneralInfo\Const\BanBased;
use BinanceApi\Spot\Docs\GeneralInfo\Const\HttpMethod;
use BinanceApi\Spot\Docs\GeneralInfo\EndpointSecurityType;
use BinanceApi\Spot\Docs\GeneralInfo\Signed;

/**
 * https://binance-docs.github.io/apidocs/spot/en/#busd-convert-history-user_data
 *
 * BUSD Convert History
 */
readonly class BusdConvertHistory implements Endpoint, HasQueryParameters, ProcessResponse
{
    public const METHOD = 'assetConvertTransferQueryByPage';

    public function __construct(
        public string $endpoint = '/sapi/v1/asset/convert-transfer/queryByPage',
        public string $httpMethod = HttpMethod::GET,
        public null|int $weight = 5,
        public string $weightBased = BanBased::UID,
        public null|string $dataSource = null,
        public null|string $encryption = Signed::SIGNED_SIGNATURE_ALGO,
        public string $endpointType = EndpointSecurityType::USER_DATA,
        public string $title = 'BUSD Convert History',
        public string $description = 'Convert transfer, convert between BUSD and stablecoins.',
    ) {
    }

    public function getQuery(
        null|string $tranId = null,
        null|string $clientTranId = null,
        null|string $asset = null,
        null|string $startTime = null,
        null|string $endTime = null,
        null|string $accountType = null,
        int $current = 1,
        int $size = 10,
    ): array {
        if (! $startTime || ! $endTime) {
            throw new BinanceException('startTime, endTime are mandatory parameters, see: https://binance-docs.github.io/apidocs/spot/en/#busd-convert-history-user_data');
        }

        $query = ['startTime' => $startTime, 'endTime' => $endTime, 'size' => $size];

        if (! is_null($tranId)) {
            $query['tranId'] = $tranId;
        }

        if (! is_null($clientTranId)) {
            $query['clientTranId'] = $clientTranId;
        }

        if (! is_null($asset)) {
            $query['asset'] = $asset;
        }

        if (! is_null($accountType)) {
            $query['accountType'] = $accountType;
        }

        if (! is_null($current)) {
            $query['current'] = $current;
        }

        return $query ?? [];
    }

    public function processResponse(array $response): array
    {
        $response['rows'] = array_map(function ($item) {
            $item[ProcessResponse::ADDITIONAL_FIELD]['timeDate'] = Carbon::getFullDate($item['time']);

            return $item;
        }, $response['rows']);

        return $response;
    }

    public static function exampleResponse(): string
    {
        return json_encode([
            'total' => 3,
            'rows' => [
                [
                    'tranId' => 118263615991,
                    'type' => 244,
                    'time' => 1664442078000,
                    'deductedAsset' => 'BUSD',
                    'deductedAmount' => '1',
                    'targetAsset' => 'USDC',
                    'targetAmount' => '1',
                    'status' => 'S',
                    'accountType' => 'MAIN',
                ],
                [
                    'tranId' => 118263615991,
                    'type' => 244,
                    'time' => 1664442078000,
                    'deductedAsset' => 'BUSD',
                    'deductedAmount' => '1',
                    'targetAsset' => 'USDC',
                    'targetAmount' => '1',
                    'status' => 'S',
                    'accountType' => 'MAIN',
                ],
                [
                    'tranId' => 118263615991,
                    'type' => 244,
                    'time' => 1664442078000,
                    'deductedAsset' => 'BUSD',
                    'deductedAmount' => '1',
                    'targetAsset' => 'USDC',
                    'targetAmount' => '1',
                    'status' => 'S',
                    'accountType' => 'MAIN',
                ]
            ],
        ]);
    }
}
