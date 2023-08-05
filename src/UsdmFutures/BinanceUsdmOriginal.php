<?php

namespace BinanceApi\UsdmFutures;

use BinanceApi\App\BinanceOriginal;
use BinanceApi\App\ResponseHandler\OriginalDecodedHandler;
use BinanceApi\App\ResponseHandler\ResponseHandler;
use BinanceApi\UsdmFutures\Docs\GeneralInfo\GeneralApiInformation;
use GuzzleHttp\Client;

class BinanceUsdmOriginal extends BinanceOriginal
{
    /**
     * @var array|string[] method as a key, value as Endpoint class for binance endpoint
     */
    protected array $aliases = [

    ];

    /**
     * Class construct
     *
     * @param  ResponseHandler  $responseHandler handle the response from binance and return in any result
     * @param  string  $endpoint binance endpoint, by default: https://api.binance.com
     * @param  Client  $client guzzle client: https://docs.guzzlephp.org/en/stable/index.html?highlight=client
     */
    public function __construct(
        ResponseHandler $responseHandler = new OriginalDecodedHandler(),
        string $endpoint = GeneralApiInformation::BASE_ENDPOINT,
        Client $client = new Client(),
    ) {

        parent::__construct($responseHandler, $endpoint, $client);
    }

}
