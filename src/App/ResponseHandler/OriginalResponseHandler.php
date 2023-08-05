<?php

namespace BinanceApi\App\ResponseHandler;

use BinanceApi\Spot\Docs\Const\BinanceApi\Endpoint;
use Psr\Http\Message\ResponseInterface;

class OriginalResponseHandler implements ResponseHandler
{
    public function get(ResponseInterface $response, ?Endpoint $endpoint): string|array
    {
        return $response->getBody()->getContents();
    }
}
