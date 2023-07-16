<?php

namespace BinanceApi\Tests\Helper;

use BinanceApi\Helper\Carbon;
use PHPUnit\Framework\TestCase;

class CarbonTest extends TestCase
{
    public function test_it_format_from_microtime_to_date_correct()
    {
        $this->assertEquals('Tue, 11 Jul 2023 19:05:03 UTC', Carbon::getFullDate('1689102303379'));
    }

    public function test_it_format_from_microtime_to_date_correct_with_another_timezone()
    {
        $this->assertEquals('Tue, 11 Jul 2023 15:07:30 America/New_York', Carbon::getFullDate('1689102449921', 'America/New_York'));
    }
}
