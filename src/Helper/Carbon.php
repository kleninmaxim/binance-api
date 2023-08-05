<?php

namespace BinanceApi\Helper;

use BinanceApi\Spot\Docs\GeneralInfo\GeneralApiInformation;
use DateTime;
use DateTimeZone;
use Exception;

class Carbon
{
    /**
     * @throws Exception
     */
    public static function getFullDate(string $binanceMicrotime, string $timezone = GeneralApiInformation::DEFAULT_TIMEZONE): string
    {
        return (new DateTime(date('Y-M-d H:i:s', round($binanceMicrotime / 1000))))
            ->setTimezone(new DateTimeZone($timezone))
            ->format('D, d M Y H:i:s').' '.$timezone;
    }
}
