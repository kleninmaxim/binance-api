<?php

namespace BinanceApi\Docs\GeneralInfo;

use BinanceApi\Docs\GeneralInfo\Const\BanBased;
use BinanceApi\Docs\GeneralInfo\Const\HttpCodeStatus;
use BinanceApi\Docs\GeneralInfo\Const\HttpMethod;

/**
 * https://binance-docs.github.io/apidocs/spot/en/#limits
 */
class Limits
{
    public const INTERVAL_LETTER_MINUTE = 'M';

    public const API_IP_LIMIT_USED_WEIGHT = 'X-MBX-USED-WEIGHT';
    public const API_IP_LIMIT_USED_WEIGHT_MINUTE = self::API_IP_LIMIT_USED_WEIGHT.'-1'.self::INTERVAL_LETTER_MINUTE;
    public const API_LIMIT_BASED_ON_IP_COUNT = 1200;
    public const API_LIMIT_BASED_ON_IP_INTERVAL_IN_SECONDS = 60;

    public const LIMIT_ORDER_COUNT = 'X-MBX-ORDER-COUNT';
    public const LIMIT_ORDER_COUNT_MINUTE = self::LIMIT_ORDER_COUNT.'-1'.self::INTERVAL_LETTER_MINUTE;

    public const SAPI_IP_LIMIT_USED_WEIGHT = 'X-SAPI-USED-IP-WEIGHT';
    public const SAPI_IP_LIMIT_USED_WEIGHT_MINUTE = self::SAPI_IP_LIMIT_USED_WEIGHT.'-1'.self::INTERVAL_LETTER_MINUTE;
    public const SAPI_LIMIT_BASED_ON_IP_COUNT = 12000;
    public const SAPI_LIMIT_BASED_ON_IP_INTERVAL_IN_SECONDS = 60;

    public const IP_LIMITS_HEADER = 'Retry-After';
}
