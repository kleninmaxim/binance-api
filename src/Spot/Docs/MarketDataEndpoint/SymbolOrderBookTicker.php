<?php

namespace BinanceApi\Spot\Docs\MarketDataEndpoint;

use BinanceApi\Spot\Docs\Const\BinanceApi\Endpoint;
use BinanceApi\Spot\Docs\Const\BinanceApi\HasQueryParameters;
use BinanceApi\Spot\Docs\GeneralInfo\Const\BanBased;
use BinanceApi\Spot\Docs\GeneralInfo\Const\HttpMethod;
use BinanceApi\Spot\Docs\GeneralInfo\DataSources;
use BinanceApi\Spot\Docs\GeneralInfo\EndpointSecurityType;

/**
 * https://binance-docs.github.io/apidocs/spot/en/#symbol-order-book-ticker
 *
 * Symbol Order Book Ticker
 */
readonly class SymbolOrderBookTicker implements Endpoint, HasQueryParameters
{
    public const METHOD = 'tickerBookTicker';

    public function __construct(
        public string $endpoint = '/api/v3/ticker/bookTicker',
        public string $httpMethod = HttpMethod::GET,
        public null|int $weight = 2,
        public string $weightBased = BanBased::IP,
        public null|string $dataSource = DataSources::MEMORY,
        public null|string $encryption = null,
        public string $endpointType = EndpointSecurityType::NONE,
        public string $title = 'Symbol Order Book Ticker',
        public string $description = 'Best price/qty on the order book for a symbol or symbols.',
    ) {
    }

    public function getQuery(null|string $symbol = null, null|array $symbols = null): array
    {
        $query = [];

        if ($symbol) {
            $query['symbol'] = $symbol;
        }

        if ($symbols) {
            $query['symbols'] = '["' . implode('","', $symbols) . '"]';
        }

        return $query;
    }

    public static function exampleResponse(): array
    {
        return [
            'firstVersion' => json_encode([
                'symbol' => 'LTCBTC',
                'bidPrice' => '4.00000000',
                'bidQty' => '431.00000000',
                'askPrice' => '4.00000200',
                'askQty' => '9.00000000',
            ]),
            'secondVersion' => json_encode([
                [
                    'symbol' => 'LTCBTC',
                    'bidPrice' => '4.00000000',
                    'bidQty' => '431.00000000',
                    'askPrice' => '4.00000200',
                    'askQty' => '9.00000000',
                ],
                [
                    'symbol' => 'ETHBTC',
                    'bidPrice' => '0.07946700',
                    'bidQty' => '9.00000000',
                    'askPrice' => '100000.00000000',
                    'askQty' => '1000.00000000',
                ],
            ]),
        ];
    }
}
