<?php

namespace BinanceApi\Docs\GeneralInfo;

use BinanceApi\Docs\Introduction\TestNet;

/**
 * https://binance-docs.github.io/apidocs/spot/en/#general-api-information
 */
class GeneralApiInformation
{
    public const BASE_ENDPOINT = 'https://api.binance.com';
    public const GCP_ENDPOINT = 'https://api-gcp.binance.com';
    public const API1_ENDPOINT = 'https://api1.binance.com';
    public const API2_ENDPOINT = 'https://api2.binance.com';
    public const API3_ENDPOINT = 'https://api3.binance.com';
    public const API4_ENDPOINT = 'https://api4.binance.com';

    public const BASE_ENDPOINT_VISION = 'https://data-api.binance.vision';

    public const BASE_ENDPOINTS = [
        self::BASE_ENDPOINT,
        self::GCP_ENDPOINT,

        self::API1_ENDPOINT,
        self::API2_ENDPOINT,
        self::API3_ENDPOINT,
        self::API4_ENDPOINT,

        self::BASE_ENDPOINT_VISION,
        TestNet::BASE_ENDPOINT,
    ];

    public const ERROR_CODE_AND_MESSAGES = ['code', 'msg'];

    public const DEFAULT_TIMEZONE = 'UTC';
}
