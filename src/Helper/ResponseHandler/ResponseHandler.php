<?php

namespace BinanceApi\Helper\ResponseHandler;

use BinanceApi\Docs\Const\BinanceApi\Endpoint;
use Psr\Http\Message\ResponseInterface;

interface ResponseHandler
{
    /**
     * Handle response from binance and return result at some format
     *
     * @param  ResponseInterface  $response
     * @param  Endpoint|null  $endpoint
     * @return mixed
     */
    public function get(ResponseInterface $response, ?Endpoint $endpoint): mixed;
}
