# Examples and Analogs

All methods you can find in `\BinanceApi\Binance` class in phpdoc

## Common part for all next requests

```php
$binance = new \BinanceApi\Binance();

$binance->setOutputCallback(function ($output) {
    return $output['response']['data'];
});

$binance->setApiKeys('apiKey');
```

## Wallet Endpoints

### [System Status (System)](https://binance-docs.github.io/apidocs/spot/en/#system-status-system)
```php
$binance->systemStatus();
```

<details>
<summary>View result</summary>

```text
[
   'status' => 0,
   'msg' => 'normal',
]
```
</details>

### [All Coins' Information](https://binance-docs.github.io/apidocs/spot/en/#all-coins-39-information-user_data)
```php
$binance->capitalConfigGetall();
```

<details>
<summary>View result</summary>

```text
[
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
]
```
</details>

### [Daily Account Snapshot](https://binance-docs.github.io/apidocs/spot/en/#daily-account-snapshot-user_data)
```php
$binance->accountSnapshot();
```

<details>
<summary>View result</summary>

```text
[
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
            'customAdditional' => [
                'insertTimeDate' => 'Sat, 03 Jun 2023 05:58:20 UTC'
            ]
        ]
    ],
]
```
</details>

### [Disable Fast Withdraw Switch](https://binance-docs.github.io/apidocs/spot/en/#disable-fast-withdraw-switch-user_data)
```php
$binance->accountDisableFastWithdrawSwitch();
```

<details>
<summary>View result</summary>

```text
[]
```
</details>

### [Enable Fast Withdraw Switch](https://binance-docs.github.io/apidocs/spot/en/#enable-fast-withdraw-switch-user_data)
```php
$binance->accountEnableFastWithdrawSwitch();
```

<details>
<summary>View result</summary>

```text
[]
```
</details>

### [Withdraw](https://binance-docs.github.io/apidocs/spot/en/#withdraw-user_data)
```php
$binance->capitalWithdrawApply('USDT', 'TPKiaNqAzu2NYkd2ptqcgtp57DVBZ9P7ui', 20, network: 'TRX');
```

<details>
<summary>View result</summary>

```text
[
    'id' => '7213fea8e94b4a5593d507237e5a555b'
]
```
</details>

### [Deposit History (supporting network)](https://binance-docs.github.io/apidocs/spot/en/#deposit-history-supporting-network-user_data)
```php
$binance->capitalDepositHisrec();
```

<details>
<summary>View result</summary>

```text
[
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
       'customAdditional' => [
           'insertTimeDate' => 'Mon, 17 Jul 2023 07:45:46 UTC'
       ]
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
       'customAdditional' => [
           'insertTimeDate' => 'Sat, 03 Jun 2023 05:58:20 UTC'
       ]
   ],
]
```
</details>

### [Withdraw History (supporting network)](https://binance-docs.github.io/apidocs/spot/en/#withdraw-history-supporting-network-user_data)
```php
$binance->capitalWithdrawHistory();
```

<details>
<summary>View result</summary>

```text
[
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
]
```
</details>

### [Withdraw History (supporting network)](https://binance-docs.github.io/apidocs/spot/en/#withdraw-history-supporting-network-user_data)
```php
$binance->capitalDepositAddress('BTC');
```

<details>
<summary>View result</summary>

```text
[
   'address' => '1HPn8Rx2y6nNSfagQBKy27GB99Vbzg89wv',
   'coin' => 'BTC',
   'tag' => '',
   'url' => 'https://btc.com/1HPn8Rx2y6nNSfagQBKy27GB99Vbzg89wv',
]
```
</details>

### [Account Status](https://binance-docs.github.io/apidocs/spot/en/#account-status-user_data)
```php
$binance->accountStatus();
```

<details>
<summary>View result</summary>

```text
[
   'address' => '1HPn8Rx2y6nNSfagQBKy27GB99Vbzg89wv',
   'coin' => 'BTC',
   'tag' => '',
   'url' => 'https://btc.com/1HPn8Rx2y6nNSfagQBKy27GB99Vbzg89wv',
]
```
</details>

### [Account API Trading Status](https://binance-docs.github.io/apidocs/spot/en/#account-api-trading-status-user_data)
```php
$binance->accountApiTradingStatus();
```

<details>
<summary>View result</summary>

```text
[
   'data' => [
       'isLocked' => false,
       'plannedRecoverTime' => 0,
       'triggerCondition' => [
           'GCR' => 150,
           'IFER' => 150,
           'UFR' => 300,
       ],
       'updateTime' => 1547630471725,
        'customAdditional' => [
           'updateTimeDate' => 'Sat, 03 Jun 2023 05:58:20 UTC'
       ]
   ],
]
```
</details>

### [DustLog](https://binance-docs.github.io/apidocs/spot/en/#dustlog-user_data)
```php
$binance->assetDribblet();
```

<details>
<summary>View result</summary>

```text
[
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
                   'customAdditional' => [
                       'operateTimeDate' => 'Sat, 03 Jun 2023 05:58:20 UTC'
                   ]
               ],
               [
                   'transId' => 4359321,
                   'serviceChargeAmount' => '0.00001799',
                   'amount' => '0.0009',
                   'operateTime' => 1615985535000,
                   'transferedAmount' => '0.00088156',
                   'fromAsset' => 'ETH',
                   'customAdditional' => [
                       'operateTimeDate' => 'Sat, 03 Jun 2023 05:58:20 UTC'
                   ]
               ]
           ],
           'customAdditional' => [
               'operateTimeDate' => 'Sat, 03 Jun 2023 05:58:20 UTC'
           ]
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
                   'customAdditional' => [
                       'operateTimeDate' => 'Sat, 03 Jun 2023 05:58:20 UTC'
                   ]
               ],
               [
                   'transId' => 4357015,
                   'serviceChargeAmount' => '0.000002',
                   'amount' => '0.001',
                   'operateTime' => 1615985535000,
                   'transferedAmount' => '0.00009795',
                   'fromAsset' => 'ETH',
                   'customAdditional' => [
                       'operateTimeDate' => 'Sat, 03 Jun 2023 05:58:20 UTC'
                   ]
               ]
           ],
           'customAdditional' => [
               'operateTimeDate' => 'Sat, 03 Jun 2023 05:58:20 UTC'
           ]
       ],
   ],
]
```
</details>

### [Get Assets That Can Be Converted Into BNB](https://binance-docs.github.io/apidocs/spot/en/#get-assets-that-can-be-converted-into-bnb-user_data)
```php
$binance->assetDustBtc();
```

<details>
<summary>View result</summary>

```text
[
   'details' => [
       [
           'asset' => 'ADA',
           'assetFullName' => 'ADA',
           'amountFree' => '6.21',
           'toBTC' => '0.00016848',
           'toBNB' => '0.01777302',
           'toBNBOffExchange' => '0.01741756',
           'exchange' => '0.00035546',
       ],
   ],
   'totalTransferBtc' => '0.00016848',
   'totalTransferBNB' => '0.01777302',
   'dribbletPercentage' => '0.02',
]
```
</details>

### [Asset Dividend Record](https://binance-docs.github.io/apidocs/spot/en/#asset-dividend-record-user_data)
```php
$binance->assetAssetDividend();
```

<details>
<summary>View result</summary>

