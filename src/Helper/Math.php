<?php

namespace BinanceApi\Helper;

class Math
{
    /**
     * @param  float  $a
     * @param  float  $b
     * @param  int  $scale
     * @return bool
     */
    public static function isEqualFloats(float $a, float $b, int $scale = 8): bool
    {
        return bcsub($a, $b, $scale) == 0;
    }

    /**
     * @param  float  $number
     * @param  float  $increment
     * @param  bool  $roundUp
     * @param  int  $scale
     * @return float
     */
    public static function incrementNumber(float $number, float $increment, bool $roundUp = false, int $scale = 8): float
    {
        if ($roundUp) {
            $number = bcadd($number, $increment, $scale);
        }

        return bcmul($increment, bcdiv($number, $increment), $scale);
    }

    /**
     * @param  float  $a
     * @param  float  $b
     * @return bool
     */
    public static function isDivisionWithoutRemainder(float $a, float $b): bool
    {
        return self::isEqualFloats($a, self::incrementNumber($a, $b));
    }
}
