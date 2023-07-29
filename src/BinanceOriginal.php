<?php

namespace BinanceApi;

use Exception;
use GuzzleHttp\Client;
use BinanceApi\Docs\Const\BinanceApi\Endpoint;
use BinanceApi\Docs\GeneralInfo\GeneralApiInformation;
use BinanceApi\Helper\Http;
use BinanceApi\Helper\ResponseHandler\OriginalDecodedHandler;
use BinanceApi\Helper\ResponseHandler\ResponseHandler;
use Psr\Http\Message\ResponseInterface;

/**
 * Class to work with Binance API
 */
class BinanceOriginal
{
    use BinanceAliases;

    /**
     * @var Http helper class for making http requests
     */
    protected Http $http;

    /**
     * @var string binance endpoint
     */
    protected string $endpoint;

    /**
     * Class construct
     *
     * @param  ResponseHandler  $responseHandler handle the response from binance and return in any result
     * @param  string  $endpoint binance endpoint, by default: https://api.binance.com
     * @param  Client  $client guzzle client: https://docs.guzzlephp.org/en/stable/index.html?highlight=client
     */
    public function __construct(
        readonly public ResponseHandler $responseHandler = new OriginalDecodedHandler(),
        string $endpoint = GeneralApiInformation::BASE_ENDPOINT,
        Client $client = new Client(),
    ) {
        $this->http = new Http($client);

        //        if (! in_array($endpoint, GeneralApiInformation::BASE_ENDPOINTS)) {
        //            throw new BinanceException('There is no such endpoint: {'.$endpoint. '}. Only has: '.implode(', ', GeneralApiInformation::BASE_ENDPOINTS));
        //        }

        $this->endpoint = $endpoint;
    }

    /**
     * Handles all methods described in BinanceAliases
     *
     * First is resolve alias, do http request and handle this request
     *
     * @param  string  $name  name of method
     * @param  array  $arguments  parameters of this method
     * @return mixed handle response getting from binance
     * @throws Exception
     */
    public function __call(string $name, array $arguments): mixed
    {
        $endpointObject = $this->resolveAlias($name);

        return $this->responseHandler->get($this->httpRequest($endpointObject, ...$arguments), $endpointObject);
    }

    /**
     * Create http request for binance API
     *
     * @param  Endpoint  $endpointObject
     * @param  array  $headers  http header
     * @param  array  $query  http query parameters
     * @param  array  $body  http body
     * @return ResponseInterface return guzzle ResponseInterface
     * @throws Exception
     */
    protected function httpRequest(
        Endpoint $endpointObject,
        array $headers = [],
        array $query = [],
        array $body = []
    ): ResponseInterface {
        // Get full url by endpoint and api endpoint: https://api.binance.com/api/v3/exchangeInfo
        $url = $this->endpoint.$endpointObject->endpoint;

        // create http request to binance
        $response = $this->http->{strtolower($endpointObject->httpMethod)}($url, $headers, $query, $body);

        // something doesn't work with http request and/or http response
        if (is_null($response)) {
            throw new Exception('Can\'t made http request to this endpoint: '.$url);
        }

        return $response;
    }
}
