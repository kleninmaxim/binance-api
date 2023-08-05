<?php

namespace BinanceApi\Spot;

use BinanceApi\App\BinanceOriginal;
use BinanceApi\App\ResponseHandler\OriginalDecodedHandler;
use BinanceApi\App\ResponseHandler\ResponseHandler;
use BinanceApi\Spot\Docs\GeneralInfo\GeneralApiInformation;
use BinanceApi\Spot\Docs\MarketDataEndpoint\CheckServerTime;
use BinanceApi\Spot\Docs\MarketDataEndpoint\CompressedAggregateTradesList;
use BinanceApi\Spot\Docs\MarketDataEndpoint\CurrentAveragePrice;
use BinanceApi\Spot\Docs\MarketDataEndpoint\ExchangeInformation;
use BinanceApi\Spot\Docs\MarketDataEndpoint\KlineCandlestickData;
use BinanceApi\Spot\Docs\MarketDataEndpoint\OldTradeLookup;
use BinanceApi\Spot\Docs\MarketDataEndpoint\OrderBook;
use BinanceApi\Spot\Docs\MarketDataEndpoint\RecentTradesList;
use BinanceApi\Spot\Docs\MarketDataEndpoint\RollingWindowPriceChangeStatistics;
use BinanceApi\Spot\Docs\MarketDataEndpoint\SymbolOrderBookTicker;
use BinanceApi\Spot\Docs\MarketDataEndpoint\SymbolPriceTicker;
use BinanceApi\Spot\Docs\MarketDataEndpoint\TestConnectivity;
use BinanceApi\Spot\Docs\MarketDataEndpoint\TickerPriceChangeStatistics24hr;
use BinanceApi\Spot\Docs\MarketDataEndpoint\UIKlines;
use BinanceApi\Spot\Docs\SpotAccountTrade\AccountInformation;
use BinanceApi\Spot\Docs\SpotAccountTrade\AccountTradeList;
use BinanceApi\Spot\Docs\SpotAccountTrade\AllOrders;
use BinanceApi\Spot\Docs\SpotAccountTrade\CancelAllOpenOrdersOnASymbol;
use BinanceApi\Spot\Docs\SpotAccountTrade\CancelAnExistingOrderAndSendANewOrder;
use BinanceApi\Spot\Docs\SpotAccountTrade\CancelOco;
use BinanceApi\Spot\Docs\SpotAccountTrade\CancelOrder;
use BinanceApi\Spot\Docs\SpotAccountTrade\CurrentOpenOrders;
use BinanceApi\Spot\Docs\SpotAccountTrade\NewOco;
use BinanceApi\Spot\Docs\SpotAccountTrade\NewOrder;
use BinanceApi\Spot\Docs\SpotAccountTrade\QueryAllOco;
use BinanceApi\Spot\Docs\SpotAccountTrade\QueryCurrentOrderCountUsage;
use BinanceApi\Spot\Docs\SpotAccountTrade\QueryOco;
use BinanceApi\Spot\Docs\SpotAccountTrade\QueryOpenOco;
use BinanceApi\Spot\Docs\SpotAccountTrade\QueryOrder;
use BinanceApi\Spot\Docs\SpotAccountTrade\QueryPreventedMatches;
use BinanceApi\Spot\Docs\SpotAccountTrade\TestNewOrder;
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

