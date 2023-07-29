<?php

namespace BinanceApi\Docs\WalletEndpoints;

use BinanceApi\Docs\Const\BinanceApi\Endpoint;
use BinanceApi\Docs\Const\BinanceApi\HasBodyParameters;
use BinanceApi\Docs\GeneralInfo\Const\BanBased;
use BinanceApi\Docs\GeneralInfo\Const\HttpMethod;
use BinanceApi\Docs\GeneralInfo\EndpointSecurityType;
use BinanceApi\Docs\GeneralInfo\Signed;
use BinanceApi\Exception\BinanceException;

/**
 * https://binance-docs.github.io/apidocs/spot/en/#withdraw-user_data
 *
 * Withdraw
 */
readonly class Withdraw implements Endpoint, HasBodyParameters
{
    public const METHOD = 'capitalWithdrawApply';

    public function __construct(
        public string $endpoint = '/sapi/v1/capital/withdraw/apply',
        public string $httpMethod = HttpMethod::POST,
        public null|int $weight = 600,
        public string $weightBased = BanBased::IP,
        public null|string $dataSource = null,
        public null|string $encryption = Signed::SIGNED_SIGNATURE_ALGO,
        public string $endpointType = EndpointSecurityType::USER_DATA,
        public string $title = 'Withdraw',
        public string $description = 'Submit a withdraw request.',
    ) {
    }

    public function getBody(
        null|string $coin = null,
        null|string $address = null,
        null|string $amount = null,
        null|string $withdrawOrderId = null,
        null|string $network = null,
        null|string $addressTag = null,
        null|string $transactionFeeFlag = null,
        null|string $name = null,
        null|string $walletType = null,
        null|string $recvWindow = null,
    ): array {
        if (! $coin || ! $address || ! $amount) {
            throw new BinanceException('coin, address, amount are mandatory parameters, see: https://binance-docs.github.io/apidocs/spot/en/#withdraw-user_data');
        }

        $query = ['coin' => $coin, 'address' => $address, 'amount' => $amount];

        if (! is_null($withdrawOrderId)) {
            $query['withdrawOrderId'] = $withdrawOrderId;
        }

        if (! is_null($network)) {
            $query['network'] = $network;
        }

        if (! is_null($addressTag)) {
            $query['addressTag'] = $addressTag;
        }

        if (! is_null($transactionFeeFlag)) {
            $query['transactionFeeFlag'] = $transactionFeeFlag;
        }

        if (! is_null($name)) {
            $query['name'] = $name;
        }

        if (! is_null($walletType)) {
            $query['walletType'] = $walletType;
        }

        if (! is_null($recvWindow)) {
            $query['recvWindow'] = $recvWindow;
        }

        return $query;
    }

    public static function exampleResponse(): string
    {
        return json_encode(['id' => '7213fea8e94b4a5593d507237e5a555b']);
    }
}
