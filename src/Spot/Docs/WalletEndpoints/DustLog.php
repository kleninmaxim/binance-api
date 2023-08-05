<?php

namespace BinanceApi\Spot\Docs\WalletEndpoints;

use BinanceApi\Helper\Carbon;
use BinanceApi\Spot\Docs\Const\BinanceApi\Endpoint;
use BinanceApi\Spot\Docs\Const\BinanceApi\HasQueryParameters;
use BinanceApi\Spot\Docs\Const\BinanceApi\ProcessResponse;
use BinanceApi\Spot\Docs\GeneralInfo\Const\BanBased;
use BinanceApi\Spot\Docs\GeneralInfo\Const\HttpMethod;
use BinanceApi\Spot\Docs\GeneralInfo\EndpointSecurityType;
use BinanceApi\Spot\Docs\GeneralInfo\Signed;

/**
 * https://binance-docs.github.io/apidocs/spot/en/#dustlog-user_data
 *
 * DustLog
 */
readonly class DustLog implements Endpoint, HasQueryParameters, ProcessResponse
{
    public const METHOD = 'assetDribblet';

    public function __construct(
        public string $endpoint = '/sapi/v1/asset/dribblet',
        public string $httpMethod = HttpMethod::GET,
        public null|int $weight = 1,
        public string $weightBased = BanBased::IP,
        public null|string $dataSource = null,
        public null|string $encryption = Signed::SIGNED_SIGNATURE_ALGO,
        public string $endpointType = EndpointSecurityType::USER_DATA,
        public string $title = 'DustLog',
        public string $description = '',
    ) {
    }

    public function getQuery(null|string $startTime = null, null|string $endTime = null, null|string $recvWindow = null): array
    {
        if (! is_null($startTime)) {
            $query['startTime'] = $startTime;
        }

        if (! is_null($endTime)) {
            $query['endTime'] = $endTime;
        }

        if (! is_null($recvWindow)) {
            $query['recvWindow'] = $recvWindow;
        }

        return $query ?? [];
    }

    public function processResponse(array $response): array
    {
        $response['userAssetDribblets'] = array_map(function ($item) {
            $item['userAssetDribbletDetails'] = array_map(function ($item) {
                $item[ProcessResponse::ADDITIONAL_FIELD]['operateTimeDate'] = Carbon::getFullDate($item['operateTime']);

                return $item;
            }, $item['userAssetDribbletDetails']);

            $item[ProcessResponse::ADDITIONAL_FIELD]['operateTimeDate'] = Carbon::getFullDate($item['operateTime']);

            return $item;
        }, $response['userAssetDribblets']);

        return $response;
    }

    public static function exampleResponse(): string
    {
        return json_encode([
            'total' => 8,
            'userAssetDribblets' => [
                [
                    'operateTime' => 1615985535000,
                    'totalTransferedAmount' => '0.00132256',
                    'totalServiceChargeAmount' => '0.00002699',
                    'transId' => 45178372831,
                    'userAssetDribbletDetails' => [
                        [
                            'transId' => 4359321,
                            'serviceChargeAmount' => '0.000009',
                            'amount' => '0.0009',
                            'operateTime' => 1615985535000,
                            'transferedAmount' => '0.000441',
                            'fromAsset' => 'USDT',
                        ],
                        [
                            'transId' => 4359321,
                            'serviceChargeAmount' => '0.00001799',
                            'amount' => '0.0009',
                            'operateTime' => 1615985535000,
                            'transferedAmount' => '0.00088156',
                            'fromAsset' => 'ETH',
                        ]
                    ],
                ],
                [
                    'operateTime' => 1615985535000,
                    'totalTransferedAmount' => '0.00058795',
                    'totalServiceChargeAmount' => '0.000012',
                    'transId' => 4357015,
                    'userAssetDribbletDetails' => [
                        [
                            'transId' => 4357015,
                            'serviceChargeAmount' => '0.00001',
                            'amount' => '0.001',
                            'operateTime' => 1615985535000,
                            'transferedAmount' => '0.00049',
                            'fromAsset' => 'USDT',
                        ],
                        [
                            'transId' => 4357015,
                            'serviceChargeAmount' => '0.000002',
                            'amount' => '0.001',
                            'operateTime' => 1615985535000,
                            'transferedAmount' => '0.00009795',
                            'fromAsset' => 'ETH',
                        ]
                    ],
                ],
            ],
        ]);
    }
}