/**
 * Wallet Endpoints:
 * @method mixed systemStatus(array $headers = [], array $query = [], array $body = []) System Status (System). https://binance-docs.github.io/apidocs/spot/en/#system-status-system
 * @method mixed capitalConfigGetall(array $headers = [], array $query = [], array $body = []) All Coins' Information. https://binance-docs.github.io/apidocs/spot/en/#all-coins-39-information-user_data
 * @method mixed accountSnapshot(array $headers = [], array $query = [], array $body = []) Daily Account Snapshot. https://binance-docs.github.io/apidocs/spot/en/#daily-account-snapshot-user_data
 * @method mixed accountDisableFastWithdrawSwitch(array $headers = [], array $query = [], array $body = []) Disable Fast Withdraw Switch. https://binance-docs.github.io/apidocs/spot/en/#disable-fast-withdraw-switch-user_data
 * @method mixed accountEnableFastWithdrawSwitch(array $headers = [], array $query = [], array $body = []) Enable Fast Withdraw Switch. https://binance-docs.github.io/apidocs/spot/en/#enable-fast-withdraw-switch-user_data
 * @method mixed capitalWithdrawApply(array $headers = [], array $query = [], array $body = []) Withdraw https://binance-docs.github.io/apidocs/spot/en/#withdraw-user_data
 * @method mixed capitalDepositHisrec(array $headers = [], array $query = [], array $body = []) Deposit History (supporting network) https://binance-docs.github.io/apidocs/spot/en/#deposit-history-supporting-network-user_data
 * @method mixed capitalWithdrawHistory(array $headers = [], array $query = [], array $body = []) Withdraw History (supporting network) https://binance-docs.github.io/apidocs/spot/en/#withdraw-history-supporting-network-user_data
 * @method mixed capitalDepositAddress(array $headers = [], array $query = [], array $body = []) Deposit Address (supporting network) https://binance-docs.github.io/apidocs/spot/en/#deposit-address-supporting-network-user_data
 * @method mixed accountStatus(array $headers = [], array $query = [], array $body = []) Account Status https://binance-docs.github.io/apidocs/spot/en/#account-status-user_data
 * @method mixed accountApiTradingStatus(array $headers = [], array $query = [], array $body = []) Account API Trading Status https://binance-docs.github.io/apidocs/spot/en/#account-api-trading-status-user_data
 * @method mixed assetDribblet(array $headers = [], array $query = [], array $body = []) DustLog https://binance-docs.github.io/apidocs/spot/en/#dustlog-user_data
 * @method mixed assetDustBtc(array $headers = [], array $query = [], array $body = []) Get Assets That Can Be Converted Into BNB https://binance-docs.github.io/apidocs/spot/en/#get-assets-that-can-be-converted-into-bnb-user_data
 * @method mixed assetDust(array $headers = [], array $query = [], array $body = []) Dust Transfer https://binance-docs.github.io/apidocs/spot/en/#dust-transfer-user_data
 * @method mixed assetAssetDividend(array $headers = [], array $query = [], array $body = []) Asset Dividend Record https://binance-docs.github.io/apidocs/spot/en/#asset-dividend-record-user_data
 * @method mixed assetAssetDetail(array $headers = [], array $query = [], array $body = []) Asset Detail https://binance-docs.github.io/apidocs/spot/en/#asset-detail-user_data
 * @method mixed assetTradeFee(array $headers = [], array $query = [], array $body = []) Trade Fee https://binance-docs.github.io/apidocs/spot/en/#trade-fee-user_data
 * @method mixed assetTransfer(array $headers = [], array $query = [], array $body = []) User Universal Transfer https://binance-docs.github.io/apidocs/spot/en/#user-universal-transfer-user_data
 * @method mixed getAssetTransfer(array $headers = [], array $query = [], array $body = []) Query User Universal Transfer History https://binance-docs.github.io/apidocs/spot/en/#query-user-universal-transfer-history-user_data
 * @method mixed assetGetFundingAsset(array $headers = [], array $query = [], array $body = []) Funding Wallet https://binance-docs.github.io/apidocs/spot/en/#funding-wallet-user_data
 * @method mixed assetGetUserAsset(array $headers = [], array $query = [], array $body = []) User Asset https://binance-docs.github.io/apidocs/spot/en/#user-asset-user_data
 * @method mixed assetConvertTransfer(array $headers = [], array $query = [], array $body = []) BUSD Convert https://binance-docs.github.io/apidocs/spot/en/#busd-convert-trade
 * @method mixed assetConvertTransferQueryByPage(array $headers = [], array $query = [], array $body = []) BUSD Convert History https://binance-docs.github.io/apidocs/spot/en/#busd-convert-history-user_data
 * @method mixed assetLedgerTransferCloudMiningQueryByPage(array $headers = [], array $query = [], array $body = []) Get Cloud-Mining payment and refund history https://binance-docs.github.io/apidocs/spot/en/#get-cloud-mining-payment-and-refund-history-user_data
 * @method mixed accountApiRestrictions(array $headers = [], array $query = [], array $body = []) Get API Key Permission https://binance-docs.github.io/apidocs/spot/en/#get-api-key-permission-user_data
 * @method mixed capitalContractConvertibleCoins(array $headers = [], array $query = [], array $body = []) Query auto-converting stable coins https://binance-docs.github.io/apidocs/spot/en/#query-auto-converting-stable-coins-user_data
 * @method mixed switchCapitalContractConvertibleCoins(array $headers = [], array $query = [], array $body = []) Switch on/off BUSD and stable coins conversion
 * @method mixed capitalDepositCreditApply(array $headers = [], array $query = [], array $body = []) One click arrival deposit apply (for expired address deposit)
 *
 * Market Data Endpoints:
 * @method mixed ping(array $headers = [], array $query = [], array $body = []) Test Connectivity. https://binance-docs.github.io/apidocs/spot/en/#test-connectivity
 * @method mixed time(array $headers = [], array $query = [], array $body = []) Check Server Time. https://binance-docs.github.io/apidocs/spot/en/#check-server-time
 * @method mixed exchangeInfo(array $headers = [], array $query = [], array $body = []) Exchange Information. https://binance-docs.github.io/apidocs/spot/en/#exchange-information
 * @method mixed depth(array $headers = [], array $query = [], array $body = []) Order Book. https://binance-docs.github.io/apidocs/spot/en/#order-book
 * @method mixed trades(array $headers = [], array $query = [], array $body = []) Recent Trades List. https://binance-docs.github.io/apidocs/spot/en/#recent-trades-list
 * @method mixed historicalTrades(array $headers = [], array $query = [], array $body = []) Old Trade Lookup (MARKET_DATA). https://binance-docs.github.io/apidocs/spot/en/#old-trade-lookup-market_data
 * @method mixed aggTrades(array $headers = [], array $query = [], array $body = []) Compressed/Aggregate Trades List. https://binance-docs.github.io/apidocs/spot/en/#compressed-aggregate-trades-list
 * @method mixed klines(array $headers = [], array $query = [], array $body = []) Kline/Candlestick Data. https://binance-docs.github.io/apidocs/spot/en/#kline-candlestick-data
 * @method mixed avgPrice(array $headers = [], array $query = [], array $body = []) UIKlines. https://binance-docs.github.io/apidocs/spot/en/#uiklines
 * @method mixed ticker24hr(array $headers = [], array $query = [], array $body = []) Current Average Price. https://binance-docs.github.io/apidocs/spot/en/#current-average-price
 * @method mixed tickerPrice(array $headers = [], array $query = [], array $body = []) 24hr Ticker Price Change Statistics. https://binance-docs.github.io/apidocs/spot/en/#24hr-ticker-price-change-statistics
 * @method mixed tickerBookTicker(array $headers = [], array $query = [], array $body = []) Symbol Price Ticker. https://binance-docs.github.io/apidocs/spot/en/#symbol-price-ticker
 * @method mixed ticker(array $headers = [], array $query = [], array $body = []) Symbol Order Book Ticker. https://binance-docs.github.io/apidocs/spot/en/#symbol-order-book-ticker
 *
 * Spot Account/Trade:
 * @method mixed orderTest(array $headers = [], array $query = [], array $body = []) Test New Order https://binance-docs.github.io/apidocs/spot/en/#test-new-order-trade
 * @method mixed order(array $headers = [], array $query = [], array $body = []) New Order https://binance-docs.github.io/apidocs/spot/en/#new-order-trade
 * @method mixed cancelOrder(array $headers = [], array $query = [], array $body = []) Cancel Order https://binance-docs.github.io/apidocs/spot/en/#cancel-order-trade
 * @method mixed cancelOpenOrders(array $headers = [], array $query = [], array $body = []) Cancel all Open Orders on a Symbol https://binance-docs.github.io/apidocs/spot/en/#cancel-all-open-orders-on-a-symbol-trade
 * @method mixed getOrder(array $headers = [], array $query = [], array $body = []) Query Order https://binance-docs.github.io/apidocs/spot/en/#query-order-user_data
 * @method mixed orderCancelReplace(array $headers = [], array $query = [], array $body = []) Cancel an Existing Order and Send a New Order https://binance-docs.github.io/apidocs/spot/en/#cancel-an-existing-order-and-send-a-new-order-trade
 * @method mixed openOrders(array $headers = [], array $query = [], array $body = []) Current Open Orders https://binance-docs.github.io/apidocs/spot/en/#current-open-orders-user_data
 * @method mixed allOrders(array $headers = [], array $query = [], array $body = []) All Orders https://binance-docs.github.io/apidocs/spot/en/#all-orders-user_data
 * @method mixed orderOco(array $headers = [], array $query = [], array $body = []) New OCO https://binance-docs.github.io/apidocs/spot/en/#new-oco-trade
 * @method mixed cancelOrderList(array $headers = [], array $query = [], array $body = []) Cancel OCO https://binance-docs.github.io/apidocs/spot/en/#cancel-oco-trade
 * @method mixed orderList(array $headers = [], array $query = [], array $body = []) Query OCO https://binance-docs.github.io/apidocs/spot/en/#query-oco-user_data
 * @method mixed allOrderList(array $headers = [], array $query = [], array $body = []) Query all OCO https://binance-docs.github.io/apidocs/spot/en/#query-all-oco-user_data
 * @method mixed openOrderList(array $headers = [], array $query = [], array $body = []) Query Open OCO https://binance-docs.github.io/apidocs/spot/en/#query-open-oco-user_data
 * @method mixed account(array $headers = [], array $query = [], array $body = []) Account Information https://binance-docs.github.io/apidocs/spot/en/#account-information-user_data
 * @method mixed myTrades(array $headers = [], array $query = [], array $body = []) Account Trade List https://binance-docs.github.io/apidocs/spot/en/#account-trade-list-user_data
 * @method mixed rateLimitOrder(array $headers = [], array $query = [], array $body = []) Query Current Order Count Usage https://binance-docs.github.io/apidocs/spot/en/#query-current-order-count-usage-trade
 * @method mixed myPreventedMatches(array $headers = [], array $query = [], array $body = []) Query Prevented Matches https://binance-docs.github.io/apidocs/spot/en/#query-prevented-matches-user_data
 *
 */
