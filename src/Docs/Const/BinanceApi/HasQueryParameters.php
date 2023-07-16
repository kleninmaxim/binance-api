<?php

namespace BinanceApi\Docs\Const\BinanceApi;

use BinanceApi\Docs\Const\Exception\EndpointQueryException;

interface HasQueryParameters
{
    /**
     * return an array of query parameters, can throw only BinanceApi\Docs\Const\Exception\EndpointQueryException;
     *
     * @return array
     *
     * @throws EndpointQueryException
     */
    public function getQuery(): array;
}
