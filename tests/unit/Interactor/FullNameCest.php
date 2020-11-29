<?php
declare(strict_types=1);

namespace Tests\Unit\Interactor;

use AMB\Interactor\FullName;
use UnitTester;

class FullNameCest
{
    public function testCamelFull(UnitTester $I)
    {
        $data = [
            'first_name'  => 'David',
            'middle_name' => 'Carroll',
            'last_name'   => 'Wright',
            'suffix'      => 'Jr',
        ];
        $expected = 'David Carroll Wright, Jr';
        $actual = (new FullName)($data);
        $I->assertSame($expected, $actual);
    }

    public function testCamelMissing(UnitTester $I)
    {
        $data = [
            'first_name' => 'David',
            'last_name'  => 'Wright',
        ];
        $expected = 'David Wright';
        $actual = (new FullName)($data);
        $I->assertSame($expected, $actual);
    }

    public function testUnderscoreFull(UnitTester $I)
    {
        $data = [
            'first_name'  => 'David',
            'middle_name' => 'Carroll',
            'last_name'   => 'Wright',
            'suffix'      => 'Jr',
        ];
        $expected = 'David Carroll Wright, Jr';
        $actual = (new FullName)($data);
        $I->assertSame($expected, $actual);
    }

    public function testUnderscoreMissing(UnitTester $I)
    {
        $data = [
            'first_name'  => 'David',
            'middle_name' => null,
            'last_name'   => 'Wright',
            'suffix'      => '',
        ];
        $expected = 'David Wright';
        $actual = (new FullName)($data);
        $I->assertSame($expected, $actual);
    }
}
