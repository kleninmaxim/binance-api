<?php

namespace BinanceApi\App;

use BinanceApi\App\ResponseHandler\ResponseHandler;
use BinanceApi\Exception\MethodNotExistException;
use BinanceApi\Helper\Http;
use BinanceApi\Spot\Docs\Const\BinanceApi\Endpoint;
use Exception;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

/**
 * Class to work with Binance API
 */
abstract class BinanceOriginal
{
    /**
     * @var Http helper class for making http requests
     */
    protected Http $http;

    /**
     * @var string binance endpoint
     */
    protected string $endpoint;

    /**
     * @var array|string[] method as a key, value as Endpoint class for binance endpoint
     */
    protected array $aliases = [];

    /**
     * @var array Coded created fix Endpoint classes
     */
    protected array $resolvedAliases = [];

    /**
     * Class construct
     *
     * @param  ResponseHandler  $responseHandler handle the response from binance and return in any result
     * @param  string  $endpoint binance endpoint
     * @param  Client  $client guzzle client: https://docs.guzzlephp.org/en/stable/index.html?highlight=client
     */
    public function __construct(
        readonly public ResponseHandler $responseHandler,
        string $endpoint,
        Client $client,
    ) {
        $this->http = new Http($client);

        $this->endpoint = $endpoint;
    }

    /**
     * Method to resolve alias
     *
     * @param  string  $name  name of method from $this->aliases
     * @return Endpoint object of readonly Endpoint class
     * @throws MethodNotExistException
     */
    public function resolveAlias(string $name): Endpoint
    {
        if (isset($this->resolvedAliases[$name])) {
            return $this->resolvedAliases[$name];
        }

        if (! isset($this->aliases[$name])) {
            throw new MethodNotExistException('There is no such method or endpoint: '.$name);
        }

        return $this->resolvedAliases[$name] ??= new $this->aliases[$name]();
    }

    /**
     * Method add new alias for endpoint and resolve it
     *
     * @param  string  $name
     * @param  string  $endpointClass
     * @return void
     * @throws MethodNotExistException
     */
    public function addAlias(string $name, string $endpointClass): void
    {
        $this->aliases[$name] = $endpointClass;

        $this->resolveAlias($name);
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
