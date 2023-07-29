<?php

namespace BinanceApi\Helper\ResponseHandler;

use BinanceApi\Docs\Const\BinanceApi\Endpoint;
use BinanceApi\Docs\Const\BinanceApi\ProcessResponse;
use BinanceApi\Docs\GeneralInfo\GeneralApiInformation;
use Psr\Http\Message\ResponseInterface;

class CustomResponseHandler implements ResponseHandler
{
    public function get(ResponseInterface $response, ?Endpoint $endpoint): array
    {
        $body = $response->getBody()->getContents();

        if ($this->isJson($body)) {
            $data = json_decode($body, true);

            $data = ($endpoint instanceof ProcessResponse && ! GeneralApiInformation::isErrorMessage($data))
                ? $endpoint->processResponse($data)
                : $data;
        }

        return [
            'data' => $data ?? null,
            'info' => [
                'statusCode' => $response->getStatusCode(),
                'reasonPhrase' => $response->getReasonPhrase(),
                'headers' => $response->getHeaders(),
            ],
        ];
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
