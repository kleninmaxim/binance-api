<?php

namespace BinanceApi\Docs\Const\BinanceApi;

/**
 * @property string endpoint
 * @property string $httpMethod
 * @property null|int $weight
 * @property string $weightBased
 * @property null|string $dataSource
 * @property null|string $encryption
 * @property string $endpointType
 * @property string $title
 * @property string $description
 */
interface Endpoint
{
    /**
     * It's function only for test, to understand what the response of endpoint
     *
     * @return string|array|null
     */
    public static function exampleResponse(): null|string|array;
}