```text
[
   'rows' => [
       [
           'id' => 1637366104,
           'amount' => '10.00000000',
           'asset' => 'BHFT',
           'divTime' => 1563189166000,
           'enInfo' => 'BHFT distribution',
           'tranId' => 2968885920,
       ],
       [
           'id' => 1631750237,
           'amount' => '10.00000000',
           'asset' => 'BHFT',
           'divTime' => 1563189166000,
           'enInfo' => 'BHFT distribution',
           'tranId' => 2968885920,
       ]
   ],
   'total' => 2,
]
```
</details>


### [Asset Detail](https://binance-docs.github.io/apidocs/spot/en/#asset-detail-user_data)
```php
$binance->assetAssetDetail();
```

<details>
<summary>View result</summary>

```text
[
   'CTR' => [
       'minWithdrawAmount' => '70.00000000',
       'depositStatus' => false,
       'withdrawFee' => 35,
       'withdrawStatus' => true,
       'depositTip' => 'Delisted, Deposit Suspended',
   ],
   'SKY' => [
       'minWithdrawAmount' => '0.02000000',
       'depositStatus' => true,
       'withdrawFee' => 0.01,
       'withdrawStatus' => true,
   ],
]
```
</details>

### [Trade Fee](https://binance-docs.github.io/apidocs/spot/en/#trade-fee-user_data)
```php
$binance->assetTradeFee();
```

<details>
<summary>View result</summary>

```text
[
   [
       'symbol' => 'ADABNB',
       'makerCommission' => 0.001,
       'takerCommission' => 0.001,
   ],
   [
       'symbol' => 'BNBBTC',
       'makerCommission' => 0.001,
       'takerCommission' => 0.001,
   ],
]
```
</details>

### [User Universal Transfer ](https://binance-docs.github.io/apidocs/spot/en/#user-universal-transfer-user_data)
```php
$binance->assetTransfer('MAIN_UMFUTURE', 'USDT', 10);
```

<details>
<summary>View result</summary>

```text
[
   'tranId' => 13526853623
]
```
</details>

### [Query User Universal Transfer History](https://binance-docs.github.io/apidocs/spot/en/#query-user-universal-transfer-history-user_data)
```php
$binance->queryAssetTransfer('MAIN_UMFUTURE');
```

<details>
<summary>View result</summary>

```text
[
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
]
```
</details>

### [Funding Wallet](https://binance-docs.github.io/apidocs/spot/en/#funding-wallet-user_data)
```php
$binance->assetGetFundingAsset();
```

<details>
<summary>View result</summary>

```text
[
   [
       'asset' => 'USDT',
       'free' => '1',
       'locked' => '0',
       'freeze' => '0',
       'withdrawing' => '0',
       'btcValuation' => '0.00000091',
   ],
]
```
</details>

### [User Asset](https://binance-docs.github.io/apidocs/spot/en/#user-asset-user_data)
```php
$binance->assetGetUserAsset();
```

<details>
<summary>View result</summary>

```text
[
   [
       'asset' => 'AVAX',
       'free' => '1',
       'locked' => '0',
       'freeze' => '0',
       'withdrawing' => '0',
       'ipoable' => '0',
       'btcValuation' => '0',
   ],
   [
       'asset' => 'BCH',
       'free' => '0.9',
       'locked' => '0',
       'freeze' => '0',
       'withdrawing' => '0',
       'ipoable' => '0',
       'btcValuation' => '0',
   ],
   [
       'asset' => 'BNB',
       'free' => '887.47061626',
       'locked' => '0',
       'freeze' => '10.52',
       'withdrawing' => '0.1',
       'ipoable' => '0',
       'btcValuation' => '0',
   ],
   [
       'asset' => 'BUSD',
       'free' => '9999.7',
       'locked' => '0',
       'freeze' => '0',
       'withdrawing' => '0',
       'ipoable' => '0',
       'btcValuation' => '0',
   ],
   [
       'asset' => 'SHIB',
       'free' => '532.32',
       'locked' => '0',
       'freeze' => '0',
       'withdrawing' => '0',
       'ipoable' => '0',
       'btcValuation' => '0',
   ],
   [
       'asset' => 'USDT',
       'free' => '50300000001.44911105',
       'locked' => '0',
       'freeze' => '0',
       'withdrawing' => '0',
       'ipoable' => '0',
       'btcValuation' => '0',
   ],
   [
       'asset' => 'WRZ',
       'free' => '1',
       'locked' => '0',
       'freeze' => '0',
       'withdrawing' => '0',
       'ipoable' => '0',
       'btcValuation' => '0',
   ],
]
```
</details>

### [BUSD Convert](https://binance-docs.github.io/apidocs/spot/en/#busd-convert-trade)
```php
$binance->assetConvertTransfer('uniquetransactionuseridwithminlenght', 'USDT', '10', 'BTC');
```

<details>
<summary>View result</summary>

```text
[
   'tranId' => 118263407119,
   'status' => 'S',
]
```
</details>

### [BUSD Convert History](https://binance-docs.github.io/apidocs/spot/en/#busd-convert-history-user_data)
```php
$binance->assetConvertTransferQueryByPage(startTime: 1664442078000, endTime: 1664442078000);
```

<details>
<summary>View result</summary>

```text
[
   'total' => 3,
   'rows' => [
       [
           'tranId' => 118263615991,
           'type' => 244,
           'time' => 1664442078000,
           'deductedAsset' => 'BUSD',
           'deductedAmount' => '1',
           'targetAsset' => 'USDC',
           'targetAmount' => '1',
           'status' => 'S',
           'accountType' => 'MAIN',
       ],
       [
           'tranId' => 118263615991,
           'type' => 244,
           'time' => 1664442078000,
           'deductedAsset' => 'BUSD',
           'deductedAmount' => '1',
           'targetAsset' => 'USDC',
           'targetAmount' => '1',
           'status' => 'S',
           'accountType' => 'MAIN',
       ],
       [
           'tranId' => 118263615991,
           'type' => 244,
           'time' => 1664442078000,
           'deductedAsset' => 'BUSD',
           'deductedAmount' => '1',
           'targetAsset' => 'USDC',
           'targetAmount' => '1',
           'status' => 'S',
           'accountType' => 'MAIN',
       ]
   ],
]
```
</details>

### [Get Cloud-Mining payment and refund history](https://binance-docs.github.io/apidocs/spot/en/#get-cloud-mining-payment-and-refund-history-user_data)
```php
$binance->assetLedgerTransferCloudMiningQueryByPage(startTime: 1664442078000, endTime: 1664442078000);
```

<details>
<summary>View result</summary>

```text
[
   'total' => 3,
   'rows' => [
       [
           'tranId' => 118263615991,
           'type' => 244,
           'time' => 1664442078000,
           'deductedAsset' => 'BUSD',
           'deductedAmount' => '1',
           'targetAsset' => 'USDC',
           'targetAmount' => '1',
           'status' => 'S',
           'accountType' => 'MAIN',
       ],
       [
           'tranId' => 118263615991,
           'type' => 244,
           'time' => 1664442078000,
           'deductedAsset' => 'BUSD',
           'deductedAmount' => '1',
           'targetAsset' => 'USDC',
           'targetAmount' => '1',
           'status' => 'S',
           'accountType' => 'MAIN',
       ],
       [
           'tranId' => 118263615991,
           'type' => 244,
           'time' => 1664442078000,
           'deductedAsset' => 'BUSD',
           'deductedAmount' => '1',
           'targetAsset' => 'USDC',
           'targetAmount' => '1',
           'status' => 'S',
           'accountType' => 'MAIN',
       ]
   ],
]
```
</details>

