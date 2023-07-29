<?php

namespace BinanceApi\Tests\Binance\Http;

use BinanceApi\Binance;
use BinanceApi\Docs\Const\BinanceApi\ProcessResponse;
use BinanceApi\Docs\GeneralInfo\Signed;
use BinanceApi\Docs\SpotAccountTrade\AccountInformation;
use BinanceApi\Docs\SpotAccountTrade\AccountTradeList;
use BinanceApi\Docs\SpotAccountTrade\AllOrders;
use BinanceApi\Docs\SpotAccountTrade\CancelAllOpenOrdersOnASymbol;
use BinanceApi\Docs\SpotAccountTrade\CancelAnExistingOrderAndSendANewOrder;
use BinanceApi\Docs\SpotAccountTrade\CancelOco;
use BinanceApi\Docs\SpotAccountTrade\CancelOrder;
use BinanceApi\Docs\SpotAccountTrade\CurrentOpenOrders;
use BinanceApi\Docs\SpotAccountTrade\NewOrder;
use BinanceApi\Docs\SpotAccountTrade\QueryAllOco;
use BinanceApi\Docs\SpotAccountTrade\QueryCurrentOrderCountUsage;
use BinanceApi\Docs\SpotAccountTrade\QueryOco;
use BinanceApi\Docs\SpotAccountTrade\QueryPreventedMatches;
use BinanceApi\Docs\SpotAccountTrade\TestNewOrder;
use BinanceApi\Helper\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class SpotAccountTradeTest extends TestCase
{
    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->client = $this->createMock(Client::class);

        $this->binance = new Binance(client: $this->client);
    }

    public function test_http_test_new_order()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('POST'),
                $this->equalTo('https://api.binance.com/api/v3/order/test'),
                $this->callback(function ($options) {
                    return $this->checkSignatureInPostRequest($options) &&
                        $options['form_params']['symbol'] == 'BTCUSDT' &&
                        $options['form_params']['side'] == 'BUY' &&
                        $options['form_params']['type'] == 'MARKET' &&
                        $options['form_params']['timeInForce'] == 'GTC' &&
                        $options['form_params']['quantity'] == '1' &&
                        $options['form_params']['quoteOrderQty'] == '10' &&
                        $options['form_params']['price'] == '30000' &&
                        $options['form_params']['newClientOrderId'] == 'uniqueIdForOrder' &&
                        $options['form_params']['strategyId'] == '37463720' &&
                        $options['form_params']['strategyType'] == '1000000' &&
                        $options['form_params']['stopPrice'] == '29000' &&
                        $options['form_params']['trailingDelta'] == '10' &&
                        $options['form_params']['icebergQty'] == '1.5' &&
                        $options['form_params']['newOrderRespType'] == 'FULL' &&
                        $options['form_params']['selfTradePreventionMode'] == 'EXPIRE_TAKER' &&
                        $options['form_params']['recvWindow'] == '5000';
                }),
            )
            ->willReturn(new Response(body: TestNewOrder::exampleResponse()));

        $this->binance->setApiKeys('apiKey', 'apiSecret');

        $this->assertEquals(
            json_decode(TestNewOrder::exampleResponse(), true),
            $this->binance->orderTest(
                'BTCUSDT',
                'BUY',
                'MARKET',
                'GTC',
                '1',
                '10',
                '30000',
                'uniqueIdForOrder',
                '37463720',
                '1000000',
                '29000',
                '10',
                '1.5',
                'FULL',
                'EXPIRE_TAKER',
                '5000'
            )['response']['data']
        );
    }

    /**
     * @throws \Exception
     */
    public function test_http_new_order()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('POST'),
                $this->equalTo('https://api.binance.com/api/v3/order'),
                $this->callback(function ($options) {
                    return $this->checkSignatureInPostRequest($options) &&
                        $options['form_params']['symbol'] == 'BTCUSDT' &&
                        $options['form_params']['side'] == 'BUY' &&
                        $options['form_params']['type'] == 'MARKET' &&
                        $options['form_params']['timeInForce'] == 'GTC' &&
                        $options['form_params']['quantity'] == '1' &&
                        $options['form_params']['quoteOrderQty'] == '10' &&
                        $options['form_params']['price'] == '30000' &&
                        $options['form_params']['newClientOrderId'] == 'uniqueIdForOrder' &&
                        $options['form_params']['strategyId'] == '37463720' &&
                        $options['form_params']['strategyType'] == '1000000' &&
                        $options['form_params']['stopPrice'] == '29000' &&
                        $options['form_params']['trailingDelta'] == '10' &&
                        $options['form_params']['icebergQty'] == '1.5' &&
                        $options['form_params']['newOrderRespType'] == 'FULL' &&
                        $options['form_params']['selfTradePreventionMode'] == 'EXPIRE_TAKER' &&
                        $options['form_params']['recvWindow'] == '5000';
                }),
            )
            ->willReturn(new Response(body: NewOrder::exampleResponse()['thirdVersion']));

        $this->binance->setApiKeys('apiKey', 'apiSecret');

        $result = json_decode(NewOrder::exampleResponse()['thirdVersion'], true);

        $result[ProcessResponse::ADDITIONAL_FIELD]['transactTimeDate'] = Carbon::getFullDate($result['transactTime']);

        if (isset($result['workingTime'])) {
            $result[ProcessResponse::ADDITIONAL_FIELD]['workingTimeDate'] = Carbon::getFullDate($result['workingTime']);
        }

        $this->assertEquals(
            $result,
            $this->binance->order(
                'BTCUSDT',
                'BUY',
                'MARKET',
                'GTC',
                '1',
                '10',
                '30000',
                'uniqueIdForOrder',
                '37463720',
                '1000000',
                '29000',
                '10',
                '1.5',
                'FULL',
                'EXPIRE_TAKER',
                '5000'
            )['response']['data']
        );
    }

    /**
     * @throws \Exception
     */
    public function test_http_cancel_order()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('DELETE'),
                $this->equalTo('https://api.binance.com/api/v3/order'),
                $this->callback(function ($options) {
                    return $this->checkSignatureInPostRequest($options) &&
                        $options['form_params']['symbol'] == 'BTCUSDT' &&
                        $options['form_params']['orderId'] == '4' &&
                        $options['form_params']['origClientOrderId'] == 'myOrder1' &&
                        $options['form_params']['newClientOrderId'] == 'cancelMyOrder1' &&
                        $options['form_params']['cancelRestrictions'] == 'ONLY_PARTIALLY_FILLED' &&
                        $options['form_params']['recvWindow'] == '5000';
                }),
            )
            ->willReturn(new Response(body: CancelOrder::exampleResponse()));

        $this->binance->setApiKeys('apiKey', 'apiSecret');

        $result = json_decode(CancelOrder::exampleResponse(), true);

        $result[ProcessResponse::ADDITIONAL_FIELD]['transactTimeDate'] = Carbon::getFullDate($result['transactTime']);

        $this->assertEquals(
            $result,
            $this->binance->cancelOrder(
                'BTCUSDT',
                '4',
                'myOrder1',
                'cancelMyOrder1',
                'ONLY_PARTIALLY_FILLED',
                '5000'
            )['response']['data']
        );
    }

    public function test_http_cancel_all_open_orders_on_symbol()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('DELETE'),
                $this->equalTo('https://api.binance.com/api/v3/openOrders'),
                $this->callback(function ($options) {
                    return $this->checkSignatureInPostRequest($options) &&
                        $options['form_params']['symbol'] == 'BTCUSDT' &&
                        $options['form_params']['recvWindow'] == '5000';
                }),
            )
            ->willReturn(new Response(body: CancelAllOpenOrdersOnASymbol::exampleResponse()));

        $this->binance->setApiKeys('apiKey', 'apiSecret');

        $result = array_map(
            /**
             * @throws \Exception
             */
            function ($item) {
                if (isset($item['transactTime'])) {
                    $item[ProcessResponse::ADDITIONAL_FIELD]['transactTimeDate'] = Carbon::getFullDate($item['transactTime']);
                }

                if (isset($item['transactionTime'])) {
                    $item[ProcessResponse::ADDITIONAL_FIELD]['transactionTimeDate'] = Carbon::getFullDate($item['transactionTime']);
                }

                if (isset($item['orderReports'])) {
                    $item['orderReports'] = array_map(function ($item) {
                        if (isset($item['transactTime'])) {
                            $item[ProcessResponse::ADDITIONAL_FIELD]['transactTimeDate'] = Carbon::getFullDate($item['transactTime']);
                        }

                        return $item;
                    }, $item['orderReports']);
                }

                return $item;
            },
            json_decode(CancelAllOpenOrdersOnASymbol::exampleResponse(), true)
        );

        $this->assertEquals($result, $this->binance->cancelOpenOrders('BTCUSDT', '5000')['response']['data']);
    }

    /**
     * @throws \Exception
     */
    public function test_http_query_order()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('GET'),
                $this->equalTo('https://api.binance.com/api/v3/order'),
                $this->callback(function ($options) {
                    return $this->checkSignatureInGetRequest($options) &&
                        $options['query']['symbol'] == 'BTCUSDT' &&
                        $options['query']['orderId'] == '1' &&
                        $options['query']['origClientOrderId'] == 'myOrder1' &&
                        $options['query']['recvWindow'] == '5000';
                }),
            )
            ->willReturn(new Response(body: CancelAllOpenOrdersOnASymbol::exampleResponse()));

        $this->binance->setApiKeys('apiKey', 'apiSecret');

        $result = json_decode(CancelAllOpenOrdersOnASymbol::exampleResponse(), true);

        if (isset($result['time'])) {
            $result[ProcessResponse::ADDITIONAL_FIELD]['timeDate'] = Carbon::getFullDate($result['time']);
        }

        if (isset($result['updateTime'])) {
            $result[ProcessResponse::ADDITIONAL_FIELD]['updateTimeDate'] = Carbon::getFullDate($result['updateTime']);
        }

        if (isset($result['workingTime'])) {
            $result[ProcessResponse::ADDITIONAL_FIELD]['workingTimeDate'] = Carbon::getFullDate($result['workingTime']);
        }

        $this->assertEquals($result, $this->binance->getOrder('BTCUSDT', 1, 'myOrder1', '5000')['response']['data']);
    }

    /**
     * @throws \Exception
     */
    public function test_http_cancel_an_existing_order_and_send_a_new_order()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('POST'),
                $this->equalTo('https://api.binance.com/api/v3/order/cancelReplace'),
                $this->callback(function ($options) {
                    return $this->checkSignatureInPostRequest($options) &&
                        $options['form_params']['symbol'] == 'BTCUSDT' &&
                        $options['form_params']['side'] == 'BUY' &&
                        $options['form_params']['type'] == 'MARKET' &&
                        $options['form_params']['cancelReplaceMode'] == 'STOP_ON_FAILURE' &&
                        $options['form_params']['timeInForce'] == 'GTC' &&
                        $options['form_params']['quantity'] == '1' &&
                        $options['form_params']['quoteOrderQty'] == '10' &&
                        $options['form_params']['price'] == '30000' &&
                        $options['form_params']['cancelNewClientOrderId'] == 'uniquelyidentifythiscancel' &&
                        $options['form_params']['cancelOrigClientOrderId'] == 'myOrderClientId' &&
                        $options['form_params']['cancelOrderId'] == '123' &&
                        $options['form_params']['newClientOrderId'] == 'uniqueIdForOrder' &&
                        $options['form_params']['strategyId'] == '37463720' &&
                        $options['form_params']['strategyType'] == '1000000' &&
                        $options['form_params']['stopPrice'] == '29000' &&
                        $options['form_params']['trailingDelta'] == '10' &&
                        $options['form_params']['icebergQty'] == '1.5' &&
                        $options['form_params']['newOrderRespType'] == 'FULL' &&
                        $options['form_params']['selfTradePreventionMode'] == 'EXPIRE_TAKER' &&
                        $options['form_params']['cancelRestrictions'] == 'ONLY_NEW' &&
                        $options['form_params']['recvWindow'] == '5000';
                }),
            )
            ->willReturn(new Response(body: CancelAnExistingOrderAndSendANewOrder::exampleResponse()['firstVersion']));

        $this->binance->setApiKeys('apiKey', 'apiSecret');

        $result = json_decode(CancelAnExistingOrderAndSendANewOrder::exampleResponse()['firstVersion'], true);

        if (isset($result['cancelResponse']['transactTime'])) {
            $result['cancelResponse'][ProcessResponse::ADDITIONAL_FIELD]['transactTimeDate'] = Carbon::getFullDate($result['cancelResponse']['transactTime']);
        }

        if (isset($result['newOrderResponse']['transactTime'])) {
            $result['newOrderResponse'][ProcessResponse::ADDITIONAL_FIELD]['transactTimeDate'] = Carbon::getFullDate($result['newOrderResponse']['transactTime']);
        }

        if (isset($result['newOrderResponse']['workingTime'])) {
            $result['newOrderResponse'][ProcessResponse::ADDITIONAL_FIELD]['workingTimeDate'] = Carbon::getFullDate($result['newOrderResponse']['workingTime']);
        }

        $this->assertEquals(
            $result,
            $this->binance->orderCancelReplace(
                'BTCUSDT',
                'BUY',
                'MARKET',
                'STOP_ON_FAILURE',
                'GTC',
                '1',
                '10',
                '30000',
                'uniquelyidentifythiscancel',
                'myOrderClientId',
                123,
                'uniqueIdForOrder',
                '37463720',
                '1000000',
                '29000',
                '10',
                '1.5',
                'FULL',
                'EXPIRE_TAKER',
                'ONLY_NEW',
                '5000'
            )['response']['data']
        );
    }

    public function test_http_current_open_orders()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('GET'),
                $this->equalTo('https://api.binance.com/api/v3/openOrders'),
                $this->callback(function ($options) {
                    return $this->checkSignatureInGetRequest($options) &&
                        $options['query']['symbol'] == 'BTCUSDT' &&
                        $options['query']['recvWindow'] == '5000';
                }),
            )
            ->willReturn(new Response(body: CurrentOpenOrders::exampleResponse()));

        $this->binance->setApiKeys('apiKey', 'apiSecret');

        $result = array_map(/**
         * @throws \Exception
         */ function ($item) {
            if (isset($item['time'])) {
                $item[ProcessResponse::ADDITIONAL_FIELD]['timeDate'] = Carbon::getFullDate($item['time']);
            }

            if (isset($item['updateTime'])) {
                $item[ProcessResponse::ADDITIONAL_FIELD]['updateTimeDate'] = Carbon::getFullDate($item['updateTime']);
            }

            if (isset($item['workingTime'])) {
                $item[ProcessResponse::ADDITIONAL_FIELD]['workingTimeDate'] = Carbon::getFullDate($item['workingTime']);
            }

            return $item;
        }, json_decode(CurrentOpenOrders::exampleResponse(), true));

        $this->assertEquals($result, $this->binance->openOrders('BTCUSDT', 5000)['response']['data']);
    }

    public function test_http_all_orders()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('GET'),
                $this->equalTo('https://api.binance.com/api/v3/allOrders'),
                $this->callback(function ($options) {
                    return $this->checkSignatureInGetRequest($options) &&
                        $options['query']['symbol'] == 'BTCUSDT' &&
                        $options['query']['orderId'] == 1234 &&
                        $options['query']['startTime'] == '1664442078000' &&
                        $options['query']['endTime'] == '1664442078000' &&
                        $options['query']['limit'] == 500 &&
                        $options['query']['recvWindow'] == '5000';
                }),
            )
            ->willReturn(new Response(body: AllOrders::exampleResponse()));

        $this->binance->setApiKeys('apiKey', 'apiSecret');

        $result = array_map(/**
         * @throws \Exception
         */ function ($item) {
            if (isset($item['time'])) {
                $item[ProcessResponse::ADDITIONAL_FIELD]['timeDate'] = Carbon::getFullDate($item['time']);
            }

            if (isset($item['updateTime'])) {
                $item[ProcessResponse::ADDITIONAL_FIELD]['updateTimeDate'] = Carbon::getFullDate($item['updateTime']);
            }

            if (isset($item['workingTime'])) {
                $item[ProcessResponse::ADDITIONAL_FIELD]['workingTimeDate'] = Carbon::getFullDate($item['workingTime']);
            }

            return $item;
        }, json_decode(AllOrders::exampleResponse(), true));

        $this->assertEquals($result, $this->binance->allOrders('BTCUSDT', 1234, 1664442078000, 1664442078000, recvWindow:  5000)['response']['data']);
    }

    public function test_http_new_oco()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('POST'),
                $this->equalTo('https://api.binance.com/api/v3/order/oco'),
                $this->callback(function ($options) {
                    return $this->checkSignatureInPostRequest($options) &&
                        $options['form_params']['symbol'] == 'BTCUSDT' &&
                        $options['form_params']['listClientOrderId'] == '1234' &&
                        $options['form_params']['side'] == 'BUY' &&
                        $options['form_params']['quantity'] == 1 &&
                        $options['form_params']['limitClientOrderId'] == 'uniqueOrderId' &&
                        $options['form_params']['limitStrategyId'] == 'strategyId' &&
                        $options['form_params']['limitStrategyType'] == 'strategyType' &&
                        $options['form_params']['price'] == '30000' &&
                        $options['form_params']['limitIcebergQty'] == '0.4' &&
                        $options['form_params']['trailingDelta'] == '10' &&
                        $options['form_params']['stopClientOrderId'] == 'auniquestopclientid' &&
                        $options['form_params']['stopPrice'] == '31000' &&
                        $options['form_params']['stopStrategyId'] == 'auniquestopstrategyid' &&
                        $options['form_params']['stopStrategyType'] == '10000' &&
                        $options['form_params']['stopLimitPrice'] == '32000' &&
                        $options['form_params']['stopIcebergQty'] == '0.5' &&
                        $options['form_params']['stopLimitTimeInForce'] == 'GTC' &&
                        $options['form_params']['newOrderRespType'] == '{}' &&
                        $options['form_params']['selfTradePreventionMode'] == 'EXPIRE_TAKER' &&
                        $options['form_params']['recvWindow'] == '5000';
                }),
            )
            ->willReturn(new Response(body: AllOrders::exampleResponse()));

        $this->binance->setApiKeys('apiKey', 'apiSecret');

        $this->assertEquals(
            json_decode(AllOrders::exampleResponse(), true),
            $this->binance->orderOco(
                'BTCUSDT',
                1234,
                'BUY',
                1,
                'uniqueOrderId',
                'strategyId',
                'strategyType',
                '30000',
                '0.4',
                '10',
                'auniquestopclientid',
                '31000',
                'auniquestopstrategyid',
                '10000',
                '32000',
                '0.5',
                'GTC',
                '{}',
                'EXPIRE_TAKER',
                5000
            )['response']['data']
        );
    }

    public function test_http_cancel_oco()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('DELETE'),
                $this->equalTo('https://api.binance.com/api/v3/orderList'),
                $this->callback(function ($options) {
                    return $this->checkSignatureInPostRequest($options) &&
                        $options['form_params']['symbol'] == 'BTCUSDT' &&
                        $options['form_params']['orderListId'] == '1234' &&
                        $options['form_params']['listClientOrderId'] == 'clientorderid' &&
                        $options['form_params']['newClientOrderId'] == 'newclientorderid' &&
                        $options['form_params']['recvWindow'] == '5000';
                }),
            )
            ->willReturn(new Response(body: CancelOco::exampleResponse()));

        $this->binance->setApiKeys('apiKey', 'apiSecret');

        $this->assertEquals(
            json_decode(CancelOco::exampleResponse(), true),
            $this->binance->cancelOrderList('BTCUSDT', 1234, 'clientorderid', 'newclientorderid', 5000)['response']['data']
        );
    }

    public function test_http_query_oco()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('GET'),
                $this->equalTo('https://api.binance.com/api/v3/orderList'),
                $this->callback(function ($options) {
                    return $this->checkSignatureInGetRequest($options) &&
                        $options['query']['orderListId'] == '27' &&
                        $options['query']['origClientOrderId'] == 'h2USkA5YQpaXHPIrkd96xE' &&
                        $options['query']['recvWindow'] == '5000';
                }),
            )
            ->willReturn(new Response(body: QueryOco::exampleResponse()));

        $this->binance->setApiKeys('apiKey', 'apiSecret');

        $this->assertEquals(
            json_decode(QueryOco::exampleResponse(), true),
            $this->binance->orderList('27', 'h2USkA5YQpaXHPIrkd96xE', 5000)['response']['data']
        );
    }

    public function test_http_query_all_oco()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('GET'),
                $this->equalTo('https://api.binance.com/api/v3/allOrderList'),
                $this->callback(function ($options) {
                    return $this->checkSignatureInGetRequest($options) &&
                        $options['query']['fromId'] == '27' &&
                        $options['query']['startTime'] == '1565245913407' &&
                        $options['query']['endTime'] == '1565245913407' &&
                        $options['query']['limit'] == '50' &&
                        $options['query']['recvWindow'] == '5000';
                }),
            )
            ->willReturn(new Response(body: QueryAllOco::exampleResponse()));

        $this->binance->setApiKeys('apiKey', 'apiSecret');

        $this->assertEquals(
            json_decode(QueryAllOco::exampleResponse(), true),
            $this->binance->allOrderList('27', '1565245913407', '1565245913407', 50, 5000)['response']['data']
        );
    }

    public function test_http_query_open_oco()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('GET'),
                $this->equalTo('https://api.binance.com/api/v3/openOrderList'),
                $this->callback(function ($options) {
                    return $this->checkSignatureInGetRequest($options) && $options['query']['recvWindow'] == '5000';
                }),
            )
            ->willReturn(new Response(body: QueryAllOco::exampleResponse()));

        $this->binance->setApiKeys('apiKey', 'apiSecret');

        $this->assertEquals(
            json_decode(QueryAllOco::exampleResponse(), true),
            $this->binance->openOrderList(5000)['response']['data']
        );
    }

    public function test_http_account_information()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('GET'),
                $this->equalTo('https://api.binance.com/api/v3/account'),
                $this->callback(function ($options) {
                    return $this->checkSignatureInGetRequest($options) && $options['query']['recvWindow'] == '5000';
                }),
            )
            ->willReturn(new Response(body: AccountInformation::exampleResponse()));

        $this->binance->setApiKeys('apiKey', 'apiSecret');

        $this->assertEquals(
            json_decode(AccountInformation::exampleResponse(), true),
            $this->binance->account(5000)['response']['data']
        );
    }

    public function test_http_account_trade_list()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('GET'),
                $this->equalTo('https://api.binance.com/api/v3/myTrades'),
                $this->callback(function ($options) {
                    return $this->checkSignatureInGetRequest($options) &&
                        $options['query']['symbol'] == 'BTCUSDT' &&
                        $options['query']['orderId'] == '28457' &&
                        $options['query']['startTime'] == '1499865549590' &&
                        $options['query']['endTime'] == '1499865549590' &&
                        $options['query']['fromId'] == '26000' &&
                        $options['query']['limit'] == '50' &&
                        $options['query']['recvWindow'] == '5000';
                }),
            )
            ->willReturn(new Response(body: AccountTradeList::exampleResponse()));

        $this->binance->setApiKeys('apiKey', 'apiSecret');

        $this->assertEquals(
            json_decode(AccountTradeList::exampleResponse(), true),
            $this->binance->myTrades('BTCUSDT', 28457, '1499865549590', 1499865549590, '26000', 50, 5000)['response']['data']
        );
    }

    public function test_http_query_current_order_count_usage()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('GET'),
                $this->equalTo('https://api.binance.com/api/v3/rateLimit/order'),
                $this->callback(function ($options) {
                    return $this->checkSignatureInGetRequest($options) && $options['query']['recvWindow'] == '5000';
                }),
            )
            ->willReturn(new Response(body: QueryCurrentOrderCountUsage::exampleResponse()));

        $this->binance->setApiKeys('apiKey', 'apiSecret');

        $this->assertEquals(
            json_decode(QueryCurrentOrderCountUsage::exampleResponse(), true),
            $this->binance->rateLimitOrder(5000)['response']['data']
        );
    }

    public function test_http_query_prevented_matches()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('GET'),
                $this->equalTo('https://api.binance.com/api/v3/myPreventedMatches'),
                $this->callback(function ($options) {
                    return $this->checkSignatureInGetRequest($options) &&
                        $options['query']['symbol'] == 'BTCUSDT' &&
                        $options['query']['preventedMatchId'] == '2' &&
                        $options['query']['orderId'] == '3' &&
                        $options['query']['fromPreventedMatchId'] == '1' &&
                        $options['query']['limit'] == '50' &&
                        $options['query']['recvWindow'] == '5000';
                }),
            )
            ->willReturn(new Response(body: QueryPreventedMatches::exampleResponse()));

        $this->binance->setApiKeys('apiKey', 'apiSecret');

        $this->assertEquals(
            json_decode(QueryPreventedMatches::exampleResponse(), true),
            $this->binance->myPreventedMatches('BTCUSDT', 2, 3, 1, 50, 5000)['response']['data']
        );
    }

    protected function checkSignatureInGetRequest($options): bool
    {
        return $options['headers']['X-MBX-APIKEY'] == 'apiKey' &&
            Signed::binanceMicrotime() >= $options['query']['timestamp'] &&
            is_string($options['query']['signature']) &&
            strlen($options['query']['signature']) > 20;
    }

    protected function checkSignatureInPostRequest($options): bool
    {
        return $options['headers']['X-MBX-APIKEY'] == 'apiKey' &&
            Signed::binanceMicrotime() >= $options['form_params']['timestamp'] &&
            is_string($options['form_params']['signature']) &&
            strlen($options['form_params']['signature']) > 20;
    }
}
