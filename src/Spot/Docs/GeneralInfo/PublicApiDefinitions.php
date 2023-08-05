<?php

namespace BinanceApi\Spot\Docs\GeneralInfo;

/**
 * https://binance-docs.github.io/apidocs/spot/en/#public-api-definitions
 */
class PublicApiDefinitions
{
    public const TERMINOLOGY = ['baseAsset' => 'base asset', 'quoteAsset' => 'quote asset'];


    /**
     * Symbol status (status):
     */
    public const SYMBOL_STATUS_PRE_TRADING = 'PRE_TRADING';
    public const SYMBOL_STATUS_TRADING = 'TRADING';
    public const SYMBOL_STATUS_POST_TRADING = 'POST_TRADING';
    public const SYMBOL_STATUS_END_OF_DAY = 'END_OF_DAY';
    public const SYMBOL_STATUS_HALT = 'HALT';
    public const SYMBOL_STATUS_AUCTION_MATCH = 'AUCTION_MATCH';
    public const SYMBOL_STATUS_BREAK = 'BREAK';

    public const SYMBOL_STATUSES = [
        self::SYMBOL_STATUS_PRE_TRADING,
        self::SYMBOL_STATUS_TRADING,
        self::SYMBOL_STATUS_POST_TRADING,
        self::SYMBOL_STATUS_END_OF_DAY,
        self::SYMBOL_STATUS_HALT,
        self::SYMBOL_STATUS_AUCTION_MATCH,
        self::SYMBOL_STATUS_BREAK,
    ];


    /**
     * Account and Symbol Permissions (permissions):
     */
    public const ACCOUNT_AND_SYMBOL_PERMISSION_SPOT = 'ACCOUNT_AND_SYMBOL_PERMISSION_SPOT';
    public const ACCOUNT_AND_SYMBOL_PERMISSION_MARGIN = 'ACCOUNT_AND_SYMBOL_PERMISSION_MARGIN';
    public const ACCOUNT_AND_SYMBOL_PERMISSION_LEVERAGED = 'ACCOUNT_AND_SYMBOL_PERMISSION_LEVERAGED';
    public const ACCOUNT_AND_SYMBOL_PERMISSION_TRD_GRP_002 = 'ACCOUNT_AND_SYMBOL_PERMISSION_TRD_GRP_002';
    public const ACCOUNT_AND_SYMBOL_PERMISSION_TRD_GRP_003 = 'ACCOUNT_AND_SYMBOL_PERMISSION_TRD_GRP_003';
    public const ACCOUNT_AND_SYMBOL_PERMISSION_TRD_GRP_004 = 'ACCOUNT_AND_SYMBOL_PERMISSION_TRD_GRP_004';
    public const ACCOUNT_AND_SYMBOL_PERMISSION_TRD_GRP_005 = 'ACCOUNT_AND_SYMBOL_PERMISSION_TRD_GRP_005';
    public const ACCOUNT_AND_SYMBOL_PERMISSION_TRD_GRP_006 = 'ACCOUNT_AND_SYMBOL_PERMISSION_TRD_GRP_006';
    public const ACCOUNT_AND_SYMBOL_PERMISSION_TRD_GRP_007 = 'ACCOUNT_AND_SYMBOL_PERMISSION_TRD_GRP_007';
    public const ACCOUNT_AND_SYMBOL_PERMISSION_TRD_GRP_008 = 'ACCOUNT_AND_SYMBOL_PERMISSION_TRD_GRP_008';
    public const ACCOUNT_AND_SYMBOL_PERMISSION_TRD_GRP_009 = 'ACCOUNT_AND_SYMBOL_PERMISSION_TRD_GRP_009';
    public const ACCOUNT_AND_SYMBOL_PERMISSION_TRD_GRP_010 = 'ACCOUNT_AND_SYMBOL_PERMISSION_TRD_GRP_010';
    public const ACCOUNT_AND_SYMBOL_PERMISSION_TRD_GRP_011 = 'ACCOUNT_AND_SYMBOL_PERMISSION_TRD_GRP_011';
    public const ACCOUNT_AND_SYMBOL_PERMISSION_TRD_GRP_012 = 'ACCOUNT_AND_SYMBOL_PERMISSION_TRD_GRP_012';
    public const ACCOUNT_AND_SYMBOL_PERMISSION_TRD_GRP_013 = 'ACCOUNT_AND_SYMBOL_PERMISSION_TRD_GRP_013';

