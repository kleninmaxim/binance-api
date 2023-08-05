<?php

namespace BinanceApi\Spot\Docs\SpotAccountTrade;

use BinanceApi\Spot\Docs\Const\BinanceApi\Endpoint;
use BinanceApi\Spot\Docs\Const\BinanceApi\HasQueryParameters;
use BinanceApi\Spot\Docs\GeneralInfo\Const\BanBased;
use BinanceApi\Spot\Docs\GeneralInfo\Const\HttpMethod;
use BinanceApi\Spot\Docs\GeneralInfo\DataSources;
use BinanceApi\Spot\Docs\GeneralInfo\EndpointSecurityType;
use BinanceApi\Spot\Docs\GeneralInfo\Signed;

/**
 * https://binance-docs.github.io/apidocs/spot/en/#account-information-user_data
 *
 * Account Information
 */
readonly class AccountInformation implements Endpoint, HasQueryParameters
{
    public const METHOD = 'account';

    public function __construct(
        public string $endpoint = '/api/v3/account',
        public string $httpMethod = HttpMethod::GET,
        public null|int $weight = 10,
        public string $weightBased = BanBased::IP,
        public null|string $dataSource = DataSources::MEMORY_TO_DATABASE,
        public null|string $encryption = Signed::SIGNED_SIGNATURE_ALGO,
        public string $endpointType = EndpointSecurityType::USER_DATA,
        public string $title = 'Account Information',
        public string $description = 'Get current account information.',
    ) {
    }

    public function getQuery(null|string $recvWindow = null): array
    {
        if (! is_null($recvWindow)) {
            $query['recvWindow'] = $recvWindow;
        }

        return $query ?? [];
    }

    public static function exampleResponse(): string
    {
        return json_encode([
            'makerCommission' => 15,
            'takerCommission' => 15,
            'buyerCommission' => 0,
            'sellerCommission' => 0,
            'commissionRates' => [
                'maker' => '0.00150000',
                'taker' => '0.00150000',
                'buyer' => '0.00000000',
                'seller' => '0.00000000',
            ],
            'canTrade' => true,
            'canWithdraw' => true,
            'canDeposit' => true,
            'brokered' => false,
            'requireSelfTradePrevention' => false,
            'preventSor' => false,
            'updateTime' => 123456789,
            'accountType' => 'SPOT',
            'balances' => [
                [
                    'asset' => 'BTC',
                    'free' => '4723846.89208129',
                    'locked' => '0.00000000',
                ],
                [
                    'asset' => 'LTC',
                    'free' => '4763368.68006011',
                    'locked' => '0.00000000',
                ]
            ],
            'permissions' => [
                'SPOT'
            ],
            'uid' => 354937868
        ]);
    }
}
