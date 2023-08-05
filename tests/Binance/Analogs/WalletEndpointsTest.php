<?php

namespace BinanceApi\Tests\Binance\Analogs;

use BinanceApi\Spot\Binance;
use BinanceApi\Spot\Docs\GeneralInfo\Signed;
use BinanceApi\Spot\Docs\WalletEndpoints\Withdraw;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class WalletEndpointsTest extends TestCase
{
    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->client = $this->createMock(Client::class);

        $this->binance = new Binance(client: $this->client);
    }

    public function test_withdraw_analog()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('POST'),
                $this->equalTo('https://api.binance.com/sapi/v1/capital/withdraw/apply'),
                $this->callback(function ($options) {
                    return $this->checkSignatureInPostRequest($options) &&
                        $options['form_params']['coin'] == 'USDT' &&
                        $options['form_params']['address'] == 'TPKiaNqAzu2NYkd2ptqcgtp57DVBZ9P7ui' &&
                        $options['form_params']['amount'] == 20;
                }),
            )
            ->willReturn(new Response(body: Withdraw::exampleResponse()));

        $this->binance->setApiKeys('apiKey', 'apiSecret');

        $this->binance->withdraw('USDT', 'TPKiaNqAzu2NYkd2ptqcgtp57DVBZ9P7ui', 20, network: 'TRX');
    }

    protected function checkSignatureInPostRequest($options): bool
    {
        return $options['headers']['X-MBX-APIKEY'] == 'apiKey' &&
            Signed::binanceMicrotime() >= $options['form_params']['timestamp'] &&
            is_string($options['form_params']['signature']) &&
            strlen($options['form_params']['signature']) > 20;
    }
}