### [Get API Key Permission](https://binance-docs.github.io/apidocs/spot/en/#get-api-key-permission-user_data)
```php
$binance->accountApiRestrictions();
```

<details>
<summary>View result</summary>

```text
[
   'ipRestrict' => false,
   'createTime' => 1623840271000,
   'enableWithdrawals' => false,
   'enableInternalTransfer' => true,
   'permitsUniversalTransfer' => true,
   'enableVanillaOptions' => false,
   'enableReading' => true,
   'enableFutures' => false,
   'enableMargin' => false,
   'enableSpotAndMarginTrading' => false,
   'tradingAuthorityExpirationTime' => 1628985600000,
]
```
</details>

### [Query auto-converting stable coins](https://binance-docs.github.io/apidocs/spot/en/#query-auto-converting-stable-coins-user_data)
```php
$binance->capitalContractConvertibleCoins();
```

<details>
<summary>View result</summary>

```text
[
   'convertEnabled' => true,
   'coins' => [
       'USDC',
       'USDP',
       'TUSD',
   ],
   'exchangeRates' => [
       'USDC' => '1',
       'TUSD' => '1',
       'USDP' => '1',
   ],
]
```
</details>

### [Switch on/off BUSD and stable coins conversion](https://binance-docs.github.io/apidocs/spot/en/#switch-on-off-busd-and-stable-coins-conversion-user_data)
```php
$binance->switchCapitalContractConvertibleCoins('USDC', false);
```

<details>
<summary>View result</summary>

```text

```
</details>

### [One click arrival deposit apply (for expired address deposit)](https://binance-docs.github.io/apidocs/spot/en/#one-click-arrival-deposit-apply-for-expired-address-deposit-user_data)
```php
$binance->capitalDepositCreditApply();
```

<details>
<summary>View result</summary>

```text
[
   'code' => '000000',
   'message' => 'success',
   'data' => true,
   'success' => true,
]
```
</details>

## Market Data Endpoints

### [Test Connectivity](https://binance-docs.github.io/apidocs/spot/en/#test-connectivity)
```php
$binance->ping();
```

<details>
<summary>View result</summary>

```text
[]
```
</details>

### [Check Server Time](https://binance-docs.github.io/apidocs/spot/en/#check-server-time)
```php
$binance->time();
```

<details>
<summary>View result</summary>

```text
[
   'serverTime' => 1499827319559
   'customAdditional' => [
       'serverTimeDate' => 'Sat, 15 Jul 2023 17:02:47 UTC'
   ]
]
```
</details>

### [Exchange Information](https://binance-docs.github.io/apidocs/spot/en/#exchange-information)
```php
$binance->exchangeInfo('BTCUSDT');
```

<details>
<summary>View result</summary>

```text
[
   'timezone' => 'UTC',
   'serverTime' => 1565246363776,
   'rateLimits' => [
       [
           'rateLimitType' => 'REQUEST_WEIGHT',
           'interval' => 'MINUTE',
           'intervalNum' => 1,
           'limit' => 1200,
       ],
       [
           'rateLimitType' => 'ORDERS',
           'interval' => 'SECOND',
           'intervalNum' => 10,
           'limit' => 50,
       ],
       [
           'rateLimitType' => 'ORDERS',
           'interval' => 'DAY',
           'intervalNum' => 1,
           'limit' => 160000,
       ],
       [
           'rateLimitType' => 'RAW_REQUESTS',
           'interval' => 'MINUTE',
           'intervalNum' => 5,
           'limit' => 6100,
       ],
   ],
   'exchangeFilters' => [],
   'symbols' => [
       [
           'symbol' => 'ETHBTC',
           'status' => 'TRADING',
           'baseAsset' => 'ETH',
           'baseAssetPrecision' => 8,
           'quoteAsset' => 'BTC',
           'quotePrecision' => 8,
           'quoteAssetPrecision' => 8,
           'orderTypes' => [
               'LIMIT',
               'LIMIT_MAKER',
               'MARKET',
               'STOP_LOSS',
               'STOP_LOSS_LIMIT',
               'TAKE_PROFIT',
               'TAKE_PROFIT_LIMIT'
           ],
           'icebergAllowed' => true,
           'ocoAllowed' => true,
           'quoteOrderQtyMarketAllowed' => true,
           'allowTrailingStop' => false,
           'cancelReplaceAllowed' => false,
           'isSpotTradingAllowed' => true,
           'isMarginTradingAllowed' => true,
           'filters' => [
               [
                   'filterType' => 'PRICE_FILTER',
                   'minPrice' => 0.00000100,
                   'maxPrice' => 100.00000000,
                   'tickSize' => 0.00000100,
               ],
               [
                   'filterType' => 'LOT_SIZE',
                   'minPrice' => 0.00000100,
                   'maxPrice' => 9000.00000000,
                   'stepSize' => 0.00001000,
               ],
               [
                   'filterType' => 'ICEBERG_PARTS',
                   'limit' => 10,
               ],
               [
                   'filterType' => 'MARKET_LOT_SIZE',
                   'minPrice' => 0.00000000,
                   'maxPrice' => 1000.00000000,
                   'stepSize' => 0.00000000,
               ],
               [
                   'filterType' => 'TRAILING_DELTA',
                   'minTrailingAboveDelta' => 10,
                   'maxTrailingAboveDelta' => 2000,
                   'minTrailingBelowDelta' => 10,
                   'maxTrailingBelowDelta' => 2000,
               ],
               [
                   'filterType' => 'PERCENT_PRICE_BY_SIDE',
                   'bidMultiplierUp' => 5,
                   'bidMultiplierDown' => 0.2,
                   'askMultiplierUp' => 5,
                   'askMultiplierDown' => 0.2,
               ],
               [
                   'filterType' => 'NOTIONAL',
                   'minNotional' => 0.00010000,
                   'applyMinToMarket' => 1,
                   'maxNotional' => 9000000.00000000,
                   'applyMaxToMarket' => '',
                   'avgPriceMins' => 1,
               ],
               [
                   'filterType' => 'MAX_NUM_ORDERS',
                   'maxNumOrders' => 200,
               ],
               [
                   'filterType' => 'MAX_NUM_ALGO_ORDERS',
                   'maxNumAlgoOrders' => 5,
               ],
           ],
           'permissions' => ['SPOT', 'MARGIN'],
           'defaultSelfTradePreventionMode' => 'NONE',
           'allowedSelfTradePreventionModes' => ['NONE'],
       ]
   ],
   'customAdditional' => [
      ['serverTimeDate'] => 'Sat, 15 Jul 2023 17:02:47 UTC'
   ]
]
```
</details>

### [Order Book](https://binance-docs.github.io/apidocs/spot/en/#order-book)
```php
$binance->depth('BTCUSDT', 5);

$binance->orderbook('BTCUSDT', 5);

$binance->orderbookBTCUSDT(5); // "BTCUSDT" you can replace with any market: "ETHUSDT", "BTCBUSD", ...
```

