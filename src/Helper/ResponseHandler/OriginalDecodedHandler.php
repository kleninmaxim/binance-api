<?php

namespace BinanceApi\Helper\ResponseHandler;

use BinanceApi\Docs\Const\BinanceApi\Endpoint;
use Psr\Http\Message\ResponseInterface;

class OriginalDecodedHandler implements ResponseHandler
{
    public function get(ResponseInterface $response, ?Endpoint $endpoint): string|array
    {
        return json_decode($response->getBody()->getContents(), true);
    }
}