    public const ACCOUNT_AND_SYMBOL_PERMISSIONS = [
        self::ACCOUNT_AND_SYMBOL_PERMISSION_SPOT,
        self::ACCOUNT_AND_SYMBOL_PERMISSION_MARGIN,
        self::ACCOUNT_AND_SYMBOL_PERMISSION_LEVERAGED,
        self::ACCOUNT_AND_SYMBOL_PERMISSION_TRD_GRP_002,
        self::ACCOUNT_AND_SYMBOL_PERMISSION_TRD_GRP_003,
        self::ACCOUNT_AND_SYMBOL_PERMISSION_TRD_GRP_004,
        self::ACCOUNT_AND_SYMBOL_PERMISSION_TRD_GRP_005,
        self::ACCOUNT_AND_SYMBOL_PERMISSION_TRD_GRP_006,
        self::ACCOUNT_AND_SYMBOL_PERMISSION_TRD_GRP_007,
        self::ACCOUNT_AND_SYMBOL_PERMISSION_TRD_GRP_008,
        self::ACCOUNT_AND_SYMBOL_PERMISSION_TRD_GRP_009,
        self::ACCOUNT_AND_SYMBOL_PERMISSION_TRD_GRP_010,
        self::ACCOUNT_AND_SYMBOL_PERMISSION_TRD_GRP_011,
        self::ACCOUNT_AND_SYMBOL_PERMISSION_TRD_GRP_012,
        self::ACCOUNT_AND_SYMBOL_PERMISSION_TRD_GRP_013,
    ];


    /**
     * Order status (status):
     */
    public const ORDER_STATUS_NEW = 'NEW';
    public const ORDER_STATUS_PARTIALLY_FILLED = 'PARTIALLY_FILLED';
    public const ORDER_STATUS_FILLED = 'FILLED';
    public const ORDER_STATUS_CANCELED = 'CANCELED';
    public const ORDER_STATUS_PENDING_CANCEL = 'PENDING_CANCEL';
    public const ORDER_STATUS_REJECTED = 'REJECTED';
    public const ORDER_STATUS_EXPIRED = 'EXPIRED';
    public const ORDER_STATUS_EXPIRED_IN_MATCH = 'EXPIRED_IN_MATCH';

    public const ORDER_STATUSES = [
        self::ORDER_STATUS_NEW => 'The order has been accepted by the engine.',
        self::ORDER_STATUS_PARTIALLY_FILLED => 'A part of the order has been filled.',
        self::ORDER_STATUS_FILLED => 'The order has been completed.',
        self::ORDER_STATUS_CANCELED => 'The order has been canceled by the user.',
        self::ORDER_STATUS_PENDING_CANCEL => 'Currently unused',
        self::ORDER_STATUS_REJECTED => 'The order was not accepted by the engine and not processed.',
        self::ORDER_STATUS_EXPIRED => 'The order was canceled according to the order type\'s rules (e.g. LIMIT FOK orders with no fill, LIMIT IOC or MARKET orders that partially fill) or by the exchange, (e.g. orders canceled during liquidation, orders canceled during maintenance)',
        self::ORDER_STATUS_EXPIRED_IN_MATCH => 'The order was canceled by the exchange due to STP trigger. (e.g. an order with EXPIRE_TAKER will match with existing orders on the book with the same account or same tradeGroupId)',
    ];


    /**
     * OCO Status (listStatusType):
     */
    public const OCO_STATUS_RESPONSE = 'RESPONSE';
    public const OCO_STATUS_EXEC_STARTED = 'EXEC_STARTED';
    public const OCO_STATUS_ALL_DONE = 'ALL_DONE';

