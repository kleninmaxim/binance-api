<?php

namespace BinanceApi\App\ResponseHandler;

use BinanceApi\Spot\Docs\Const\BinanceApi\Endpoint;
use Psr\Http\Message\ResponseInterface;

class GuzzlePsr7ResponseHandler implements ResponseHandler
{
    public function get(ResponseInterface $response, ?Endpoint $endpoint): ResponseInterface
    {
        return $response;
    }
}
