<?php

namespace BinanceApi\Helper;

class Math
{
    public static function isEqualFloats(float $a, float $b, int $decimals = 8): bool
    {
        $intA = intval($a);
        $intB = intval($b);

        return
            $intA == $intB &&
            bccomp(number_format($a - $intA, $decimals), number_format($b - $intB, $decimals), $decimals) == 0;
    }

    /**
     * Be careful with that function, it can get a non-correct result
     *
     * @param  float  $number
     * @param  float  $increment
     * @param  bool  $roundUp
     * @return float
     */
    public static function incrementNumber(float $number, float $increment, bool $roundUp = false): float
    {
        if ($roundUp) {
            $number += $increment;
        }

        return $increment * floor($number / $increment);
    }

    /**
     * Be careful with that function, it can get a non-correct result
     *
     * @param  float  $a
     * @param  float  $b
     * @return bool
     */
    public static function isDivisionWithoutRemainder(float $a, float $b): bool
    {
        return self::isEqualFloats($a, self::incrementNumber($a, $b));
    }
}