class BinanceSpotOriginal extends BinanceOriginal
{
    /**
     * @var array|string[] method as a key, value as Endpoint class for binance endpoint
     */
    protected array $aliases = [
        // Wallet Endpoints
        SystemStatus::METHOD => SystemStatus::class,
        AllCoinsInformation::METHOD => AllCoinsInformation::class,
        DailyAccountSnapshot::METHOD => DailyAccountSnapshot::class,
        DisableFastWithdrawSwitch::METHOD => DisableFastWithdrawSwitch::class,
        EnableFastWithdrawSwitch::METHOD => EnableFastWithdrawSwitch::class,
        Withdraw::METHOD => Withdraw::class,
        DepositHistory::METHOD => DepositHistory::class,
        WithdrawHistory::METHOD => WithdrawHistory::class,
        DepositAddress::METHOD => DepositAddress::class,
        AccountStatus::METHOD => AccountStatus::class,
        AccountAPITradingStatus::METHOD => AccountAPITradingStatus::class,
        DustLog::METHOD => DustLog::class,
        GetAssetsThatCanBeConvertedIntoBnb::METHOD => GetAssetsThatCanBeConvertedIntoBnb::class,
        DustTransfer::METHOD => DustTransfer::class,
        AssetDividendRecord::METHOD => AssetDividendRecord::class,
        AssetDetail::METHOD => AssetDetail::class,
        TradeFee::METHOD => TradeFee::class,
        UserUniversalTransfer::METHOD => UserUniversalTransfer::class,
        QueryUserUniversalTransferHistory::METHOD => QueryUserUniversalTransferHistory::class,
        FundingWallet::METHOD => FundingWallet::class,
        UserAsset::METHOD => UserAsset::class,
        BusdConvert::METHOD => BusdConvert::class,
        BusdConvertHistory::METHOD => BusdConvertHistory::class,
        GetCloudMiningPaymentAndRefundHistory::METHOD => GetCloudMiningPaymentAndRefundHistory::class,
        GetApiKeyPermission::METHOD => GetApiKeyPermission::class,
        QueryAutoConvertingStableCoins::METHOD => QueryAutoConvertingStableCoins::class,
        SwitchOnOffBusdAndStableCoinsConversion::METHOD => SwitchOnOffBusdAndStableCoinsConversion::class,
        OneClickArrivalDepositApply::METHOD => OneClickArrivalDepositApply::class,

        // Market Data Endpoints
        TestConnectivity::METHOD => TestConnectivity::class,
        CheckServerTime::METHOD => CheckServerTime::class,
        ExchangeInformation::METHOD => ExchangeInformation::class,
        OrderBook::METHOD => OrderBook::class,
        RecentTradesList::METHOD => RecentTradesList::class,
        OldTradeLookup::METHOD => OldTradeLookup::class,
        CompressedAggregateTradesList::METHOD => CompressedAggregateTradesList::class,
        KlineCandlestickData::METHOD => KlineCandlestickData::class,
        UIKlines::METHOD => UIKlines::class,
        CurrentAveragePrice::METHOD => CurrentAveragePrice::class,
        TickerPriceChangeStatistics24hr::METHOD => TickerPriceChangeStatistics24hr::class,
        SymbolPriceTicker::METHOD => SymbolPriceTicker::class,
        SymbolOrderBookTicker::METHOD => SymbolOrderBookTicker::class,
        RollingWindowPriceChangeStatistics::METHOD => RollingWindowPriceChangeStatistics::class,

        // Spot Account/Trade
        TestNewOrder::METHOD => TestNewOrder::class,
        NewOrder::METHOD => NewOrder::class,
        CancelOrder::METHOD => CancelOrder::class,
        CancelAllOpenOrdersOnASymbol::METHOD => CancelAllOpenOrdersOnASymbol::class,
        QueryOrder::METHOD => QueryOrder::class,
        CancelAnExistingOrderAndSendANewOrder::METHOD => CancelAnExistingOrderAndSendANewOrder::class,
        CurrentOpenOrders::METHOD => CurrentOpenOrders::class,
        AllOrders::METHOD => AllOrders::class,
        NewOco::METHOD => NewOco::class,
        CancelOco::METHOD => CancelOco::class,
        QueryOco::METHOD => QueryOco::class,
        QueryAllOco::METHOD => QueryAllOco::class,
        QueryOpenOco::METHOD => QueryOpenOco::class,
        AccountInformation::METHOD => AccountInformation::class,
        AccountTradeList::METHOD => AccountTradeList::class,
        QueryCurrentOrderCountUsage::METHOD => QueryCurrentOrderCountUsage::class,
        QueryPreventedMatches::METHOD => QueryPreventedMatches::class,
    ];

    /**
     * Class construct
     *
     * @param  ResponseHandler  $responseHandler handle the response from binance and return in any result
     * @param  string  $endpoint binance endpoint, by default: https://api.binance.com
     * @param  Client  $client guzzle client: https://docs.guzzlephp.org/en/stable/index.html?highlight=client
     */
    public function __construct(
        ResponseHandler $responseHandler = new OriginalDecodedHandler(),
        string $endpoint = GeneralApiInformation::BASE_ENDPOINT,
        Client $client = new Client(),
    ) {

        parent::__construct($responseHandler, $endpoint, $client);
    }
}
