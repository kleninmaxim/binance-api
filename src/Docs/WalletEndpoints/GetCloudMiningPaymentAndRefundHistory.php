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
 * https://binance-docs.github.io/apidocs/spot/en/#get-cloud-mining-payment-and-refund-history-user_data
 *
 * Get Cloud-Mining payment and refund history
 */
readonly class GetCloudMiningPaymentAndRefundHistory implements Endpoint, HasQueryParameters, ProcessResponse
{
    public const METHOD = 'assetLedgerTransferCloudMiningQueryByPage';

    public function __construct(
        public string $endpoint = '/sapi/v1/asset/ledger-transfer/cloud-mining/queryByPage',
        public string $httpMethod = HttpMethod::GET,
        public null|int $weight = 600,
        public string $weightBased = BanBased::UID,
        public null|string $dataSource = null,
        public null|string $encryption = Signed::SIGNED_SIGNATURE_ALGO,
        public string $endpointType = EndpointSecurityType::USER_DATA,
        public string $title = 'Get Cloud-Mining payment and refund history',
        public string $description = 'The query of Cloud-Mining payment and refund history',
    ) {
    }

    public function getQuery(
        null|string $tranId = null,
        null|string $clientTranId = null,
        null|string $asset = null,
        null|string $startTime = null,
        null|string $endTime = null,
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

        if (! is_null($current)) {
            $query['current'] = $current;
        }

        return $query ?? [];
    }

    public function processResponse(array $response): array
    {
        $response['rows'] = array_map(function ($item) {
            $item[ProcessResponse::ADDITIONAL_FIELD]['createTimeDate'] = Carbon::getFullDate($item['createTime']);

            return $item;
        }, $response['rows']);

        return $response;
    }

    public static function exampleResponse(): string
    {
        return json_encode([
            'total' => 5,
            'rows' => [
                [
                    'createTime' => 1667880112000,
                    'tranId' => 121230610120,
                    'type' => 248,
                    'asset' => 'USDT',
                    'amount' => '25.0068',
                    'status' => 'S',
                ],
                [
                    'createTime' => 1666776366000,
                    'tranId' => 119991507468,
                    'type' => 249,
                    'asset' => 'USDT',
                    'amount' => '0.027',
                    'status' => 'S',
                ],
                [
                    'createTime' => 1666764505000,
                    'tranId' => 119977966327,
                    'type' => 248,
                    'asset' => 'USDT',
                    'amount' => '0.027',
                    'status' => 'S',
                ],
                [
                    'createTime' => 1666758189000,
                    'tranId' => 119973601721,
                    'type' => 248,
                    'asset' => 'USDT',
                    'amount' => '0.018',
                    'status' => 'S',
                ],
                [
                    'createTime' => 1666757278000,
                    'tranId' => 119973028551,
                    'type' => 248,
                    'asset' => 'USDT',
                    'amount' => '0.018',
                    'status' => 'S',
                ],
            ],
        ]);
    }
}
