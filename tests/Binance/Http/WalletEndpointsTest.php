<?php

namespace BinanceApi\Tests\Binance\Http;

use BinanceApi\Exception\BinanceException;
use BinanceApi\Helper\Carbon;
use BinanceApi\Spot\Binance;
use BinanceApi\Spot\Docs\Const\BinanceApi\ProcessResponse;
use BinanceApi\Spot\Docs\GeneralInfo\Signed;
use BinanceApi\Spot\Docs\WalletEndpoints\AccountAPITradingStatus;
use BinanceApi\Spot\Docs\WalletEndpoints\AccountStatus;
use BinanceApi\Spot\Docs\WalletEndpoints\AllCoinsInformation;
use BinanceApi\Spot\Docs\WalletEndpoints\AssetDetail;
use BinanceApi\Spot\Docs\WalletEndpoints\AssetDividendRecord;
use BinanceApi\Spot\Docs\WalletEndpoints\BusdConvert;
use BinanceApi\Spot\Docs\WalletEndpoints\BusdConvertHistory;
use BinanceApi\Spot\Docs\WalletEndpoints\DailyAccountSnapshot;
use BinanceApi\Spot\Docs\WalletEndpoints\DepositAddress;
use BinanceApi\Spot\Docs\WalletEndpoints\DepositHistory;
use BinanceApi\Spot\Docs\WalletEndpoints\DisableFastWithdrawSwitch;
use BinanceApi\Spot\Docs\WalletEndpoints\DustLog;
use BinanceApi\Spot\Docs\WalletEndpoints\DustTransfer;
use BinanceApi\Spot\Docs\WalletEndpoints\EnableFastWithdrawSwitch;
use BinanceApi\Spot\Docs\WalletEndpoints\FundingWallet;
use BinanceApi\Spot\Docs\WalletEndpoints\GetApiKeyPermission;
use BinanceApi\Spot\Docs\WalletEndpoints\GetAssetsThatCanBeConvertedIntoBnb;
use BinanceApi\Spot\Docs\WalletEndpoints\GetCloudMiningPaymentAndRefundHistory;
use BinanceApi\Spot\Docs\WalletEndpoints\OneClickArrivalDepositApply;
use BinanceApi\Spot\Docs\WalletEndpoints\QueryAutoConvertingStableCoins;
use BinanceApi\Spot\Docs\WalletEndpoints\QueryUserUniversalTransferHistory;
use BinanceApi\Spot\Docs\WalletEndpoints\SwitchOnOffBusdAndStableCoinsConversion;
use BinanceApi\Spot\Docs\WalletEndpoints\SystemStatus;
use BinanceApi\Spot\Docs\WalletEndpoints\TradeFee;
use BinanceApi\Spot\Docs\WalletEndpoints\UserAsset;
use BinanceApi\Spot\Docs\WalletEndpoints\UserUniversalTransfer;
use BinanceApi\Spot\Docs\WalletEndpoints\Withdraw;
use BinanceApi\Spot\Docs\WalletEndpoints\WithdrawHistory;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class WalletEndpointsTest extends TestCase
{
    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->client = $this->createMock(Client::class);

        $this->binance = new Binance(client: $this->client);
    }

    public function test_http_system_status()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('GET'),
                $this->equalTo('https://api.binance.com/sapi/v1/system/status'),
                $this->equalTo([])
            )
            ->willReturn(new Response(body: SystemStatus::exampleResponse()));

        $this->assertEquals(
            json_decode(SystemStatus::exampleResponse(), true),
            $this->binance->systemStatus()['response']['data']
        );
    }

    public function test_all_coins_information_need_signature()
    {
        $this->expectException(BinanceException::class);

        $this->binance->capitalConfigGetall()['response']['data'];
    }

    public function test_http_all_coins_information()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('GET'),
                $this->equalTo('https://api.binance.com/sapi/v1/capital/config/getall'),
                $this->callback(function ($options) {
                    return $this->checkSignatureInGetRequest($options) && $options['query']['recvWindow'] == '5000';
                }),
            )
            ->willReturn(new Response(body: AllCoinsInformation::exampleResponse()));

        $this->binance->setApiKeys('apiKey', 'apiSecret');

        $this->assertEquals(
            json_decode(AllCoinsInformation::exampleResponse(), true),
            $this->binance->capitalConfigGetall('5000')['response']['data']
        );
    }

    public function test_http_daily_account_snapshot()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('GET'),
                $this->equalTo('https://api.binance.com/sapi/v1/accountSnapshot'),
                $this->callback(function ($options) {
                    return $this->checkSignatureInGetRequest($options) && $options['query']['type'] == 'SPOT';
                }),
            )
            ->willReturn(new Response(body: DailyAccountSnapshot::exampleResponse()['firstVersion']));

        $this->binance->setApiKeys('apiKey', 'apiSecret');

        $response = json_decode(DailyAccountSnapshot::exampleResponse()['firstVersion'], true);
        $result = [
            'code' => $response['code'],
            'msg' => $response['msg'],
            'snapshotVos' => array_map(/**
             * @throws \Exception
             */ function ($item) {
                $item['customAdditional']['updateTimeDate'] = Carbon::getFullDate($item['updateTime']);

                return $item;
            }, $response['snapshotVos'])
        ];

        $this->assertEquals($result, $this->binance->accountSnapshot()['response']['data']);
    }

    public function test_http_disable_fast_withdraw_switch()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('POST'),
                $this->equalTo('https://api.binance.com/sapi/v1/account/disableFastWithdrawSwitch'),
                $this->callback(function ($options) {
                    return $this->checkSignatureInPostRequest($options) && $options['form_params']['recvWindow'] == '5000';
                }),
            )
            ->willReturn(new Response(body: DisableFastWithdrawSwitch::exampleResponse()));

        $this->binance->setApiKeys('apiKey', 'apiSecret');

        $this->assertEquals(
            json_decode(DisableFastWithdrawSwitch::exampleResponse(), true),
            $this->binance->accountDisableFastWithdrawSwitch(5000)['response']['data']
        );
    }

    public function test_http_enable_fast_withdraw_switch()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('POST'),
                $this->equalTo('https://api.binance.com/sapi/v1/account/enableFastWithdrawSwitch'),
                $this->callback(function ($options) {
                    return $this->checkSignatureInPostRequest($options) && $options['form_params']['recvWindow'] == '5000';
                }),
            )
            ->willReturn(new Response(body: EnableFastWithdrawSwitch::exampleResponse()));

        $this->binance->setApiKeys('apiKey', 'apiSecret');

        $this->assertEquals(
            json_decode(EnableFastWithdrawSwitch::exampleResponse(), true),
            $this->binance->accountEnableFastWithdrawSwitch(5000)['response']['data']
        );
    }

    public function test_withdraw_mandatory_parameters()
    {
        $this->expectException(BinanceException::class);

        $this->binance->capitalWithdrawApply()['response']['data'];
    }

    public function test_http_withdraw()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('POST'),
                $this->equalTo('https://api.binance.com/sapi/v1/capital/withdraw/apply'),
                $this->callback(function ($options) {
                    return $this->checkSignatureInPostRequest($options) &&
                        $options['form_params']['coin'] == 'USDT' &&
                        $options['form_params']['address'] == 'TPKiaNqAzu2NYkd2ptqcgtp57DVBZ9P7ui' &&
                        $options['form_params']['amount'] == 20;
                }),
            )
            ->willReturn(new Response(body: Withdraw::exampleResponse()));

        $this->binance->setApiKeys('apiKey', 'apiSecret');

        $this->assertEquals(
            json_decode(Withdraw::exampleResponse(), true),
            $this->binance->capitalWithdrawApply('USDT', 'TPKiaNqAzu2NYkd2ptqcgtp57DVBZ9P7ui', 20, network: 'TRX')['response']['data']
        );
    }

    public function test_http_deposit_history()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('GET'),
                $this->equalTo('https://api.binance.com/sapi/v1/capital/deposit/hisrec'),
                $this->callback(function ($options) {
                    return $this->checkSignatureInGetRequest($options) &&
                        $options['query']['coin'] == 'USDT' &&
                        $options['query']['status'] == '2' &&
                        $options['query']['startTime'] == '1599620082000' &&
                        $options['query']['endTime'] == '1599620082000' &&
                        $options['query']['offset'] == '0' &&
                        $options['query']['limit'] == 100 &&
                        $options['query']['recvWindow'] == 5000 &&
                        $options['query']['txId'] == 'ESBFVQUTPIWQNJSPXFNHNYHSQNTGKRVKPRABQWTAXCDWOAKDKYWPTVG9BGXNVNKTLEJGESAVXIKIZ9999';
                }),
            )
            ->willReturn(new Response(body: DepositHistory::exampleResponse()));

        $this->binance->setApiKeys('apiKey', 'apiSecret');

        $this->assertEquals(
            array_map(/**
             * @throws \Exception
             */ function ($item) {
                $item['customAdditional']['insertTimeDate'] = Carbon::getFullDate($item['insertTime']);

                return $item;
            }, json_decode(DepositHistory::exampleResponse(), true)),
            $this->binance->capitalDepositHisrec(
                'USDT',
                '2',
                '1599620082000',
                '1599620082000',
                '0',
                100,
                5000,
                'ESBFVQUTPIWQNJSPXFNHNYHSQNTGKRVKPRABQWTAXCDWOAKDKYWPTVG9BGXNVNKTLEJGESAVXIKIZ9999'
            )['response']['data']
        );
    }

    public function test_http_withdraw_history()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('GET'),
                $this->equalTo('https://api.binance.com/sapi/v1/capital/withdraw/history'),
                $this->callback(function ($options) {
                    return $this->checkSignatureInGetRequest($options) &&
                        $options['query']['coin'] == 'USDT' &&
                        $options['query']['status'] == '2' &&
                        $options['query']['startTime'] == '1599620082000' &&
                        $options['query']['endTime'] == '1599620082000' &&
                        $options['query']['offset'] == '0' &&
                        $options['query']['limit'] == 100 &&
                        $options['query']['recvWindow'] == 5000 &&
                        $options['query']['withdrawOrderId'] == 'ESBFVQUTPIWQNJSPXFNHNYHSQNTGKRVKPRABQWTAXCDWOAKDKYWPTVG9BGXNVNKTLEJGESAVXIKIZ9999';
                }),
            )
            ->willReturn(new Response(body: WithdrawHistory::exampleResponse()));

        $this->binance->setApiKeys('apiKey', 'apiSecret');

        $this->assertEquals(
            json_decode(WithdrawHistory::exampleResponse(), true),
            $this->binance->capitalWithdrawHistory(
                'USDT',
                'ESBFVQUTPIWQNJSPXFNHNYHSQNTGKRVKPRABQWTAXCDWOAKDKYWPTVG9BGXNVNKTLEJGESAVXIKIZ9999',
                '0',
                100,
                '2',
                '1599620082000',
                '1599620082000',
                5000,
            )['response']['data']
        );
    }

    public function test_http_deposit_address()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('GET'),
                $this->equalTo('https://api.binance.com/sapi/v1/capital/deposit/address'),
                $this->callback(function ($options) {
                    return $this->checkSignatureInGetRequest($options) &&
                        $options['query']['coin'] == 'USDT' &&
                        $options['query']['network'] == 'TRX' &&
                        $options['query']['recvWindow'] == 5000;
                }),
            )
            ->willReturn(new Response(body: DepositAddress::exampleResponse()));

        $this->binance->setApiKeys('apiKey', 'apiSecret');

        $this->assertEquals(
            json_decode(DepositAddress::exampleResponse(), true),
            $this->binance->capitalDepositAddress('USDT', 'TRX', 5000)['response']['data']
        );
    }

    public function test_http_account_status()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('GET'),
                $this->equalTo('https://api.binance.com/sapi/v1/account/status'),
                $this->callback(function ($options) {
                    return $this->checkSignatureInGetRequest($options) && $options['query']['recvWindow'] == '5000';
                }),
            )
            ->willReturn(new Response(body: AccountStatus::exampleResponse()));

        $this->binance->setApiKeys('apiKey', 'apiSecret');

        $this->assertEquals(
            json_decode(AccountStatus::exampleResponse(), true),
            $this->binance->accountStatus(5000)['response']['data']
        );
    }

    /**
     * @throws \Exception
     */
    public function test_http_account_api_trading_status()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('GET'),
                $this->equalTo('https://api.binance.com/sapi/v1/account/apiTradingStatus'),
                $this->callback(function ($options) {
                    return $this->checkSignatureInGetRequest($options) && $options['query']['recvWindow'] == '5000';
                }),
            )
            ->willReturn(new Response(body: AccountAPITradingStatus::exampleResponse()));

        $this->binance->setApiKeys('apiKey', 'apiSecret');

        $result = json_decode(AccountAPITradingStatus::exampleResponse(), true);

        $result['data']['customAdditional']['updateTimeDate'] = Carbon::getFullDate(1547630471725);

        $this->assertEquals(
            $result,
            $this->binance->accountApiTradingStatus(5000)['response']['data']
        );
    }

    public function test_http_dust_log()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('GET'),
                $this->equalTo('https://api.binance.com/sapi/v1/asset/dribblet'),
                $this->callback(function ($options) {
                    return $this->checkSignatureInGetRequest($options) &&
                        $options['query']['startTime'] == '1599620082000' &&
                        $options['query']['endTime'] == '1599620082000' &&
                        $options['query']['recvWindow'] == '5000';
                }),
            )
            ->willReturn(new Response(body: DustLog::exampleResponse()));

        $this->binance->setApiKeys('apiKey', 'apiSecret');

        $result = json_decode(DustLog::exampleResponse(), true);

        $result['userAssetDribblets'] = array_map(/**
         * @throws \Exception
         */ function ($item) {
            $item['userAssetDribbletDetails'] = array_map(/**
             * @throws \Exception
             */ function ($item) {
                $item[ProcessResponse::ADDITIONAL_FIELD]['operateTimeDate'] = Carbon::getFullDate(1615985535000);

                return $item;
            }, $item['userAssetDribbletDetails']);

            $item[ProcessResponse::ADDITIONAL_FIELD]['operateTimeDate'] = Carbon::getFullDate(1615985535000);

            return $item;
        }, $result['userAssetDribblets']);

        $this->assertEquals(
            $result,
            $this->binance->assetDribblet(1599620082000, 1599620082000, 5000)['response']['data']
        );
    }

    public function test_http_get_assets_that_can_be_converted_into_bnb()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('POST'),
                $this->equalTo('https://api.binance.com/sapi/v1/asset/dust-btc'),
                $this->callback(function ($options) {
                    return $this->checkSignatureInPostRequest($options) && $options['form_params']['recvWindow'] == '5000';
                }),
            )
            ->willReturn(new Response(body: GetAssetsThatCanBeConvertedIntoBnb::exampleResponse()));

        $this->binance->setApiKeys('apiKey', 'apiSecret');

        $this->assertEquals(
            json_decode(GetAssetsThatCanBeConvertedIntoBnb::exampleResponse(), true),
            $this->binance->assetDustBtc(5000)['response']['data']
        );
    }

    public function test_http_dust_transfer()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('POST'),
                $this->equalTo('https://api.binance.com/sapi/v1/asset/dust'),
                $this->callback(function ($options) {
                    return $this->checkSignatureInPostRequest($options) &&
                        $options['form_params']['asset'] == 'BTC,ETH' &&
                        $options['form_params']['recvWindow'] == '5000';
                }),
            )
            ->willReturn(new Response(body: DustTransfer::exampleResponse()));

        $this->binance->setApiKeys('apiKey', 'apiSecret');

        $result = json_decode(DustTransfer::exampleResponse(), true);

        $result['transferResult'] = array_map(/**
         * @throws \Exception
         */ function ($item) {
            $item[ProcessResponse::ADDITIONAL_FIELD]['operateTimeDate'] = Carbon::getFullDate($item['operateTime']);

            return $item;
        }, $result['transferResult']);

        $this->assertEquals(
            $result,
            $this->binance->assetDust(['BTC', 'ETH'], 5000)['response']['data']
        );
    }

    public function test_http_asset_dividend_record()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('GET'),
                $this->equalTo('https://api.binance.com/sapi/v1/asset/assetDividend'),
                $this->callback(function ($options) {
                    return $this->checkSignatureInGetRequest($options) &&
                        $options['query']['asset'] == 'BTC' &&
                        $options['query']['startTime'] == 1563189166000 &&
                        $options['query']['endTime'] == 1563189166000 &&
                        $options['query']['limit'] == 30 &&
                        $options['query']['recvWindow'] == '5000';
                }),
            )
            ->willReturn(new Response(body: AssetDividendRecord::exampleResponse()));

        $this->binance->setApiKeys('apiKey', 'apiSecret');

        $result = json_decode(AssetDividendRecord::exampleResponse(), true);

        $result['rows'] = array_map(/**
         * @throws \Exception
         */ function ($item) {
            $item[ProcessResponse::ADDITIONAL_FIELD]['divTimeDate'] = Carbon::getFullDate($item['divTime']);

            return $item;
        }, $result['rows']);

        $this->assertEquals(
            $result,
            $this->binance->assetAssetDividend('BTC', 1563189166000, 1563189166000, 30, 5000)['response']['data']
        );
    }

    public function test_http_asset_detail()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('GET'),
                $this->equalTo('https://api.binance.com/sapi/v1/asset/assetDetail'),
                $this->callback(function ($options) {
                    return $this->checkSignatureInGetRequest($options) &&
                        $options['query']['asset'] == 'BTC' &&
                        $options['query']['recvWindow'] == '5000';
                }),
            )
            ->willReturn(new Response(body: AssetDetail::exampleResponse()));

        $this->binance->setApiKeys('apiKey', 'apiSecret');

        $this->assertEquals(
            json_decode(AssetDetail::exampleResponse(), true),
            $this->binance->assetAssetDetail('BTC', 5000)['response']['data']
        );
    }

    public function test_http_trade_fee()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('GET'),
                $this->equalTo('https://api.binance.com/sapi/v1/asset/tradeFee'),
                $this->callback(function ($options) {
                    return $this->checkSignatureInGetRequest($options) &&
                        $options['query']['symbol'] == 'BTCUSDT' &&
                        $options['query']['recvWindow'] == '5000';
                }),
            )
            ->willReturn(new Response(body: TradeFee::exampleResponse()));

        $this->binance->setApiKeys('apiKey', 'apiSecret');

        $this->assertEquals(
            json_decode(TradeFee::exampleResponse(), true),
            $this->binance->assetTradeFee('BTCUSDT', 5000)['response']['data']
        );
    }

    public function test_http_user_universal_transfer()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('POST'),
                $this->equalTo('https://api.binance.com/sapi/v1/asset/transfer'),
                $this->callback(function ($options) {
                    return $this->checkSignatureInPostRequest($options) &&
                        $options['form_params']['type'] == 'MAIN_UMFUTURE' &&
                        $options['form_params']['asset'] == 'USDT' &&
                        $options['form_params']['amount'] == '100' &&
                        $options['form_params']['fromSymbol'] == 'BTC' &&
                        $options['form_params']['toSymbol'] == 'USDT' &&
                        $options['form_params']['recvWindow'] == '5000';
                }),
            )
            ->willReturn(new Response(body: UserUniversalTransfer::exampleResponse()));

        $this->binance->setApiKeys('apiKey', 'apiSecret');

        $this->assertEquals(
            json_decode(UserUniversalTransfer::exampleResponse(), true),
            $this->binance->assetTransfer('MAIN_UMFUTURE', 'USDT', 100, 'BTC', 'USDT', 5000)['response']['data']
        );
    }

    public function test_http_query_user_universal_transfer_history()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('GET'),
                $this->equalTo('https://api.binance.com/sapi/v1/asset/transfer'),
                $this->callback(function ($options) {
                    return $this->checkSignatureInGetRequest($options) &&
                        $options['query']['type'] == 'MAIN_UMFUTURE' &&
                        $options['query']['startTime'] == '1544433328000' &&
                        $options['query']['endTime'] == '1544433328000' &&
                        $options['query']['current'] == 2 &&
                        $options['query']['size'] == 15 &&
                        $options['query']['fromSymbol'] == 'BTC' &&
                        $options['query']['toSymbol'] == 'USDT' &&
                        $options['query']['recvWindow'] == '5000';
                }),
            )
            ->willReturn(new Response(body: QueryUserUniversalTransferHistory::exampleResponse()));

        $this->binance->setApiKeys('apiKey', 'apiSecret');

        $result = json_decode(QueryUserUniversalTransferHistory::exampleResponse(), true);

        $result['rows'] = array_map(/**
         * @throws \Exception
         */ function ($item) {
            $item[ProcessResponse::ADDITIONAL_FIELD]['timestampDate'] = Carbon::getFullDate($item['timestamp']);

            return $item;
        }, $result['rows']);

        $this->assertEquals(
            $result,
            $this->binance->getAssetTransfer('MAIN_UMFUTURE', 1544433328000, 1544433328000, 2, 15, 'BTC', 'USDT', 5000)['response']['data']
        );
    }

    public function test_http_funding_wallet()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('POST'),
                $this->equalTo('https://api.binance.com/sapi/v1/asset/get-funding-asset'),
                $this->callback(function ($options) {
                    return $this->checkSignatureInPostRequest($options) &&
                        $options['form_params']['asset'] == 'USDT' &&
                        $options['form_params']['needBtcValuation'] == 'true' &&
                        $options['form_params']['recvWindow'] == '5000';
                }),
            )
            ->willReturn(new Response(body: FundingWallet::exampleResponse()));

        $this->binance->setApiKeys('apiKey', 'apiSecret');

        $this->assertEquals(
            json_decode(FundingWallet::exampleResponse(), true),
            $this->binance->assetGetFundingAsset('USDT', 'true', 5000)['response']['data']
        );
    }

    public function test_http_user_asset()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('POST'),
                $this->equalTo('https://api.binance.com/sapi/v3/asset/getUserAsset'),
                $this->callback(function ($options) {
                    return $this->checkSignatureInPostRequest($options) &&
                        $options['form_params']['asset'] == 'USDT' &&
                        $options['form_params']['needBtcValuation'] == 'true' &&
                        $options['form_params']['recvWindow'] == '5000';
                }),
            )
            ->willReturn(new Response(body: UserAsset::exampleResponse()));

        $this->binance->setApiKeys('apiKey', 'apiSecret');

        $this->assertEquals(
            json_decode(UserAsset::exampleResponse(), true),
            $this->binance->assetGetUserAsset('USDT', 'true', 5000)['response']['data']
        );
    }

    public function test_http_busd_convert()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('POST'),
                $this->equalTo('https://api.binance.com/sapi/v1/asset/convert-transfer'),
                $this->callback(function ($options) {
                    return $this->checkSignatureInPostRequest($options) &&
                        $options['form_params']['clientTranId'] == 'uniquetransactionuseridwithminlenght' &&
                        $options['form_params']['asset'] == 'USDT' &&
                        $options['form_params']['amount'] == '10' &&
                        $options['form_params']['targetAsset'] == 'BTC' &&
                        $options['form_params']['accountType'] == 'MAIN';
                }),
            )
            ->willReturn(new Response(body: BusdConvert::exampleResponse()));

        $this->binance->setApiKeys('apiKey', 'apiSecret');

        $this->assertEquals(
            json_decode(BusdConvert::exampleResponse(), true),
            $this->binance->assetConvertTransfer('uniquetransactionuseridwithminlenght', 'USDT', '10', 'BTC', 'MAIN')['response']['data']
        );
    }

    public function test_http_busd_convert_history()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('GET'),
                $this->equalTo('https://api.binance.com/sapi/v1/asset/convert-transfer/queryByPage'),
                $this->callback(function ($options) {
                    return $this->checkSignatureInGetRequest($options) &&
                        $options['query']['tranId'] == 'transactionid' &&
                        $options['query']['clientTranId'] == 'clientid' &&
                        $options['query']['asset'] == 'USDT' &&
                        $options['query']['startTime'] == '1664442078000' &&
                        $options['query']['endTime'] == '1664442078000' &&
                        $options['query']['accountType'] == 'MAIN' &&
                        $options['query']['current'] == 2 &&
                        $options['query']['size'] == 20;
                }),
            )
            ->willReturn(new Response(body: BusdConvertHistory::exampleResponse()));

        $this->binance->setApiKeys('apiKey', 'apiSecret');

        $result = json_decode(BusdConvertHistory::exampleResponse(), true);

        $result['rows'] = array_map(/**
         * @throws \Exception
         */ function ($item) {
            $item[ProcessResponse::ADDITIONAL_FIELD]['timeDate'] = Carbon::getFullDate($item['time']);

            return $item;
        }, $result['rows']);

        $this->assertEquals(
            $result,
            $this->binance->assetConvertTransferQueryByPage('transactionid', 'clientid', 'USDT', 1664442078000, 1664442078000, 'MAIN', 2, 20)['response']['data']
        );
    }

    public function test_http_get_cloud_mining_payment_and_refund_history()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('GET'),
                $this->equalTo('https://api.binance.com/sapi/v1/asset/ledger-transfer/cloud-mining/queryByPage'),
                $this->callback(function ($options) {
                    return $this->checkSignatureInGetRequest($options) &&
                        $options['query']['tranId'] == 'transactionid' &&
                        $options['query']['clientTranId'] == 'clientid' &&
                        $options['query']['asset'] == 'USDT' &&
                        $options['query']['startTime'] == '1664442078000' &&
                        $options['query']['endTime'] == '1664442078000' &&
                        $options['query']['current'] == 2 &&
                        $options['query']['size'] == 20;
                }),
            )
            ->willReturn(new Response(body: GetCloudMiningPaymentAndRefundHistory::exampleResponse()));

        $this->binance->setApiKeys('apiKey', 'apiSecret');

        $result = json_decode(GetCloudMiningPaymentAndRefundHistory::exampleResponse(), true);

        $result['rows'] = array_map(/**
         * @throws \Exception
         */ function ($item) {
            $item[ProcessResponse::ADDITIONAL_FIELD]['createTimeDate'] = Carbon::getFullDate($item['createTime']);

            return $item;
        }, $result['rows']);

        $this->assertEquals(
            $result,
            $this->binance->assetLedgerTransferCloudMiningQueryByPage('transactionid', 'clientid', 'USDT', 1664442078000, 1664442078000, 2, 20)['response']['data']
        );
    }

    /**
     * @throws \Exception
     */
    public function test_http_get_api_key_permission()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('GET'),
                $this->equalTo('https://api.binance.com/sapi/v1/account/apiRestrictions'),
                $this->callback(function ($options) {
                    return $this->checkSignatureInGetRequest($options) && $options['query']['recvWindow'] == '5000';
                }),
            )
            ->willReturn(new Response(body: GetApiKeyPermission::exampleResponse()));

        $this->binance->setApiKeys('apiKey', 'apiSecret');

        $result = json_decode(GetApiKeyPermission::exampleResponse(), true);

        $result[ProcessResponse::ADDITIONAL_FIELD] = [
            'createTimeDate' => Carbon::getFullDate($result['createTime']),
            'tradingAuthorityExpirationTimeDate' => Carbon::getFullDate($result['tradingAuthorityExpirationTime']),
        ];

        $this->assertEquals(
            $result,
            $this->binance->accountApiRestrictions(5000)['response']['data']
        );
    }

    public function test_http_query_auto_converting_stable_coins()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('GET'),
                $this->equalTo('https://api.binance.com/sapi/v1/capital/contract/convertible-coins'),
                $this->callback(function ($options) {
                    return $this->checkSignatureInGetRequest($options);
                }),
            )
            ->willReturn(new Response(body: QueryAutoConvertingStableCoins::exampleResponse()));

        $this->binance->setApiKeys('apiKey', 'apiSecret');

        $this->assertEquals(
            json_decode(QueryAutoConvertingStableCoins::exampleResponse(), true),
            $this->binance->capitalContractConvertibleCoins()['response']['data']
        );
    }

    public function test_http_switch_on_off_busd_and_stable_coins_conversion()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('POST'),
                $this->equalTo('https://api.binance.com/sapi/v1/capital/contract/convertible-coins'),
                $this->callback(function ($options) {
                    return $this->checkSignatureInPostRequest($options) &&
                        $options['form_params']['coin'] == 'USDC' &&
                        $options['form_params']['enable'] == false;
                }),
            )
            ->willReturn(new Response(body: SwitchOnOffBusdAndStableCoinsConversion::exampleResponse()));

        $this->binance->setApiKeys('apiKey', 'apiSecret');

        $this->assertEquals(
            SwitchOnOffBusdAndStableCoinsConversion::exampleResponse(),
            $this->binance->switchCapitalContractConvertibleCoins('USDC', false)['response']['data']
        );
    }

    public function test_http_one_click_arrival_deposit_apply()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('POST'),
                $this->equalTo('https://api.binance.com/sapi/v1/capital/deposit/credit-apply'),
                $this->callback(function ($options) {
                    return $this->checkSignatureInPostRequest($options) &&
                        $options['form_params']['depositId'] == 'depositId' &&
                        $options['form_params']['txId'] == 'txId' &&
                        $options['form_params']['subAccountId'] == 'subAccountId' &&
                        $options['form_params']['subUserId'] == 'subUserId';
                }),
            )
            ->willReturn(new Response(body: OneClickArrivalDepositApply::exampleResponse()));

        $this->binance->setApiKeys('apiKey', 'apiSecret');

        $this->assertEquals(
            json_decode(OneClickArrivalDepositApply::exampleResponse(), true),
            $this->binance->capitalDepositCreditApply('depositId', 'txId', 'subAccountId', 'subUserId')['response']['data']
        );
    }

    protected function checkSignatureInGetRequest($options): bool
    {
        return $options['headers']['X-MBX-APIKEY'] == 'apiKey' &&
            Signed::binanceMicrotime() >= $options['query']['timestamp'] &&
            is_string($options['query']['signature']) &&
            strlen($options['query']['signature']) > 20;
    }

    protected function checkSignatureInPostRequest($options): bool
    {
        return $options['headers']['X-MBX-APIKEY'] == 'apiKey' &&
            Signed::binanceMicrotime() >= $options['form_params']['timestamp'] &&
            is_string($options['form_params']['signature']) &&
            strlen($options['form_params']['signature']) > 20;
    }
}
