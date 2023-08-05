<?php

namespace BinanceApi\App\ResponseHandler;

use BinanceApi\Spot\Docs\Const\BinanceApi\Endpoint;
use Psr\Http\Message\ResponseInterface;

class OriginalDecodedHandler implements ResponseHandler
{
    public function get(ResponseInterface $response, ?Endpoint $endpoint): null|string|array
    {
        $body = $response->getBody()->getContents();

        if ($this->isJson($body)) {
            return json_decode($body, true);
        }

        return null;
    }

    protected function isJson(mixed $body): bool
    {
        if (is_null($body)) {
            return false;
        }

        json_decode($body);
        return json_last_error() === JSON_ERROR_NONE;
    }
}