<details>
<summary>View result</summary>

```text
[
   'lastUpdateId' => 1027024,
   'bids' => [
       [
           'amount' => '4.00000000',
           'price' => '431.00000000',
       ],
   ],
   'asks' => [
       [
           'amount' => '4.00000200',
           'price' => '12.00000000',
       ],
   ]
]
```
</details>

### [Recent Trades List](https://binance-docs.github.io/apidocs/spot/en/#recent-trades-list)
```php
$binance->trades('BTCUSDT', 5);
```

<details>
<summary>View result</summary>

```text
[
   [
       'id' => 1454371,
       'price' => '30280.27000000',
       'qty' => '0.00100000',
       'quoteQty' => '48.000012',
       'time' => 1499865549590,
       'isBuyerMaker' => true,
       'isBestMatch' => true,
       'customAdditional' => [
            'timeDate' => 'Sun, 16 Jul 2023 08:17:01 UTC'
       ],
   ],
   [
       'id' => 28457,
       'price' => '4.00000100',
       'qty' => '12.00000000',
       'quoteQty' => '48.000012',
       'time' => 1499865549590,
       'isBuyerMaker' => true,
       'isBestMatch' => true,
       'customAdditional' => [
            'timeDate' => 'Sun, 16 Jul 2023 08:17:01 UTC'
       ],
   ]
]
```
</details>

### [Old Trade Lookup](https://binance-docs.github.io/apidocs/spot/en/#old-trade-lookup)
```php
$binance->historicalTrades('BTCUSDT');
```

<details>
<summary>View result</summary>

```text
[
   [
       'id' => 28457,
       'price' => '4.00000100',
       'qty' => '12.00000000',
       'quoteQty' => '48.000012',
       'time' => 1499865549590,
       'isBuyerMaker' => true,
       'isBestMatch' => true
       'customAdditional' => [
            'timeDate' => 'Sun, 16 Jul 2023 08:17:01 UTC'
       ],
   ],
   [
       'id' => 28457,
       'price' => '4.00000100',
       'qty' => '12.00000000',
       'quoteQty' => '48.000012',
       'time' => 1499865549590,
       'isBuyerMaker' => true,
       'isBestMatch' => true
       'customAdditional' => [
            'timeDate' => 'Sun, 16 Jul 2023 08:17:01 UTC'
       ],
   ]
]
```
</details>

### [Compressed/Aggregate Trades List](https://binance-docs.github.io/apidocs/spot/en/#compressed-aggregate-trades-list)
```php
$binance->aggTrades('BTCUSDT', limit: 5);
```

<details>
<summary>View result</summary>

```text
[
   [
      'aggregateTradeId' => 26129,
      'price' => "0.01633102",
      'quantity' => "4.70443515",
      'firstTradeId' => 27781,
      'lastTradeId' => 27781,
      'timestamp' => 1498793709153,
      'wasTheBuyerTheMaker' => true,
      'wasTheTradeTheBestPriceMatch' => true,
      'customAdditional' => [
           'timestampDate' => 'Sun, 16 Jul 2023 08:21:53 UTC'
      ]
   ],
   [
      'aggregateTradeId' => 26129,
      'price' => "0.01633102",
      'quantity' => "4.70443515",
      'firstTradeId' => 27781,
      'lastTradeId' => 27781,
      'timestamp' => 1498793709153,
      'wasTheBuyerTheMaker' => true,
      'wasTheTradeTheBestPriceMatch' => true,
      'customAdditional' => [
           'timestampDate' => 'Sun, 16 Jul 2023 08:21:53 UTC'
      ]
   ]
]
```
</details>

### [Kline/Candlestick Data](https://binance-docs.github.io/apidocs/spot/en/#kline-candlestick-data)
```php
$binance->klines('BTCUSDT', '1d', limit: 5);
```
```php
$binance->secondKlines('BTCUSDT');

$binance->minuteKlines('BTCUSDT');

$binance->threeMinuteKlines('BTCUSDT');

$binance->fiveMinuteKlines('BTCUSDT');

$binance->fifteenMinuteKlines('BTCUSDT');

$binance->thirtyMinuteKlines('BTCUSDT');

$binance->hourKlines('BTCUSDT');

$binance->twoHourKlines('BTCUSDT');

$binance->fourHourKlines('BTCUSDT');

$binance->sixHourKlines('BTCUSDT');

$binance->eightHourKlines('BTCUSDT');

$binance->twelveHourKlines('BTCUSDT');

$binance->dayKlines('BTCUSDT');

$binance->threeDayKlines('BTCUSDT');

$binance->weekKlines('BTCUSDT');

$binance->monthKlines('BTCUSDT');
```
```php
$startTime = new DateTime('01 Jan 2022 00:00:00 GMT');
$binance->hourKlines('BTCUSDT', $startTime, limit: 24);
```
```php
$endTime = new DateTime('01 Jan 2022 00:00:00 GMT');
$binance->hourKlines('BTCUSDT', endTime: $endTime, limit: 48);
```

<details>
<summary>View result</summary>

```text
[
   [
       'klineOpenTime' => '1689465600000',
       'openPrice' => '30289.53000000',
       'highPrice' => '30335.16000000',
       'lowPrice' => '29984.02000000',
       'closePrice' => '30293.76000000',
       'volume' => '639.17429700',
       'klineCloseTime' => '1689551999999',
       'quoteAssetVolume' => '19323347.68137913',
       'numberOfTrades' => '45576',
       'takerBuyBaseAssetVolume' => '362.10226300',
       'takerBuyQuoteAssetVolume' => '10945758.72630827',
       'unusedField' => '0',
       'customAdditional' => [
           'klineOpenTimeDate' => 'Sun, 16 Jul 2023 00:00:00 UTC',
           'klineCloseTimeDate' => 'Mon, 17 Jul 2023 00:00:00 UTC',
       ],
   ]
]
```
</details>

### [UIKlines](https://binance-docs.github.io/apidocs/spot/en/#uiklines)
```php
$binance->uiKlines('BTCUSDT', '1d', limit: 5);
```

<details>
<summary>View result</summary>

```text
[
   [
       'klineOpenTime' => '1689465600000',
       'openPrice' => '30289.53000000',
       'highPrice' => '30335.16000000',
       'lowPrice' => '29984.02000000',
       'closePrice' => '30293.76000000',
       'volume' => '639.17429700',
       'klineCloseTime' => '1689551999999',
       'quoteAssetVolume' => '19323347.68137913',
       'numberOfTrades' => '45576',
       'takerBuyBaseAssetVolume' => '362.10226300',
       'takerBuyQuoteAssetVolume' => '10945758.72630827',
       'unusedField' => '0',
       'customAdditional' => [
           'klineOpenTimeDate' => 'Sun, 16 Jul 2023 00:00:00 UTC',
           'klineCloseTimeDate' => 'Mon, 17 Jul 2023 00:00:00 UTC',
       ],
   ]
]
```
</details>

### [Current Average Price](https://binance-docs.github.io/apidocs/spot/en/#current-average-price)
```php
$binance->avgPrice('BTCUSDT');
```

<details>
<summary>View result</summary>

```text
[
   'mins' => 5,
   'price' => '9.35751834',
]
```
</details>

