<?php

namespace BinanceApi\Spot;

use BinanceApi\Exception\MethodNotExistException;
use BinanceApi\Spot\Docs\GeneralInfo\PublicApiDefinitions;
use BinanceApi\Spot\Docs\MarketDataEndpoint\KlineCandlestickData;
use BinanceApi\Spot\Docs\MarketDataEndpoint\OrderBook;
use BinanceApi\Spot\Docs\MarketDataEndpoint\RecentTradesList;
use BinanceApi\Spot\Docs\SpotAccountTrade\NewOrder;
use BinanceApi\Spot\Docs\WalletEndpoints\Withdraw;

trait BinanceAnalogs
{
    /**
     * Get analogs of some original function and set it
     *
     * @param  string  $name
     * @param  array  $arguments
     * @return void
     */
    protected function getAnalog(string &$name, array &$arguments): void
    {
        try {
            if ($this->binanceOriginal->resolveAlias($name)) {
                return;
            }
        } catch (MethodNotExistException) {

        }

        $name = match ($name) {
            'withdraw' => Withdraw::METHOD,
            'orderbook' => OrderBook::METHOD,
            default => $name,
        };

        $this->orderbookAnalog($name, $arguments);
        $this->recentTradesListAnalog($name, $arguments);
        $this->newOrderAnalog($name, $arguments);
        $this->klineCandlestickDataAnalog($name, $arguments);
    }

    protected function orderbookAnalog(string &$name, array &$arguments): void
    {
        if (str_contains($name, 'orderbook')) {
            array_unshift($arguments, strtoupper(str_replace('orderbook', '', $name)));
            $name = OrderBook::METHOD;
        }
    }

    protected function recentTradesListAnalog(string &$name, array &$arguments): void
    {
        if (str_contains($name, 'trades')) {
            array_unshift($arguments, strtoupper(str_replace('trades', '', $name)));
            $name = RecentTradesList::METHOD;
        }
    }

    protected function newOrderAnalog(string &$name, array &$arguments): void
    {
        if (str_contains($name, 'Order')) {
            $analogArguments[] = array_shift($arguments);
            $analogArguments[] = array_shift($arguments);

            $type = str_replace('Order', '', $name);

            $analogArguments[] = match ($type) {
                'market' => PublicApiDefinitions::ORDER_TYPE_MARKET,
                'limit' => PublicApiDefinitions::ORDER_TYPE_LIMIT,
                'stopLoss' => PublicApiDefinitions::ORDER_TYPE_STOP_LOSS,
                'stopLossLimit' => PublicApiDefinitions::ORDER_TYPE_STOP_LOSS_LIMIT,
                'takeProfit' => PublicApiDefinitions::ORDER_TYPE_TAKE_PROFIT,
                'takeProfitLimit' => PublicApiDefinitions::ORDER_TYPE_TAKE_PROFIT_LIMIT,
                default => $type,
            };

            $analogArguments[] = in_array(
                $analogArguments[2],
                [PublicApiDefinitions::ORDER_TYPE_LIMIT, PublicApiDefinitions::ORDER_TYPE_STOP_LOSS_LIMIT, PublicApiDefinitions::ORDER_TYPE_TAKE_PROFIT_LIMIT]
            )
                ? PublicApiDefinitions::TIME_IN_FORCE_GTC
                : null;

            $arguments = array_merge($analogArguments, $arguments);

            $name = NewOrder::METHOD;
        }
    }

    protected function klineCandlestickDataAnalog(string &$name, array &$arguments): void
    {
        if (str_contains($name, 'Klines')) {
            $analogArguments[] = array_shift($arguments);

            $interval = str_replace('Klines', '', $name);

            $analogArguments[] = match ($interval) {
                'second' => PublicApiDefinitions::KLINE_CHART_INTERVAL_ONE_SECOND,
                'minute' => PublicApiDefinitions::KLINE_CHART_INTERVAL_ONE_MINUTE,
                'threeMinute' => PublicApiDefinitions::KLINE_CHART_INTERVAL_THREE_MINUTES,
                'fiveMinute' => PublicApiDefinitions::KLINE_CHART_INTERVAL_FIVE_MINUTES,
                'fifteenMinute' => PublicApiDefinitions::KLINE_CHART_INTERVAL_FIFTEEN_MINUTES,
                'thirtyMinute' => PublicApiDefinitions::KLINE_CHART_INTERVAL_THIRTY_MINUTES,
                'hour' => PublicApiDefinitions::KLINE_CHART_INTERVAL_ONE_HOUR,
                'twoHour' => PublicApiDefinitions::KLINE_CHART_INTERVAL_TWO_HOURS,
                'fourHour' => PublicApiDefinitions::KLINE_CHART_INTERVAL_FOUR_HOURS,
                'sixHour' => PublicApiDefinitions::KLINE_CHART_INTERVAL_SIX_HOURS,
                'eightHour' => PublicApiDefinitions::KLINE_CHART_INTERVAL_EIGHT_HOURS,
                'twelveHour' => PublicApiDefinitions::KLINE_CHART_INTERVAL_TWELVE_HOURS,
                'day' => PublicApiDefinitions::KLINE_CHART_INTERVAL_ONE_DAY,
                'threeDay' => PublicApiDefinitions::KLINE_CHART_INTERVAL_THREE_DAYS,
                'week' => PublicApiDefinitions::KLINE_CHART_INTERVAL_ONE_WEEK,
                'month' => PublicApiDefinitions::KLINE_CHART_INTERVAL_ONE_MONTH,
                default => $interval,
            };

            $arguments = array_merge($analogArguments, $arguments);

            $name = KlineCandlestickData::METHOD;
        }
    }
}