    public const OCO_STATUSES = [
        self::OCO_STATUS_RESPONSE => 'This is used when the ListStatus is responding to a failed action. (E.g. Orderlist placement or cancellation)',
        self::OCO_STATUS_EXEC_STARTED => 'The order list has been placed or there is an update to the order list status.',
        self::OCO_STATUS_ALL_DONE => 'The order list has finished executing and thus no longer active.',
    ];


    /**
     * OCO Order Status (listOrderStatus):
     */
    public const OCO_ORDER_STATUS_EXECUTING = 'EXECUTING';
    public const OCO_ORDER_STATUS_ALL_DONE = 'ALL_DONE';
    public const OCO_ORDER_STATUS_REJECT = 'REJECT';

    public const OCO_ORDER_STATUSES = [
        self::OCO_ORDER_STATUS_EXECUTING => 'Either an order list has been placed or there is an update to the status of the list.',
        self::OCO_ORDER_STATUS_ALL_DONE => 'An order list has completed execution and thus no longer active.',
        self::OCO_ORDER_STATUS_REJECT => 'The List Status is responding to a failed action either during order placement or order canceled.)',
    ];


    /**
     * ContingencyType
     */
    public const CONTINGENCY_TYPE= 'ContingencyType';


    /**
     * Order types (orderTypes, type):
     */
    public const ORDER_TYPE_LIMIT = 'LIMIT';
    public const ORDER_TYPE_MARKET = 'MARKET';
    public const ORDER_TYPE_STOP_LOSS = 'STOP_LOSS';
    public const ORDER_TYPE_STOP_LOSS_LIMIT = 'STOP_LOSS_LIMIT';
    public const ORDER_TYPE_TAKE_PROFIT = 'TAKE_PROFIT';
    public const ORDER_TYPE_TAKE_PROFIT_LIMIT = 'TAKE_PROFIT_LIMIT';
    public const ORDER_TYPE_LIMIT_MAKER = 'LIMIT_MAKER';

    public const ORDER_TYPES = [
        self::ORDER_TYPE_LIMIT,
        self::ORDER_TYPE_MARKET,
        self::ORDER_TYPE_STOP_LOSS,
        self::ORDER_TYPE_STOP_LOSS_LIMIT,
        self::ORDER_TYPE_TAKE_PROFIT,
        self::ORDER_TYPE_TAKE_PROFIT_LIMIT,
        self::ORDER_TYPE_LIMIT_MAKER,
    ];


    /**
     * Order Response Type (newOrderRespType):
     */
    public const ORDER_RESPONSE_TYPE_ACK = 'ACK';
    public const ORDER_RESPONSE_TYPE_RESULT = 'RESULT';
    public const ORDER_RESPONSE_TYPE_FULL = 'FULL';

    public const ORDER_RESPONSE_TYPES = [
        self::ORDER_RESPONSE_TYPE_ACK,
        self::ORDER_RESPONSE_TYPE_RESULT,
        self::ORDER_RESPONSE_TYPE_FULL,
    ];


    /**
     * Order side (side):
     */
    public const ORDER_SIDE_BUY = 'BUY';
    public const ORDER_SIDE_SELL = 'SELL';

    public const ORDER_SIDES = [
        self::ORDER_SIDE_BUY,
        self::ORDER_SIDE_SELL,
    ];


    /**
     * Order Response Type (newOrderRespType):
     */
    public const TIME_IN_FORCE_GTC = 'GTC';
    public const TIME_IN_FORCE_IOC = 'IOC';
    public const TIME_IN_FORCE_FOK = 'FOK';

    public const TIME_IN_FORCES = [
        self::TIME_IN_FORCE_GTC => 'Good Til Canceled. An order will be on the book unless the order is canceled.',
        self::TIME_IN_FORCE_IOC => 'Immediate Or Cancel. An order will try to fill the order as much as it can before the order expires.',
        self::TIME_IN_FORCE_FOK => 'Fill or Kill. An order will expire if the full order cannot be filled upon execution.',
    ];