### [24hr Ticker Price Change Statistics](https://binance-docs.github.io/apidocs/spot/en/#24hr-ticker-price-change-statistics)
```php
$binance->ticker24hr('BTCUSDT');
```

<details>
<summary>View result</summary>

```text
[
   [
      'symbol' => 'BNBBTC',
      'priceChange' => '-94.99999800',
      'priceChangePercent' => '-95.960',
      'weightedAvgPrice' => '0.29628482',
      'prevClosePrice' => '0.10002000',
      'lastPrice' => '4.00000200',
      'lastQty' => '200.00000000',
      'bidPrice' => '4.00000000',
      'bidQty' => '100.00000000',
      'askPrice' => '4.00000200',
      'askQty' => '100.00000000',
      'openPrice' => '99.00000000',
      'highPrice' => '100.00000000',
      'lowPrice' => '0.10000000',
      'volume' => '8913.30000000',
      'quoteVolume' => '15.30000000',
      'openTime' => 1499783499040,
      'closeTime' => 1499869899040,
      'firstId' => 28385,
      'lastId' => 28460,
      'count' => 76,
      'customAdditional' => [
           'openTimeDate' => 'Sat, 15 Jul 2023 08:35:54 UTC',
           'closeTimeDate' => 'Sun, 16 Jul 2023 08:35:54 UTC'
      ]
   ]
]
```
</details>

### [Symbol Price Ticker](https://binance-docs.github.io/apidocs/spot/en/#symbol-price-ticker)
```php
$binance->tickerPrice();
```

<details>
<summary>View result</summary>

```text
[
    [
        'symbol' => 'LTCBTC',
        'price' => '4.00000200',
    ],
    [
        'symbol' => 'ETHBTC',
        'price' => '0.07946600',
    ]
]
```
</details>

### [Symbol Order Book Ticker](https://binance-docs.github.io/apidocs/spot/en/#symbol-order-book-ticker)
```php
$binance->tickerBookTicker('BTCUSDT');
```

<details>
<summary>View result</summary>

```text
[
    [
        'symbol' => 'LTCBTC',
        'bidPrice' => '4.00000000',
        'bidQty' => '431.00000000',
        'askPrice' => '4.00000200',
        'askQty' => '9.00000000',
    ],
    [
        'symbol' => 'ETHBTC',
        'bidPrice' => '0.07946700',
        'bidQty' => '9.00000000',
        'askPrice' => '100000.00000000',
        'askQty' => '1000.00000000',
    ]
]
```
</details>

### [Rolling window price change statistics](https://binance-docs.github.io/apidocs/spot/en/#rolling-window-price-change-statistics)
```php
$binance->ticker('BTCUSDT');
```

<details>
<summary>View result</summary>

```text
[
    [
        'symbol' => 'BTCUSDT',
        'priceChange' => '-154.13000000',
        'priceChangePercent' => '-0.740',
        'weightedAvgPrice' => '20677.46305250',
        'openPrice' => '20825.27000000',
        'highPrice' => '20972.46000000',
        'lowPrice' => '20327.92000000',
        'lastPrice' => '20671.14000000',
        'volume' => '72.65112300',
        'quoteVolume' => '1502240.91155513',
        'openTime' => 1655432400000,
        'closeTime' => 1655446835460,
        'firstId' => 11147809,
        'lastId' => 11149775,
        'count' => 1967,
        'customAdditional' => [
             'openTimeDate' => 'Sat, 15 Jul 2023 08:35:54 UTC',
             'closeTimeDate' => 'Sun, 16 Jul 2023 08:35:54 UTC'
        ]
    ],
    [
        'symbol' => 'BNBBTC',
        'priceChange' => '0.00008530',
        'priceChangePercent' => '0.823',
        'weightedAvgPrice' => '0.01043129',
        'openPrice' => '0.01036170',
        'highPrice' => '0.01049850',
        'lowPrice' => '0.01033870',
        'lastPrice' => '0.01044700',
        'volume' => '166.67000000',
        'quoteVolume' => '1.73858301',
        'openTime' => 1655432400000,
        'closeTime' => 1655446835460,
        'firstId' => 2351674,
        'lastId' => 2352034,
        'count' => 361,
        'customAdditional' => [
             'openTimeDate' => 'Sat, 15 Jul 2023 08:35:54 UTC',
             'closeTimeDate' => 'Sun, 16 Jul 2023 08:35:54 UTC'
        ]
    ]
]
```
</details>


## Spot Account/Trade

### [Test New Order](https://binance-docs.github.io/apidocs/spot/en/#test-new-order-trade)
```php
$binance->orderTest('BTCUSDT', 'BUY', 'MARKET', quantity: 1);
```

<details>
<summary>View result</summary>

```text
[]
```
</details>

### [New Order](https://binance-docs.github.io/apidocs/spot/en/#new-order-trade)
```php
$binance->order('BTCUSDT', 'BUY', 'MARKET', quantity: 1);
```

<details>
<summary>View result</summary>

```text
[
   'symbol' => 'BTCUSDT',
   'orderId' => 28,
   'orderListId' => -1,
   'clientOrderId' => '6gCrw2kRUAF9CvJDGP16IP',
   'transactTime' => 1507725176595,
   'price' => '0.00000000',
   'origQty' => '10.00000000',
   'executedQty' => '10.00000000',
   'cummulativeQuoteQty' => '10.00000000',
   'status' => 'FILLED',
   'timeInForce' => 'GTC',
   'type' => 'MARKET',
   'side' => 'SELL',
   'workingTime' => 1507725176595,
   'selfTradePreventionMode' => 'NONE',
   'fills' => [
      [
         'price' => '4000.00000000',
         'qty' => '1.00000000',
         'commission' => '4.00000000',
         'commissionAsset' => 'USDT',
         'tradeId' => 56,
      ],
      [
         'price' => '3999.00000000',
         'qty' => '5.00000000',
         'commission' => '19.99500000',
         'commissionAsset' => 'USDT',
         'tradeId' => 57,
      ],
      [
         'price' => '3998.00000000',
         'qty' => '2.00000000',
         'commission' => '7.99600000',
         'commissionAsset' => 'USDT',
         'tradeId' => 58,
      ],
      [
         'price' => '3997.00000000',
         'qty' => '1.00000000',
         'commission' => '3.99700000',
         'commissionAsset' => 'USDT',
         'tradeId' => 59,
      ],
      [
         'price' => '3995.00000000',
         'qty' => '1.00000000',
         'commission' => '3.99500000',
         'commissionAsset' => 'USDT',
         'tradeId' => 60,
      ],
   ],
   'customAdditional' => [
       'workingTimeDate' => 'Wed, 19 Jul 2023 06:55:37 UTC',
   ]
]
```
</details>

### [Cancel Order](https://binance-docs.github.io/apidocs/spot/en/#cancel-order-trade)
```php
$binance->cancelOrder('BTCUSDT', 1);
```

<details>
<summary>View result</summary>

