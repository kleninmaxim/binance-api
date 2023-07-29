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
}