    /**
     * Kline/Candlestick chart intervals:
     */
    public const KLINE_CHART_INTERVAL_ABBREVIATION = [
        's' => 'seconds',
        'm' => 'minutes',
        'h' => 'hours',
        'd' => 'days',
        'w' => 'weeks',
        'M' => 'months',
    ];

    public const KLINE_CHART_INTERVAL_ONE_SECOND = '1s';
    public const KLINE_CHART_INTERVAL_ONE_MINUTE = '1m';
    public const KLINE_CHART_INTERVAL_THREE_MINUTES = '3m';
    public const KLINE_CHART_INTERVAL_FIVE_MINUTES = '5m';
    public const KLINE_CHART_INTERVAL_FIFTEEN_MINUTES = '15m';
    public const KLINE_CHART_INTERVAL_THIRTY_MINUTES = '30m';
    public const KLINE_CHART_INTERVAL_ONE_HOUR = '1h';
    public const KLINE_CHART_INTERVAL_TWO_HOURS = '2h';
    public const KLINE_CHART_INTERVAL_FOUR_HOURS = '4h';
    public const KLINE_CHART_INTERVAL_SIX_HOURS = '6h';
    public const KLINE_CHART_INTERVAL_EIGHT_HOURS = '8h';
    public const KLINE_CHART_INTERVAL_TWELVE_HOURS = '12h';
    public const KLINE_CHART_INTERVAL_ONE_DAY = '1d';
    public const KLINE_CHART_INTERVAL_THREE_DAYS = '3d';
    public const KLINE_CHART_INTERVAL_ONE_WEEK = '1w';
    public const KLINE_CHART_INTERVAL_ONE_MONTH = '1M';

    public const KLINE_CHART_INTERVALS = [
        self::KLINE_CHART_INTERVAL_ONE_SECOND,
        self::KLINE_CHART_INTERVAL_ONE_MINUTE,
        self::KLINE_CHART_INTERVAL_THREE_MINUTES,
        self::KLINE_CHART_INTERVAL_FIVE_MINUTES,
        self::KLINE_CHART_INTERVAL_FIFTEEN_MINUTES,
        self::KLINE_CHART_INTERVAL_THIRTY_MINUTES,
        self::KLINE_CHART_INTERVAL_ONE_HOUR,
        self::KLINE_CHART_INTERVAL_TWO_HOURS,
        self::KLINE_CHART_INTERVAL_FOUR_HOURS,
        self::KLINE_CHART_INTERVAL_SIX_HOURS,
        self::KLINE_CHART_INTERVAL_EIGHT_HOURS,
        self::KLINE_CHART_INTERVAL_TWELVE_HOURS,
        self::KLINE_CHART_INTERVAL_ONE_DAY,
        self::KLINE_CHART_INTERVAL_THREE_DAYS,
        self::KLINE_CHART_INTERVAL_ONE_WEEK,
        self::KLINE_CHART_INTERVAL_ONE_MONTH,
    ];


    /**
     * Rate limiters (rateLimitType)
     */
    public const RATE_LIMITER_REQUEST_WEIGHT = 'REQUEST_WEIGHT';
    public const RATE_LIMITER_ORDERS = 'ORDERS';
    public const RATE_LIMITER_RAW_REQUESTS = 'RAW_REQUESTS';

    public const RATE_LIMITERS = [
        self::RATE_LIMITER_REQUEST_WEIGHT,
        self::RATE_LIMITER_ORDERS,
        self::RATE_LIMITER_RAW_REQUESTS,
    ];


    /**
     * Rate limit intervals (interval)
     */
    public const RATE_LIMITER_INTERVAL_SECOND = 'SECOND';
    public const RATE_LIMITER_INTERVAL_MINUTE = 'MINUTE';
    public const RATE_LIMITER_INTERVAL_DAY = 'DAY';

    public const RATE_LIMITER_INTERVALS = [
        self::RATE_LIMITER_INTERVAL_SECOND,
        self::RATE_LIMITER_INTERVAL_MINUTE,
        self::RATE_LIMITER_INTERVAL_DAY,
    ];
}
