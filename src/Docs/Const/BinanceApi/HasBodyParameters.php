<?php

namespace BinanceApi\Docs\Const\BinanceApi;

use BinanceApi\Docs\Const\Exception\EndpointQueryException;

interface HasBodyParameters
{
    /**
     * return an array of body parameters, can throw only BinanceApi\Docs\Const\Exception\EndpointQueryException;
     *
     * @return array
     *
     * @throws EndpointQueryException
     */
    public function getBody(): array;
}
