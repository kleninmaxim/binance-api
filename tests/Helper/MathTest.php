<?php

namespace BinanceApi\Tests\Helper;

use BinanceApi\Helper\Math;
use PHPUnit\Framework\TestCase;

class MathTest extends TestCase
{
    public function test_it_is_equal_floats()
    {
        $this->assertTrue(Math::isEqualFloats(12 + 1000.21212, 1012.21212));
        $this->assertTrue(Math::isEqualFloats(17.3 * 29.5, 510.35));
        $this->assertTrue(Math::isEqualFloats(30 / 1200, 0.025));
        $this->assertTrue(Math::isEqualFloats(1000.2121298, 1000.2121298));
    }

    public function test_it_increment_number_correctly()
    {
        $this->assertTrue(Math::isEqualFloats(12.55, Math::incrementNumber(12.559, 0.01)));
        $this->assertTrue(Math::isEqualFloats(12.3, Math::incrementNumber(12.559, 0.3)));
        $this->assertTrue(Math::isEqualFloats(10, Math::incrementNumber(12.559, 5)));
    }

    public function test_it_is_division_without_reminder_correctly()
    {
        $this->assertTrue(Math::isDivisionWithoutRemainder(18, 4.5));
        $this->assertTrue(Math::isDivisionWithoutRemainder(6, 2));
    }

    public function test_it_is_division_without_reminder_not_correctly()
    {
        $this->assertFalse(Math::isDivisionWithoutRemainder(10.1, 0.1));
    }
}