```text
[
   'symbol' => 'LTCBTC',
   'origClientOrderId' => 'myOrder1',
   'orderId' => 4,
   'orderListId' => -1,
   'clientOrderId' => 'cancelMyOrder1',
   'transactTime' => 1684804350068,
   'price' => '2.00000000',
   'origQty' => '1.00000000',
   'executedQty' => '0.00000000',
   'cummulativeQuoteQty' => '0.00000000',
   'status' => 'CANCELED',
   'timeInForce' => 'GTC',
   'type' => 'LIMIT',
   'side' => 'BUY',
   'selfTradePreventionMode' => 'NONE',
   'customAdditional' => [
       'transactTimeDate' => 'Wed, 19 Jul 2023 06:55:37 UTC',
   ]
]
```
</details>

### [Cancel all Open Orders on a Symbol](https://binance-docs.github.io/apidocs/spot/en/#cancel-all-open-orders-on-a-symbol-trade)
```php
$binance->cancelOpenOrders('BTCUSDT');
```

<details>
<summary>View result</summary>

```text
[
   [
       'symbol' => 'BTCUSDT',
       'origClientOrderId' => 'E6APeyTJvkMvLMYMqu1KQ4',
       'orderId' => 11,
       'orderListId' => -1,
       'clientOrderId' => 'pXLV6Hz6mprAcVYpVMTGgx',
       'transactTime' => 1684804350068,
       'price' => '0.089853',
       'origQty' => '0.178622',
       'executedQty' => '0.000000',
       'cummulativeQuoteQty' => '0.000000',
       'status' => 'CANCELED',
       'timeInForce' => 'GTC',
       'type' => 'LIMIT',
       'side' => 'BUY',
       'selfTradePreventionMode' => 'NONE',
       'customAdditional' => [
           'transactTimeDate' => 'Wed, 19 Jul 2023 06:55:37 UTC',
       ]
   ],
   [
       'symbol' => 'BTCUSDT',
       'origClientOrderId' => 'A3EF2HCwxgZPFMrfwbgrhv',
       'orderId' => 13,
       'orderListId' => -1,
       'clientOrderId' => 'pXLV6Hz6mprAcVYpVMTGgx',
       'transactTime' => 1684804350069,
       'price' => '0.090430',
       'origQty' => '0.178622',
       'executedQty' => '0.000000',
       'cummulativeQuoteQty' => '0.000000',
       'status' => 'CANCELED',
       'timeInForce' => 'GTC',
       'type' => 'LIMIT',
       'side' => 'BUY',
       'selfTradePreventionMode' => 'NONE',
       'customAdditional' => [
           'transactTimeDate' => 'Wed, 19 Jul 2023 06:55:37 UTC',
       ]
   ],
   [
       'orderListId' => 1929,
       'contingencyType' => 'OCO',
       'listStatusType' => 'ALL_DONE',
       'listOrderStatus' => 'ALL_DONE',
       'listClientOrderId' => '2inzWQdDvZLHbbAmAozX2N',
       'transactionTime' => 1585230948299,
       'symbol' => 'BTCUSDT',
       'orders' => [
           [
               'symbol' => 'BTCUSDT',
               'orderId' => 20,
               'clientOrderId' => 'CwOOIPHSmYywx6jZX77TdL',
           ],
           [
               'symbol' => 'BTCUSDT',
               'orderId' => 21,
               'clientOrderId' => '461cPg51vQjV3zIMOXNz39',
           ],
       ],
       'orderReports' => [
           [
               'symbol' => 'BTCUSDT',
               'origClientOrderId' => 'CwOOIPHSmYywx6jZX77TdL',
               'orderId' => 20,
               'orderListId' => 1929,
               'clientOrderId' => 'pXLV6Hz6mprAcVYpVMTGgx',
               'transactTime' => 1688005070874,
               'price' => '0.668611',
               'origQty' => '0.690354',
               'executedQty' => '0.000000',
               'cummulativeQuoteQty' => '0.000000',
               'status' => 'CANCELED',
               'timeInForce' => 'GTC',
               'type' => 'STOP_LOSS_LIMIT',
               'side' => 'BUY',
               'stopPrice' => '0.378131',
               'icebergQty' => '0.017083',
               'selfTradePreventionMode' => 'NONE',
               'customAdditional' => [
                   'transactTimeDate' => 'Wed, 19 Jul 2023 06:55:37 UTC',
               ]
           ],
           [
               'symbol' => 'BTCUSDT',
               'origClientOrderId' => '461cPg51vQjV3zIMOXNz39',
               'orderId' => 21,
               'orderListId' => 1929,
               'clientOrderId' => 'pXLV6Hz6mprAcVYpVMTGgx',
               'transactTime' => 1688005070874,
               'price' => '0.008791',
               'origQty' => '0.690354',
               'executedQty' => '0.000000',
               'cummulativeQuoteQty' => '0.000000',
               'status' => 'CANCELED',
               'timeInForce' => 'GTC',
               'type' => 'LIMIT_MAKER',
               'side' => 'BUY',
               'icebergQty' => '0.017083',
               'selfTradePreventionMode' => 'NONE',
               'customAdditional' => [
                   'transactTimeDate' => 'Wed, 19 Jul 2023 06:55:37 UTC',
               ]
           ],
       ],
       'customAdditional' => [
           'transactionTimeDate' => 'Wed, 19 Jul 2023 06:55:37 UTC',
       ]
   ],
]
```
</details>

### [Query Order](https://binance-docs.github.io/apidocs/spot/en/#query-order-user_data)
```php
$binance->cancelOrder('getOrder', 1);
```

<details>
<summary>View result</summary>

```text
[
   'symbol' => 'LTCBTC',
   'orderId' => 1,
   'orderListId' => -1,
   'clientOrderId' => 'myOrder1',
   'price' => '0.1',
   'origQty' => '1.0',
   'executedQty' => '0.0',
   'cummulativeQuoteQty' => '0.0',
   'status' => 'NEW',
   'timeInForce' => 'GTC',
   'type' => 'LIMIT',
   'side' => 'BUY',
   'stopPrice' => '0.0',
   'icebergQty' => '0.0',
   'time' => 1499827319559,
   'updateTime' => 1499827319559,
   'isWorking' => true,
   'workingTime' => 1499827319559,
   'origQuoteOrderQty' => '0.000000',
   'selfTradePreventionMode' => 'NONE',
   'customAdditional' => [
       'timeDate' => 'Wed, 19 Jul 2023 06:55:37 UTC',
       'updateTimeDate' => 'Wed, 19 Jul 2023 06:55:37 UTC',
       'workingTimeDate' => 'Wed, 19 Jul 2023 06:55:37 UTC',
   ]
]
```
</details>

### [Cancel an Existing Order and Send a New Order](https://binance-docs.github.io/apidocs/spot/en/#cancel-an-existing-order-and-send-a-new-order-trade)
```php
$binance->orderCancelReplace('BTCUSDT', 'BUY', 'LIMIT', 'STOP_ON_FAILURE', 'GTC', 0.02, price: 20000, cancelOrderId: 6597357);
```

<details>
<summary>View result</summary>

