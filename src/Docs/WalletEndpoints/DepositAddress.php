<?php

namespace BinanceApi\Docs\WalletEndpoints;

use BinanceApi\Docs\Const\BinanceApi\Endpoint;
use BinanceApi\Docs\Const\BinanceApi\HasQueryParameters;
use BinanceApi\Docs\Const\Exception\EndpointQueryException;
use BinanceApi\Docs\GeneralInfo\Const\BanBased;
use BinanceApi\Docs\GeneralInfo\Const\HttpMethod;
use BinanceApi\Docs\GeneralInfo\EndpointSecurityType;
use BinanceApi\Docs\GeneralInfo\Signed;
use BinanceApi\Exception\BinanceException;

/**
 * https://binance-docs.github.io/apidocs/spot/en/#deposit-address-supporting-network-user_data
 *
 * Deposit Address (supporting network)
 */
readonly class DepositAddress implements Endpoint, HasQueryParameters
{
    public const METHOD = 'capitalDepositAddress';

    public function __construct(
        public string $endpoint = '/sapi/v1/capital/deposit/address',
        public string $httpMethod = HttpMethod::GET,
        public null|int $weight = 10,
        public string $weightBased = BanBased::IP,
        public null|string $dataSource = null,
        public null|string $encryption = Signed::SIGNED_SIGNATURE_ALGO,
        public string $endpointType = EndpointSecurityType::USER_DATA,
        public string $title = 'Deposit Address (supporting network)',
        public string $description = 'Fetch deposit address with network.',
    ) {
    }

    public function getQuery(
        null|string $coin = null,
        null|string $network = null,
        null|string $recvWindow = null
    ): array {
        if (is_null($coin)) {
            throw new BinanceException('coin are mandatory parameters, see: https://binance-docs.github.io/apidocs/spot/en/#withdraw-user_data');
        }

        $query = ['coin' => $coin];

        if (! is_null($network)) {
            $query['network'] = $network;
        }

        if (! is_null($recvWindow)) {
            $query['recvWindow'] = $recvWindow;
        }

        return $query ?? [];
    }

    public static function exampleResponse(): string
    {
        return json_encode([
            'address' => '1HPn8Rx2y6nNSfagQBKy27GB99Vbzg89wv',
            'coin' => 'BTC',
            'tag' => '',
            'url' => 'https://btc.com/1HPn8Rx2y6nNSfagQBKy27GB99Vbzg89wv',
        ]);
    }
}
