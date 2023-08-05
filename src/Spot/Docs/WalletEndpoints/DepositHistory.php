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
 * https://binance-docs.github.io/apidocs/spot/en/#deposit-history-supporting-network-user_data
 *
 * Deposit History (supporting network)
 */
readonly class DepositHistory implements Endpoint, HasQueryParameters, ProcessResponse
{
    public const METHOD = 'capitalDepositHisrec';

    public function __construct(
        public string $endpoint = '/sapi/v1/capital/deposit/hisrec',
        public string $httpMethod = HttpMethod::GET,
        public null|int $weight = 1,
        public string $weightBased = BanBased::IP,
        public null|string $dataSource = null,
        public null|string $encryption = Signed::SIGNED_SIGNATURE_ALGO,
        public string $endpointType = EndpointSecurityType::USER_DATA,
        public string $title = 'Deposit History (supporting network)',
        public string $description = 'Fetch deposit history.',
    ) {
    }

    public function getQuery(
        null|string $coin = null,
        null|string $status = null,
        null|string $startTime = null,
        null|string $endTime = null,
        null|string $offset = null,
        int $limit = 1000,
        null|string $recvWindow = null,
        null|string $txId = null,
    ): array {
        if (! is_null($coin)) {
            $query['coin'] = $coin;
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

        if (! is_null($offset)) {
            $query['offset'] = $offset;
        }

        if (! is_null($limit)) {
            $query['limit'] = $limit;
        }

        if (! is_null($recvWindow)) {
            $query['recvWindow'] = $recvWindow;
        }

        if (! is_null($txId)) {
            $query['txId'] = $txId;
        }

        return $query ?? [];
    }


    public function processResponse(array $response): array
    {
        return array_map(function ($item) {
            $item[ProcessResponse::ADDITIONAL_FIELD]['insertTimeDate'] = Carbon::getFullDate($item['insertTime']);

            return $item;
        }, $response);
    }

    public static function exampleResponse(): string
    {
        return json_encode([
            [
                'id' => '769800519366885376',
                'amount' => '0.001',
                'coin' => 'BNB',
                'network' => 'BNB',
                'status' => 0,
                'address' => 'bnb136ns6lfw4zs5hg4n85vdthaad7hq5m4gtkgf23',
                'addressTag' => '101764890',
                'txId' => '98A3EA560C6B3336D348B6C83F0F95ECE4F1F5919E94BD006E5BF3BF264FACFC',
                'insertTime' => 1661493146000,
                'transferType' => 0,
                'confirmTimes' => '1/1',
                'unlockConfirm' => 0,
                'walletType' => 0,
            ],
            [
                'id' => '769754833590042625',
                'amount' => '0.50000000',
                'coin' => 'IOTA',
                'network' => 'IOTA',
                'status' => 1,
                'address' => 'SIZ9VLMHWATXKV99LH99CIGFJFUMLEHGWVZVNNZXRJJVWBPHYWPPBOSDORZ9EQSHCZAMPVAPGFYQAUUV9DROOXJLNW',
                'addressTag' => '',
                'txId' => 'ESBFVQUTPIWQNJSPXFNHNYHSQNTGKRVKPRABQWTAXCDWOAKDKYWPTVG9BGXNVNKTLEJGESAVXIKIZ9999',
                'insertTime' => 1599620082000,
                'transferType' => 0,
                'confirmTimes' => '1/1',
                'unlockConfirm' => 0,
                'walletType' => 0,
            ],
        ]);
    }
}
