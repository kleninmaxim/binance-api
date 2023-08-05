<?php

namespace BinanceApi\UsdmFutures\Docs\GeneralInfo;

/**
 * https://binance-docs.github.io/apidocs/futures/en/#general-api-information
 */
class GeneralApiInformation
{
    public const BASE_ENDPOINT = 'https://fapi.binance.com';

    public const BASE_ENDPOINTS = [
        self::BASE_ENDPOINT,
    ];

    public const ERROR_CODE_AND_MESSAGES = ['code', 'msg'];

    public const DEFAULT_TIMEZONE = 'UTC';
}
