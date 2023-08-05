<?php

namespace BinanceApi\Spot\Docs\WalletEndpoints;

use BinanceApi\Spot\Docs\Const\BinanceApi\Endpoint;
use BinanceApi\Spot\Docs\Const\BinanceApi\HasQueryParameters;
use BinanceApi\Spot\Docs\GeneralInfo\Const\BanBased;
use BinanceApi\Spot\Docs\GeneralInfo\Const\HttpMethod;
use BinanceApi\Spot\Docs\GeneralInfo\EndpointSecurityType;
use BinanceApi\Spot\Docs\GeneralInfo\Signed;

/**
 * https://binance-docs.github.io/apidocs/spot/en/#all-coins-39-information-user_data
 *
 * All Coins' Information
 */
readonly class AllCoinsInformation implements Endpoint, HasQueryParameters
{
    public const METHOD = 'capitalConfigGetall';

    public function __construct(
        public string $endpoint = '/sapi/v1/capital/config/getall',
        public string $httpMethod = HttpMethod::GET,
        public null|int $weight = 10,
        public string $weightBased = BanBased::IP,
        public null|string $dataSource = null,
        public null|string $encryption = Signed::SIGNED_SIGNATURE_ALGO,
        public string $endpointType = EndpointSecurityType::USER_DATA,
        public string $title = 'All Coins\' Information',
        public string $description = 'Get information of coins (available for deposit and withdraw) for user.',
    ) {
    }

    public function getQuery(null|string $recvWindow = null): array
    {
        return ! is_null($recvWindow) ? ['recvWindow' => $recvWindow] : [];
    }

    public static function exampleResponse(): string
    {
        return json_encode([
            [
                'coin' => 'BTC',
                'depositAllEnable' => true,
                'free' => '0.08074558',
                'freeze' => '0.00000000',
                'ipoable' => '0.00000000',
                'ipoing' => '0.00000000',
                'isLegalMoney' => false,
                'locked' => '0.00000000',
                'name' => 'Bitcoin',
                'networkList' => [
                    [
                        'addressRegex' => '^(bnb1)[0-9a-z]{38}$',
                        'coin' => 'BTC',
                        'depositDesc' => 'Wallet Maintenance, Deposit Suspended',
                        'depositEnable' => false,
                        'isDefault' => false,
                        'memoRegex' => '^[0-9A-Za-z\\-_]{1,120}$',
                        'minConfirm' => 1,
                        'name' => 'BEP2',
                        'network' => 'BNB',
                        'resetAddressStatus' => false,
                        'specialTips' => 'Both a MEMO and an Address are required to successfully deposit your BEP2-BTCB tokens to Binance.',
                        'unLockConfirm' => 0,
                        'withdrawDesc' => 'Wallet Maintenance, Withdrawal Suspended',
                        'withdrawEnable' => false,
                        'withdrawFee' => '0.00000220',
                        'withdrawIntegerMultiple' => '0.00000001',
                        'withdrawMax' => '9999999999.99999999',
                        'withdrawMin' => '0.00000440',
                        'sameAddress' => true,
                        'estimatedArrivalTime' => 25,
                        'busy' => false,
                    ],
                    [
                        'addressRegex' => '^[13][a-km-zA-HJ-NP-Z1-9]{25,34}$|^(bc1)[0-9A-Za-z]{39,59}$',
                        'coin' => 'BTC',
                        'depositEnable' => true,
                        'isDefault' => true,
                        'memoRegex' => '',
                        'minConfirm' => 1,
                        'name' => 'BTC',
                        'network' => 'BTC',
                        'resetAddressStatus' => false,
                        'specialTips' => '',
                        'unLockConfirm' => 2,
                        'withdrawEnable' => true,
                        'withdrawFee' => '0.00050000',
                        'withdrawIntegerMultiple' => '0.00000001',
                        'withdrawMax' => '750',
                        'withdrawMin' => '0.00100000',
                        'sameAddress' => false,
                        'estimatedArrivalTime' => 25,
                        'busy' => false,
                    ],
                ],
                'storage' => '0.00000000',
                'rading' => true,
                'withdrawAllEnable' => true,
                'withdrawing' => '0.00000000',
            ]
        ]);
    }
}