```text
[
   'cancelResult' => 'SUCCESS',
   'newOrderResult' => 'SUCCESS',
   'cancelResponse' => [
      'symbol' => 'BTCUSDT',
      'origClientOrderId' => 'DnLo3vTAQcjha43lAZhZ0y',
      'orderId' => 9,
      'orderListId' => -1,
      'clientOrderId' => 'osxN3JXAtJvKvCqGeMWMVR',
      'transactTime' => 1684804350068,
      'price' => '0.01000000',
      'origQty' => '0.000100',
      'executedQty' => '0.00000000',
      'cummulativeQuoteQty' => '0.00000000',
      'status' => 'CANCELED',
      'timeInForce' => 'GTC',
      'type' => 'LIMIT',
      'side' => 'SELL',
      'selfTradePreventionMode' => 'NONE',
      'customAdditional' => [
          'transactTimeDate' => 'Wed, 19 Jul 2023 08:01:01 UTC',
      ]
   ],
      'newOrderResponse' => [
      'symbol' => 'BTCUSDT',
      'orderId' => 10,
      'orderListId' => -1,
      'clientOrderId' => 'wOceeeOzNORyLiQfw7jd8S',
      'transactTime' => 1652928801803,
      'price' => '0.02000000',
      'origQty' => '0.040000',
      'executedQty' => '0.00000000',
      'cummulativeQuoteQty' => '0.00000000',
      'status' => 'NEW',
      'timeInForce' => 'GTC',
      'type' => 'LIMIT',
      'side' => 'BUY',
      'workingTime' => 1669277163808,
      'fills' => [],
      'selfTradePreventionMode' => 'NONE',
      'customAdditional' => [
          'transactTimeDate' => 'Wed, 19 Jul 2023 08:01:01 UTC',
          'workingTimeDate' => 'Wed, 19 Jul 2023 08:01:01 UTC',
      ]
   ],
]
```
</details>

### [Current Open Orders](https://binance-docs.github.io/apidocs/spot/en/#current-open-orders-user_data)
```php
$binance->openOrders();
```

<details>
<summary>View result</summary>

```text
[
   [
       'symbol' => 'LTCBTC',
       'orderId' => 1,
       'orderListId' => -1,
       'clientOrderId' => 'myOrder1',
       'price' => '0.1',
       'origQty' => '1.0',
       'executedQty' => '0.0',
       'cummulativeQuoteQty' => '0.0',
       'status' => 'NEW',
       'timeInForce' => 'GTC',
       'type' => 'LIMIT',
       'side' => 'BUY',
       'stopPrice' => '0.0',
       'icebergQty' => '0.0',
       'time' => 1499827319559,
       'updateTime' => 1499827319559,
       'isWorking' => true,
       'workingTime' => 1499827319559,
       'origQuoteOrderQty' => '0.000000',
       'selfTradePreventionMode' => 'NONE',
       'customAdditional' => [
           'timeDate' => 'Wed, 19 Jul 2023 08:01:01 UTC',
           'updateTimeDate' => 'Wed, 19 Jul 2023 08:01:01 UTC',
           'workingTimeDate' => 'Wed, 19 Jul 2023 08:01:01 UTC',
       ]
   ]
]
```
</details>

### [All Orders](https://binance-docs.github.io/apidocs/spot/en/#all-orders-user_data)
```php
$binance->allOrders('BTCUSDT');
```

<details>
<summary>View result</summary>

```text
[
   [
       'symbol' => 'LTCBTC',
       'orderId' => 1,
       'orderListId' => -1,
       'clientOrderId' => 'myOrder1',
       'price' => '0.1',
       'origQty' => '1.0',
       'executedQty' => '0.0',
       'cummulativeQuoteQty' => '0.0',
       'status' => 'NEW',
       'timeInForce' => 'GTC',
       'type' => 'LIMIT',
       'side' => 'BUY',
       'stopPrice' => '0.0',
       'icebergQty' => '0.0',
       'time' => 1499827319559,
       'updateTime' => 1499827319559,
       'isWorking' => true,
       'workingTime' => 1499827319559,
       'origQuoteOrderQty' => '0.000000',
       'selfTradePreventionMode' => 'NONE',
       'customAdditional' => [
           'timeDate' => 'Wed, 19 Jul 2023 08:01:01 UTC',
           'updateTimeDate' => 'Wed, 19 Jul 2023 08:01:01 UTC',
           'workingTimeDate' => 'Wed, 19 Jul 2023 08:01:01 UTC',
       ]
   ]
]
```
</details>

### [New OCO](https://binance-docs.github.io/apidocs/spot/en/#new-oco-trade)
```php
$binance->orderOco();
```

<details>
<summary>View result</summary>

```text
[
   'orderListId' => 0,
   'contingencyType' => 'OCO',
   'listStatusType' => 'EXEC_STARTED',
   'listOrderStatus' => 'EXECUTING',
   'listClientOrderId' => 'JYVpp3F0f5CAG15DhtrqLp',
   'transactionTime' => 1563417480525,
   'symbol' => 'LTCBTC',
   'orders' => [
       [
           'symbol' => 'LTCBTC',
           'orderId' => 2,
           'clientOrderId' => 'Kk7sqHb9J6mJWTMDVW7Vos',
       ],
       [
           'symbol' => 'LTCBTC',
           'orderId' => 3,
           'clientOrderId' => 'xTXKaGYd4bluPVp78IVRvl',
       ],
   ],
   'orderReports' => [
       [
           'symbol' => 'LTCBTC',
           'orderId' => 2,
           'orderListId' => 0,
           'clientOrderId' => 'Kk7sqHb9J6mJWTMDVW7Vos',
           'transactTime' => 1563417480525,
           'price' => '0.00000000',
           'origQty' => '0.624363',
           'executedQty' => '0.000000',
           'cummulativeQuoteQty' => '0.000000',
           'status' => 'NEW',
           'timeInForce' => 'GTC',
           'type' => 'STOP_LOSS',
           'side' => 'BUY',
           'stopPrice' => '0.960664',
           'workingTime' => 1563417480525,
           'selfTradePreventionMode' => 'NONE',
       ],
       [
           'symbol' => 'LTCBTC',
           'orderId' => 3,
           'orderListId' => 0,
           'clientOrderId' => 'xTXKaGYd4bluPVp78IVRvl',
           'transactTime' => 1563417480525,
           'price' => '0.036435',
           'origQty' => '0.624363',
           'executedQty' => '0.000000',
           'cummulativeQuoteQty' => '0.000000',
           'status' => 'NEW',
           'timeInForce' => 'GTC',
           'type' => 'LIMIT_MAKER',
           'side' => 'BUY',
           'workingTime' => 1563417480525,
           'selfTradePreventionMode' => 'NONE',
       ]
   ]
]
```
</details>

### [Cancel OCO](https://binance-docs.github.io/apidocs/spot/en/#cancel-oco-trade)
```php
$binance->cancelOrderList('BTCUSDT', '1234');
```

<details>
<summary>View result</summary>

