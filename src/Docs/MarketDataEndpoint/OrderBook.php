<?php

namespace BinanceApi\Docs\MarketDataEndpoint;

use BinanceApi\Docs\Const\BinanceApi\Endpoint;
use BinanceApi\Docs\Const\BinanceApi\HasQueryParameters;
use BinanceApi\Docs\Const\BinanceApi\ProcessResponse;
use BinanceApi\Docs\Const\Exception\EndpointQueryException;
use BinanceApi\Docs\GeneralInfo\Const\BanBased;
use BinanceApi\Docs\GeneralInfo\Const\HttpMethod;
use BinanceApi\Docs\GeneralInfo\DataSources;
use BinanceApi\Docs\GeneralInfo\EndpointSecurityType;

/**
 * https://binance-docs.github.io/apidocs/spot/en/#order-book
 *
 * Order Book
 */
readonly class OrderBook implements Endpoint, HasQueryParameters, ProcessResponse
{
    public const METHOD = 'depth';

    public function __construct(
        public string $endpoint = '/api/v3/depth',
        public string $httpMethod = HttpMethod::GET,
        public null|int $weight = null,
        public string $weightBased = BanBased::IP,
        public null|string $dataSource = DataSources::MEMORY,
        public null|string $encryption = null,
        public string $endpointType = EndpointSecurityType::NONE,
        public string $title = 'Order Book',
        public string $description = '',
    ) {
    }

    public function getQuery(null|string $symbol = null, int $limit = 100): array
    {
        if (! $symbol) {
            throw new EndpointQueryException('Symbol is mandatory parameter: https://binance-docs.github.io/apidocs/spot/en/#order-book');
        }

        if ($limit < 1) {
            $limit = 1;
        } elseif ($limit > 5000) {
            $limit = 5000;
        }

        return ['symbol' => $symbol, 'limit' => $limit];
    }

    public function processResponse(array $response): array
    {
        $response['bids'] = array_map(
            function ($bid) {
                [$price, $amount] = $bid;
                return ['price' => $price, 'amount' => $amount];
            },
            $response['bids']
        );

        $response['asks'] = array_map(
            function ($ask) {
                [$price, $amount] = $ask;
                return ['price' => $price, 'amount' => $amount];
            },
            $response['asks']
        );

        return $response;
    }

    public static function exampleResponse(): string
    {
        return json_encode([
            'lastUpdateId' => 1027024,
            'bids' => [
                [
                    '4.00000000',
                    '431.00000000',
                ],
            ],
            'asks' => [
                [
                    '4.00000200',
                    '12.00000000',
                ],
            ]
        ]);
    }
}
