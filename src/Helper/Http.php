<?php

namespace BinanceApi\Helper;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use BinanceApi\Docs\GeneralInfo\Const\HttpMethod;
use Psr\Http\Message\ResponseInterface;

/**
 * @method get(string $url, array $headers = [], array $query = [], array $body = [])
 * @method post(string $url, array $headers = [], array $query = [], array $body = [])
 * @method put(string $url, array $headers = [], array $query = [], array $body = [])
 * @method delete(string $url, array $headers = [], array $query = [], array $body = [])
 */
class Http
{
    public function __construct(protected Client $client)
    {
    }

    /**
     * @throws Exception|GuzzleException
     */
    public function __call(string $name, array $arguments)
    {
        return match ($name) {
            'get' => $this->request(HttpMethod::GET, ...$arguments),
            'post' => $this->request(HttpMethod::POST, ...$arguments),
            'put' => $this->request(HttpMethod::PUT, ...$arguments),
            'delete' => $this->request(HttpMethod::DELETE, ...$arguments),
            default => throw new Exception('There is no such method: {'.$name.'}'),
        };
    }

    /**
     * @throws GuzzleException
     */
    protected function request(string $method, string $url, array $headers = [], array $query = [], array $body = []): ?ResponseInterface
    {
        $options = [];

        if (! empty($headers)) {
            $options['headers'] = $headers;
        }

        if (in_array($method, [HttpMethod::GET, HttpMethod::POST]) && ! empty($query)) {
            $options['query'] = $query;
        }

        if (in_array($method, [HttpMethod::POST, HttpMethod::PUT, HttpMethod::DELETE]) && ! empty($body)) {
            $options['form_params'] = $body;
        }

        return  $this->client->request($method, $url, $options ?? []);
    }
}