```text
[
   'orderListId' => 0,
   'contingencyType' => 'OCO',
   'listStatusType' => 'ALL_DONE',
   'listOrderStatus' => 'ALL_DONE',
   'listClientOrderId' => 'C3wyj4WVEktd7u9aVBRXcN',
   'transactionTime' => 1574040868128,
   'symbol' => 'LTCBTC',
   'orders' => [
       [
           'symbol' => 'LTCBTC',
           'orderId' => 2,
           'clientOrderId' => 'pO9ufTiFGg3nw2fOdgeOXa',
       ],
       [
           'symbol' => 'LTCBTC',
           'orderId' => 3,
           'clientOrderId' => 'TXOvglzXuaubXAaENpaRCB',
       ],
   ],
   'orderReports' => [
       [
           'symbol' => 'LTCBTC',
           'orderId' => 2,
           'orderListId' => 0,
           'clientOrderId' => 'unfWT8ig8i0uj6lPuYLez6',
           'transactTime' => 1688005070874,
           'price' => '1.00000000',
           'origQty' => '10.00000000',
           'executedQty' => '0.00000000',
           'cummulativeQuoteQty' => '0.00000000',
           'status' => 'CANCELED',
           'timeInForce' => 'GTC',
           'type' => 'STOP_LOSS_LIMIT',
           'side' => 'SELL',
           'stopPrice' => '1.00000000',
           'selfTradePreventionMode' => 'NONE',
       ],
       [
           'symbol' => 'LTCBTC',
           'origClientOrderId' => 'TXOvglzXuaubXAaENpaRCB',
           'orderId' => 3,
           'orderListId' => 0,
           'clientOrderId' => 'unfWT8ig8i0uj6lPuYLez6',
           'transactTime' => 1688005070874,
           'price' => '3.00000000',
           'origQty' => '10.00000000',
           'executedQty' => '0.000000',
           'cummulativeQuoteQty' => '0.000000',
           'status' => 'CANCELED',
           'timeInForce' => 'GTC',
           'type' => 'LIMIT_MAKER',
           'side' => 'SELL',
           'workingTime' => 1563417480525,
           'selfTradePreventionMode' => 'NONE',
       ]
   ]
]
```
</details>

### [Query OCO](https://binance-docs.github.io/apidocs/spot/en/#query-oco-user_data)
```php
$binance->orderList(27);
```

<details>
<summary>View result</summary>

```text
[
   'orderListId' => 27,
   'contingencyType' => 'OCO',
   'listStatusType' => 'EXEC_STARTED',
   'listOrderStatus' => 'EXECUTING',
   'listClientOrderId' => 'h2USkA5YQpaXHPIrkd96xE',
   'transactionTime' => 1565245656253,
   'symbol' => 'LTCBTC',
   'orders' => [
       [
           'symbol' => 'LTCBTC',
           'orderId' => 4,
           'clientOrderId' => 'qD1gy3kc3Gx0rihm9Y3xwS',
       ],
       [
           'symbol' => 'LTCBTC',
           'orderId' => 5,
           'clientOrderId' => 'ARzZ9I00CPM8i3NhmU9Ega',
       ],
   ],
]
```
</details>

### [Query all OCO](https://binance-docs.github.io/apidocs/spot/en/#query-all-oco-user_data)
```php
$binance->allOrderList();
```

<details>
<summary>View result</summary>

```text
[
   [
       'orderListId' => 29,
       'contingencyType' => 'OCO',
       'listStatusType' => 'EXEC_STARTED',
       'listOrderStatus' => 'EXECUTING',
       'listClientOrderId' => 'amEEAXryFzFwYF1FeRpUoZ',
       'transactionTime' => 1565245913483,
       'symbol' => 'LTCBTC',
       'orders' => [
           [
               'symbol' => 'LTCBTC',
               'orderId' => 4,
               'clientOrderId' => 'oD7aesZqjEGlZrbtRpy5zB',
           ],
           [
               'symbol' => 'LTCBTC',
               'orderId' => 5,
               'clientOrderId' => 'Jr1h6xirOxgeJOUuYQS7V3',
           ],
       ],
   ],
   [
       'orderListId' => 28,
       'contingencyType' => 'OCO',
       'listStatusType' => 'EXEC_STARTED',
       'listOrderStatus' => 'EXECUTING',
       'listClientOrderId' => 'hG7hFNxJV6cZy3Ze4AUT4d',
       'transactionTime' => 1565245913407,
       'symbol' => 'LTCBTC',
       'orders' => [
           [
               'symbol' => 'LTCBTC',
               'orderId' => 2,
               'clientOrderId' => 'j6lFOfbmFMRjTYA7rRJ0LP',
           ],
           [
               'symbol' => 'LTCBTC',
               'orderId' => 3,
               'clientOrderId' => 'z0KCjOdditiLS5ekAFtK81',
           ],
       ],
   ]
]
```
</details>

### [Query Open OCO](https://binance-docs.github.io/apidocs/spot/en/#query-open-oco-user_data)
```php
$binance->openOrderList();
```

<details>
<summary>View result</summary>

```text
[
   [
       'orderListId' => 31,
       'contingencyType' => 'OCO',
       'listStatusType' => 'EXEC_STARTED',
       'listOrderStatus' => 'EXECUTING',
       'listClientOrderId' => 'wuB13fmulKj3YjdqWEcsnp',
       'transactionTime' => 1565246080644,
       'symbol' => 'LTCBTC',
       'orders' => [
           [
               'symbol' => 'LTCBTC',
               'orderId' => 4,
               'clientOrderId' => 'r3EH2N76dHfLoSZWIUw1bT',
           ],
           [
               'symbol' => 'LTCBTC',
               'orderId' => 5,
               'clientOrderId' => 'Cv1SnyPD3qhqpbjpYEHbd2',
           ],
       ],
   ]
]
```
</details>

### [Account Information](https://binance-docs.github.io/apidocs/spot/en/#account-information-user_data)
```php
$binance->account();
```

<details>
<summary>View result</summary>

```text
[
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
]
```
</details>

### [Account Trade List](https://binance-docs.github.io/apidocs/spot/en/#account-trade-list-user_data)
```php
$binance->myTrades('BTCUSDT');
```

<details>
<summary>View result</summary>

```text
[
   [
       'symbol' => 'BNBBTC',
       'id' => 28457,
       'orderId' => 100234,
       'orderListId' => -1,
       'price' => '4.00000100',
       'qty' => '12.00000000',
       'quoteQty' => '48.000012',
       'commission' => '10.10000000',
       'commissionAsset' => 'BNB',
       'time' => 1499865549590,
       'isBuyer' => true,
       'isMaker' => false,
       'isBestMatch' => true,
   ]
]
```
</details>

### [Query Current Order Count Usage](https://binance-docs.github.io/apidocs/spot/en/#query-current-order-count-usage-trade)
```php
$binance->rateLimitOrder();
```

<details>
<summary>View result</summary>

```text
[
   [
       'rateLimitType' => 'ORDERS',
       'interval' => 'SECOND',
       'intervalNum' => 10,
       'limit' => 10000,
       'count' => 0,
   ],
   [
       'rateLimitType' => 'ORDERS',
       'interval' => 'DAY',
       'intervalNum' => 1,
       'limit' => 20000,
       'count' => 0,
   ]
]
```
</details>

### [Query Prevented Matches](https://binance-docs.github.io/apidocs/spot/en/#query-prevented-matches-user_data)
```php
$binance->myPreventedMatches('BTCUSDT');
```

<details>
<summary>View result</summary>

```text
[
   [
       'symbol' => 'BTCUSDT',
       'preventedMatchId' => 1,
       'takerOrderId' => 5,
       'makerOrderId' => 3,
       'tradeGroupId' => 1,
       'selfTradePreventionMode' => 'EXPIRE_MAKER',
       'price' => '1.100000',
       'makerPreventedQuantity' => '1.300000',
       'transactTime' => 1669101687094,
   ],
]
```
</details>