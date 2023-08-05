<?php

namespace BinanceApi\Spot\Docs\WalletEndpoints;

use BinanceApi\Spot\Docs\Const\BinanceApi\Endpoint;
use BinanceApi\Spot\Docs\Const\BinanceApi\HasQueryParameters;
use BinanceApi\Spot\Docs\GeneralInfo\Const\BanBased;
use BinanceApi\Spot\Docs\GeneralInfo\Const\HttpMethod;
use BinanceApi\Spot\Docs\GeneralInfo\EndpointSecurityType;
use BinanceApi\Spot\Docs\GeneralInfo\Signed;

/**
 * https://binance-docs.github.io/apidocs/spot/en/#withdraw-history-supporting-network-user_data
 *
 * Withdraw History (supporting network)
 */
readonly class WithdrawHistory implements Endpoint, HasQueryParameters
{
    public const METHOD = 'capitalWithdrawHistory';

    public function __construct(
        public string $endpoint = '/sapi/v1/capital/withdraw/history',
        public string $httpMethod = HttpMethod::GET,
        public null|int $weight = 1,
        public string $weightBased = BanBased::IP,
        public null|string $dataSource = null,
        public null|string $encryption = Signed::SIGNED_SIGNATURE_ALGO,
        public string $endpointType = EndpointSecurityType::USER_DATA,
        public string $title = 'Withdraw History (supporting network)',
        public string $description = 'Fetch withdraw history.',
    ) {
    }

    public function getQuery(
        null|string $coin = null,
        null|string $withdrawOrderId = null,
        null|string $offset = null,
        int $limit = 1000,
        null|string $status = null,
        null|string $startTime = null,
        null|string $endTime = null,
        null|string $recvWindow = null,
    ): array {
        if (! is_null($coin)) {
            $query['coin'] = $coin;
        }

        if (! is_null($withdrawOrderId)) {
            $query['withdrawOrderId'] = $withdrawOrderId;
        }

        if (! is_null($offset)) {
            $query['offset'] = $offset;
        }

        if (! is_null($limit)) {
            $query['limit'] = $limit;
        }

        if (! is_null($status)) {
            $query['status'] = $status;
        }

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

    public static function exampleResponse(): string
    {
        return json_encode([
            [
                'id' => 'b6ae22b3aa844210a7041aee7589627c',
                'amount' => '8.91000000',
                'transactionFee' => '0.004',
                'coin' => 'USDT',
                'status' => 6,
                'address' => '0x94df8b352de7f46f64b01d3666bf6e936e44ce60',
                'txId' => '0xb5ef8c13b968a406cc62a93a8bd80f9e9a906ef1b3fcf20a2e48573c17659268',
                'applyTime' => '2019-10-12 11:12:02',
                'network' => 'ETH',
                'transferType' => 0,
                'withdrawOrderId' => 'WITHDRAWtest123',
                'info' => 'The address is not valid. Please confirm with the recipient',
                'confirmNo' => 3,
                'walletType' => 1,
                'txKey' => '',
                'completeTime' => '2023-03-23 16:52:41',
            ],
            [
                'id' => '156ec387f49b41df8724fa744fa82719',
                'amount' => '8.00150000',
                'transactionFee' => '0.004',
                'coin' => 'BTC',
                'status' => 6,
                'address' => '1FZdVHtiBqMrWdjPyRPULCUceZPJ2WLCsB',
                'txId' => '60fd9007ebfddc753455f95fafa808c4302c836e4d1eebc5a132c36c1d8ac354',
                'applyTime' => '2019-09-24 12:43:45',
                'network' => 'BTC',
                'transferType' => 0,
                'info' => '',
                'confirmNo' => 2,
                'walletType' => 1,
                'txKey' => '',
                'completeTime' => '2023-03-23 16:52:41',
            ],
        ]);
    }
}
