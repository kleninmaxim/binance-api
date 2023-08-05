<?php

namespace BinanceApi\Spot\Docs\GeneralInfo;

use DateTime;
use DateTimeZone;

/**
 * https://binance-docs.github.io/apidocs/spot/en/#signed-trade-user_data-and-margin-endpoint-security
 */
class Signed
{
    public const SIGNED_PARAMETER = 'signature';
    public const SIGNED_TIMING_SECURITY_PARAMETER = 'timestamp';
    public const SIGNED_SIGNATURE_ALGO = 'sha256';

    /**
     * Serious trading is about timing. Networks can be unstable and unreliable, which can lead to requests taking varying amounts of time to reach the servers. With recvWindow, you can specify that the request must be processed within a certain number of milliseconds or be rejected by the server.
     */
    public static function logicTimingSecurity(int $timestamp, int $serverTime, int $recvWindow): bool
    {
        return ($timestamp < ($serverTime + 1000) && ($serverTime - $timestamp) <= $recvWindow);
    }

    public static function signature(string $totalParams, string $secretKey): string
    {
        return hash_hmac(static::SIGNED_SIGNATURE_ALGO, $totalParams, $secretKey);
    }

    public static function signatureMixedQueryStringAndRequestBody(string $queryString, string $requestBody, string $secretKey): string
    {
        return static::signature($queryString.$requestBody, $secretKey);
    }

    public static function binanceMicrotime(): string
    {
        $dateTime = (new DateTime())->setTimezone((new DateTimeZone('UTC')));

        return $dateTime->getTimestamp().substr($dateTime->format('u'), 0, -3);
    }

    public static function exampleSignatureRequestBody(): array
    {
        $apiKey = 'vmPUZE6mv9SD5VNHk4HlWFsOr6aKE2zvsw0MuIgwCIPy6utIco14y7Ju91duEh8A';
        $secretKey = 'NhqPtmdSJYdKjVHjA7PZj4Mge3R5YNiP1e3UZjInClVN65XAbvqqM6A7H5fATj0j';

        $parameters = [
            'symbol' => 'LTCBTC',
            'side' => 'BUY',
            'type' => 'side',
            'timeInForce' => 'GTC',
            'quantity' => 1,
            'price' => 0.1,
            'recvWindow' => 5000,
            'timestamp' => 1499827319559,
        ];

        $totalParams = http_build_query($parameters);

        return [
            'apiKey' => $apiKey,
            'secretKey' => $secretKey,
            'parameters' => $parameters,
            'totalParams' => $totalParams,
            'signature' => static::signature($totalParams, $secretKey),
        ];
    }

    public static function exampleSignatureQueryString(): array
    {
        $apiKey = 'vmPUZE6mv9SD5VNHk4HlWFsOr6aKE2zvsw0MuIgwCIPy6utIco14y7Ju91duEh8A';
        $secretKey = 'NhqPtmdSJYdKjVHjA7PZj4Mge3R5YNiP1e3UZjInClVN65XAbvqqM6A7H5fATj0j';

        $parameters = [
            'symbol' => 'LTCBTC',
            'side' => 'BUY',
            'type' => 'side',
            'timeInForce' => 'GTC',
            'quantity' => 1,
            'price' => 0.1,
            'recvWindow' => 5000,
            'timestamp' => 1499827319559,
        ];

        $totalParams = http_build_query($parameters);

        return [
            'apiKey' => $apiKey,
            'secretKey' => $secretKey,
            'parameters' => $parameters,
            'totalParams' => $totalParams,
            'signature' => static::signature($totalParams, $secretKey),
        ];
    }

    public static function exampleMixedQueryStringAndRequestBody(): array
    {
        $apiKey = 'vmPUZE6mv9SD5VNHk4HlWFsOr6aKE2zvsw0MuIgwCIPy6utIco14y7Ju91duEh8A';
        $secretKey = 'NhqPtmdSJYdKjVHjA7PZj4Mge3R5YNiP1e3UZjInClVN65XAbvqqM6A7H5fATj0j';

        $parameters = [
            'queryString' => [
                'symbol' => 'LTCBTC',
                'side' => 'BUY',
                'type' => 'side',
                'timeInForce' => 'GTC',
            ],
            'requestBody' => [
                'quantity' => 1,
                'price' => 0.1,
                'recvWindow' => 5000,
                'timestamp' => 1499827319559,
            ],
        ];

        $totalParamsQueryString = http_build_query($parameters['queryString']);
        $totalParamsRequestBody = http_build_query($parameters['requestBody']);

        return [
            'apiKey' => $apiKey,
            'secretKey' => $secretKey,
            'parameters' => $parameters,
            'totalParamsQueryString' => $totalParamsQueryString,
            'totalParamsRequestBody' => $totalParamsRequestBody,
            'signature' => static::signatureMixedQueryStringAndRequestBody(
                $totalParamsQueryString,
                $totalParamsRequestBody,
                $secretKey
            ),
        ];
    }

    // TODO: add SIGNED Endpoint Example for POST /api/v3/order - RSA Keys (https://binance-docs.github.io/apidocs/spot/en/#signed-trade-user_data-and-margin-endpoint-security)
}
