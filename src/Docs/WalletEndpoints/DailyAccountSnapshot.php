<?php

namespace BinanceApi\Docs\WalletEndpoints;

use BinanceApi\Docs\Const\BinanceApi\Endpoint;
use BinanceApi\Docs\Const\BinanceApi\HasQueryParameters;
use BinanceApi\Docs\Const\BinanceApi\ProcessResponse;
use BinanceApi\Docs\GeneralInfo\Const\BanBased;
use BinanceApi\Docs\GeneralInfo\Const\HttpMethod;
use BinanceApi\Docs\GeneralInfo\EndpointSecurityType;
use BinanceApi\Docs\GeneralInfo\Signed;
use BinanceApi\Helper\Carbon;

/**
 * https://binance-docs.github.io/apidocs/spot/en/#daily-account-snapshot-user_data
 *
 * Daily Account Snapshot
 */
readonly class DailyAccountSnapshot implements Endpoint, HasQueryParameters, ProcessResponse
{
    public const METHOD = 'accountSnapshot';

    public function __construct(
        public string $endpoint = '/sapi/v1/accountSnapshot',
        public string $httpMethod = HttpMethod::GET,
        public null|int $weight = 2400,
        public string $weightBased = BanBased::IP,
        public null|string $dataSource = null,
        public null|string $encryption = Signed::SIGNED_SIGNATURE_ALGO,
        public string $endpointType = EndpointSecurityType::USER_DATA,
        public string $title = 'Daily Account Snapshot',
        public string $description = '',
    ) {
    }

    public function getQuery(
        string $type = 'SPOT',
        null|string $startTime = null,
        null|string $endTime = null,
        int $limit = 7,
        null|string $recvWindow = null
    ): array {
        if ($limit < 1) {
            $limit = 1;
        }

        if ($limit > 30) {
            $limit = 30;
        }

        $query = ['type' => $type, 'limit' => $limit];

        if (! is_null($startTime)) {
            $query['startTime'] = $startTime;
        }

        if (! is_null($endTime)) {
            $query['endTime'] = $endTime;
        }

        if (! is_null($recvWindow)) {
            $query['recvWindow'] = $recvWindow;
        }

        return $query;
    }

    public function processResponse(array $response): array
    {
        $response['snapshotVos'] = array_map(function ($item) {
            $item[ProcessResponse::ADDITIONAL_FIELD]['updateTimeDate'] = Carbon::getFullDate($item['updateTime']);

            return $item;
        }, $response['snapshotVos']);

        return $response;
    }

    public static function exampleResponse(): array
    {
        return [
            'firstVersion' => json_encode([
                'code' => 200,
                'msg' => '',
                'snapshotVos' => [
                    [
                        'data' => [
                            'balances' => [
                                [
                                    'asset' => 'BTC',
                                    'free' => '0.09905021',
                                    'locked' => '0.00000000',
                                ],
                                [
                                    'asset' => 'USDT',
                                    'free' => '1.89109409',
                                    'locked' => '0.00000000',
                                ],
                            ],
                            'totalAssetOfBtc' => '0.09942700',
                        ],
                        'type' => 'spot',
                        'updateTime' => 1576281599000,
                    ]
                ],
            ]),
            'secondVersion' => json_encode([
                'code' => 200,
                'msg' => '',
                'snapshotVos' => [
                    [
                        'data' => [
                            'marginLevel' => '2748.02909813',
                            'totalAssetOfBtc' => '0.00274803',
                            'totalLiabilityOfBtc' => '0.00000100',
                            'totalNetAssetOfBtc' => '0.00274750',
                            'userAssets' => [
                                [
                                    'asset' => 'XRP',
                                    'borrowed' => '0.00000000',
                                    'free' => '1.00000000',
                                    'interest' => '0.00000000',
                                    'locked' => '0.00000000',
                                    'netAsset' => '1.00000000',
                                ]
                            ],
                        ],
                        'type' => 'margin',
                        'updateTime' => 1576281599000,
                    ]
                ],
            ]),
            'thirdVersion' => json_encode([
                'code' => 200,
                'msg' => '',
                'snapshotVos' => [
                    [
                        'data' => [
                            'marginLevel' => '2748.02909813',
                            'totalAssetOfBtc' => '0.00274803',
                            'totalLiabilityOfBtc' => '0.00000100',
                            'totalNetAssetOfBtc' => '0.00274750',
                            'userAssets' => [
                                [
                                    'asset' => 'XRP',
                                    'borrowed' => '0.00000000',
                                    'free' => '1.00000000',
                                    'interest' => '0.00000000',
                                    'locked' => '0.00000000',
                                    'netAsset' => '1.00000000',
                                ]
                            ]
                        ],
                        'type' => 'futures',
                        'updateTime' => 1576281599000,
                    ]
                ],
            ]),
        ];
    }
}
