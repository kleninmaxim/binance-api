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
 * https://binance-docs.github.io/apidocs/spot/en/#query-user-universal-transfer-history-user_data
 *
 * Query User Universal Transfer History
 */
readonly class QueryUserUniversalTransferHistory implements Endpoint, HasQueryParameters, ProcessResponse
{
    public const METHOD = 'getAssetTransfer';

    public function __construct(
        public string $endpoint = '/sapi/v1/asset/transfer',
        public string $httpMethod = HttpMethod::GET,
        public null|int $weight = 1,
        public string $weightBased = BanBased::IP,
        public null|string $dataSource = null,
        public null|string $encryption = Signed::SIGNED_SIGNATURE_ALGO,
        public string $endpointType = EndpointSecurityType::USER_DATA,
        public string $title = 'Query User Universal Transfer History ',
        public string $description = '',
    ) {
    }

    public function getQuery(
        null|string $type = null,
        null|string $startTime = null,
        null|string $endTime = null,
        int $current = 1,
        int $size = 10,
        null|string $fromSymbol = null,
        null|string $toSymbol = null,
        null|string $recvWindow = null
    ): array {
        if (! $type) {
            throw new BinanceException('type, are mandatory parameters, see: https://binance-docs.github.io/apidocs/spot/en/#query-user-universal-transfer-history-user_data');
        }

        $query = ['type' => $type, 'current' => $current, 'size' => $size];

        if (! is_null($startTime)) {
            $query['startTime'] = $startTime;
        }

        if (! is_null($endTime)) {
            $query['endTime'] = $endTime;
        }

        if (! is_null($fromSymbol)) {
            $query['fromSymbol'] = $fromSymbol;
        }

        if (! is_null($toSymbol)) {
            $query['toSymbol'] = $toSymbol;
        }

        if (! is_null($recvWindow)) {
            $query['recvWindow'] = $recvWindow;
        }

        return $query;
    }

    public function processResponse(array $response): array
    {
        $response['rows'] = array_map(function ($item) {
            $item[ProcessResponse::ADDITIONAL_FIELD]['timestampDate'] = Carbon::getFullDate($item['timestamp']);

            return $item;
        }, $response['rows']);

        return $response;
    }

    public static function exampleResponse(): string
    {
        return json_encode([
            'total' => 2,
            'rows' => [
                [
                    'asset' => 'USDT',
                    'amount' => '1',
                    'type' => 'MAIN_UMFUTURE',
                    'status' => 'CONFIRMED',
                    'tranId' => 11415955596,
                    'timestamp' => 1544433328000,
                ],
                [
                    'asset' => 'USDT',
                    'amount' => '2',
                    'type' => 'MAIN_UMFUTURE',
                    'status' => 'CONFIRMED',
                    'tranId' => 11366865406,
                    'timestamp' => 1544433328000,
                ]
            ],
        ]);
    }
}
