<?php

namespace BinanceApi\Spot\Docs\GeneralInfo;

/**
 * https://binance-docs.github.io/apidocs/spot/en/#endpoint-security-type
 */
class EndpointSecurityType
{
    public const NONE = 'NONE';
    public const TRADE = 'TRADE';
    public const MARGIN = 'MARGIN';
    public const USER_DATA = 'USER_DATA';
    public const SIGNED = 'SIGNED';
    public const USER_STREAM = 'USER_STREAM';
    public const MARKET_DATA = 'MARKET_DATA';

    public const SECURITY_TYPES_THROW_API_KEY = [
        self::TRADE,
        self::MARGIN,
        self::USER_DATA,
        self::SIGNED,
        self::USER_STREAM,
        self::MARKET_DATA,
    ];

    public const SECURITY_TYPES_THROW_SIGNATURE = [
        self::TRADE,
        self::MARGIN,
        self::USER_DATA,
        self::SIGNED,
    ];

    public const SECURITY_API_KEY_HEADER = 'X-MBX-APIKEY';
}
