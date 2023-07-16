<?php

namespace BinanceApi\Helper\ResponseHandler;

use BinanceApi\Docs\Const\BinanceApi\Endpoint;
use Psr\Http\Message\ResponseInterface;

class GuzzlePsr7ResponseHandler implements ResponseHandler
{
    public function get(ResponseInterface $response, ?Endpoint $endpoint): ResponseInterface
    {
        return $response;
    }
}
