<?php

namespace BinanceApi\Docs\Const\BinanceApi;

interface ProcessResponse
{
    public const ADDITIONAL_FIELD = 'customAdditional';

    /**
     * Form response as we want to see it
     *
     * @param  array  $response Get a response result from binance
     * @return array
     */
    public function processResponse(array $response): array;
}
