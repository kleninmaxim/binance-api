<?php

namespace BinanceApi\Docs\Const\BinanceApi;

/**
 * @property string endpoint
 * @property string $httpMethod
 * @property null|int $weight
 * @property string $weightBased
 * @property string $dataSource
 * @property null|string $encryption
 * @property string $endpointType
 * @property string $title
 * @property string $description
 * @property string $version
 * @property bool $isSapi
 */
interface Endpoint
{
    /**
     * It's function only for test, to understand what the response of endpoint
     *
     * @return string|array
     */
    public static function exampleResponse(): string|array;
}
