<?php
declare(strict_types=1);

namespace Unit\SQLBuilder\Transformation;

use AMB\SQLBuilder\Transformation\NumberToBool;
use UnitTester;

class NumberToBoolCest
{
    public function testInvoke(UnitTester $I)
    {
        $transformation = new NumberToBool();
        $I->assertTrue(($transformation->transform(1)));
        $I->assertTrue(($transformation->transform('1')));
        $I->assertFalse(($transformation->transform(0)));
        $I->assertFalse(($transformation->transform('0')));
    }
}
