<?php

namespace BinanceApi\Docs\GeneralInfo;

use BinanceApi\Helper\Math;

/**
 * Filters define trading rules on a symbol or an exchange. Filters come in two forms: symbol filters and exchange filters.
 */
class Filters
{
    public const PRICE_FILTER = 'PRICE_FILTER';
    public const PERCENT_PRICE = 'PERCENT_PRICE';
    // TODO: may be it is not actual [PERCENT_PRICE](https://binance-docs.github.io/apidocs/spot/en/#filters)

    // TODO: Need add [PERCENT_PRICE_BY_SIDE](https://binance-docs.github.io/apidocs/spot/en/#filters)

    public const LOT_SIZE = 'LOT_SIZE';

    // TODO: Need add [MIN_NOTIONAL](https://binance-docs.github.io/apidocs/spot/en/#filters)

    public const NOTIONAL = 'NOTIONAL';

    // TODO: Need add [NOTIONAL](https://binance-docs.github.io/apidocs/spot/en/#filters)

    /**
     * The ICEBERG_PARTS filter defines the maximum parts an iceberg order can have. The number of ICEBERG_PARTS is defined as CEIL(qty / icebergQty).
     */
    public const ICEBERG_PARTS = 'ICEBERG_PARTS';

    // TODO: Need add [ICEBERG_PARTS](https://binance-docs.github.io/apidocs/spot/en/#filters)

    public const MARKET_LOT_SIZE = 'MARKET_LOT_SIZE';
    public const MAX_NUM_ORDERS = 'MAX_NUM_ORDERS';
    public const MAX_NUM_ALGO_ORDERS = 'MAX_NUM_ALGO_ORDERS';
    public const MAX_NUM_ICEBERG_ORDERS = 'MAX_NUM_ICEBERG_ORDERS';
    public const MAX_POSITIONS = 'MAX_POSITIONS';

    // TODO: Need add [TRAILING_DELTA](https://binance-docs.github.io/apidocs/spot/en/#filters)

    // TODO: Need add [Exchange Filters](https://binance-docs.github.io/apidocs/spot/en/#filters)

    /**
     * PRICE_FILTER sum rules
     *
     * - price >= minPrice
     * - price <= maxPrice
     * - price % tickSize == 0
     *
     * @param  float  $price
     * @param  float  $minPrice
     * @param  float  $maxPrice
     * @param  float  $ticketSize
     * @return bool
     */
    public static function priceFilterRule(float $price, float $minPrice, float $maxPrice, float $ticketSize): bool
    {
        return
            static::priceFilterMinPriceRule($price, $minPrice) &&
            static::priceFilterMaxPriceRule($price, $maxPrice) &&
            static::priceFilterTickSizeRule($price, $ticketSize);
    }

    /**
     * PRICE_FILTER minPrice rule
     *
     * - price >= minPrice
     *
     * @param  float  $price
     * @param  float  $minPrice
     * @return bool
     */
    public static function priceFilterMinPriceRule(float $price, float $minPrice): bool
    {
        return $price >= $minPrice || Math::isEqualFloats($price, $minPrice);
    }

    /**
     * PRICE_FILTER maxPrice rule
     *
     * - price <= maxPrice
     *
     * @param  float  $price
     * @param  float  $maxPrice
     * @return bool
     */
    public static function priceFilterMaxPriceRule(float $price, float $maxPrice): bool
    {
        return $price <= $maxPrice || Math::isEqualFloats($price, $maxPrice);
    }

    /**
     * PRICE_FILTER tickSize rule
     *
     * - price % tickSize == 0
     *
     * @param  float  $price
     * @param  float  $ticketSize
     * @return bool
     */
    public static function priceFilterTickSizeRule(float $price, float $ticketSize): bool
    {
        return Math::isDivisionWithoutRemainder($price, $ticketSize);
    }

    /**
     * LOT_SIZE|MARKET_LOT_SIZE sum rules
     *
     * - quantity >= minQty
     * - quantity <= maxQty
     * - quantity % stepSize == 0
     *
     * @param  float  $quantity
     * @param  float  $minQty
     * @param  float  $maxQty
     * @param  float  $stepSize
     * @return bool
     */
    public static function lotSizeRule(float $quantity, float $minQty, float $maxQty, float $stepSize): bool
    {
        return
            static::lotSizeMinQtyRule($quantity, $minQty) &&
            static::lotSizeMaxQtyRule($quantity, $maxQty) &&
            static::lotSizeStepSizeRule($quantity, $stepSize);
    }

    /**
     * LOT_SIZE|MARKET_LOT_SIZE minQty rule
     *
     * - quantity >= minQty
     *
     * @param  float  $quantity
     * @param  float  $minQty
     * @return bool
     */
    public static function lotSizeMinQtyRule(float $quantity, float $minQty): bool
    {
        return $quantity >= $minQty || Math::isEqualFloats($quantity, $minQty);
    }

    /**
     * LOT_SIZE|MARKET_LOT_SIZE maxQty rule
     *
     * - quantity <= maxQty
     *
     * @param  float  $quantity
     * @param  float  $maxQty
     * @return bool
     */
    public static function lotSizeMaxQtyRule(float $quantity, float $maxQty): bool
    {
        return $quantity <= $maxQty || Math::isEqualFloats($quantity, $maxQty);
    }

    /**
     * LOT_SIZE|MARKET_LOT_SIZE stepSize rule
     *
     * - quantity % stepSize == 0
     *
     * @param  float  $quantity
     * @param  float  $stepSize
     * @return bool
     */
    public static function lotSizeStepSizeRule(float $quantity, float $stepSize): bool
    {
        return Math::isDivisionWithoutRemainder($quantity, $stepSize);
    }
}
